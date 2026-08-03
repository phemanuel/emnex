<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\DocumentSequence;
use App\Models\Unit;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $company = Company::first();

        if (! $company) {

            $this->command->error(
                'Company not found. Please run CompanySeeder first.'
            );

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Get Unit Document Sequence
        |--------------------------------------------------------------------------
        */

        $sequence = DocumentSequence::where(
            'company_id',
            $company->id
        )
        ->where(
            'document_type',
            'unit'
        )
        ->first();

        if (! $sequence) {

            $this->command->error(
                'Unit document sequence not found.'
            );

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Start from current document number
        |--------------------------------------------------------------------------
        */

        $currentNo = $sequence->current_number;

        /*
        |--------------------------------------------------------------------------
        | Default Units
        |--------------------------------------------------------------------------
        */

        $units = [

            [
                'name'       => 'Piece',
                'short_name' => 'PCS',
            ],

            [
                'name'       => 'Pack',
                'short_name' => 'PK',
            ],

            [
                'name'       => 'Carton',
                'short_name' => 'CTN',
            ],

            [
                'name'       => 'Bottle',
                'short_name' => 'BTL',
            ],

            [
                'name'       => 'Can',
                'short_name' => 'CAN',
            ],

            [
                'name'       => 'Kilogram',
                'short_name' => 'KG',
            ],

            [
                'name'       => 'Gram',
                'short_name' => 'G',
            ],

            [
                'name'       => 'Litre',
                'short_name' => 'LTR',
            ],

            [
                'name'       => 'Millilitre',
                'short_name' => 'ML',
            ],

            [
                'name'       => 'Dozen',
                'short_name' => 'DOZ',
            ],

            [
                'name'       => 'Bag',
                'short_name' => 'BAG',
            ],

            [
                'name'       => 'Roll',
                'short_name' => 'ROL',
            ],

            [
                'name'       => 'Box',
                'short_name' => 'BOX',
            ],

        ];

        /*
        |--------------------------------------------------------------------------
        | Seed Units
        |--------------------------------------------------------------------------
        */

        foreach ($units as $data) {

            $unit = Unit::withTrashed()

                ->where(
                    'company_id',
                    $company->id
                )

                ->where(
                    'name',
                    $data['name']
                )

                ->first();

            /*
            |--------------------------------------------------------------------------
            | Existing Record
            |--------------------------------------------------------------------------
            */

            if ($unit) {

                if ($unit->trashed()) {

                    $unit->restore();

                }

                /*
                |--------------------------------------------------------------------------
                | Generate code only if missing
                |--------------------------------------------------------------------------
                */

                if (empty($unit->unit_code)) {

                    $currentNo++;

                    $unit->unit_code = sprintf(

                        '%s%0'.$sequence->number_length.'d',

                        $sequence->prefix,

                        $currentNo

                    );

                }

                $unit->short_name = $data['short_name'];

                $unit->status = true;               

                $unit->save();
            }

            /*
            |--------------------------------------------------------------------------
            | New Record
            |--------------------------------------------------------------------------
            */

            else {

                $currentNo++;

                Unit::create([

                    'company_id' => $company->id,

                    'unit_code' => sprintf(

                        '%s%0'.$sequence->number_length.'d',

                        $sequence->prefix,

                        $currentNo

                    ),

                    'name' => $data['name'],

                    'short_name' => $data['short_name'],

                    'status' => true,                   

                ]);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Synchronize Document Sequence
        |--------------------------------------------------------------------------
        */

        $sequence->update([

            'current_number' => $currentNo,

        ]);

        $this->command->info(
            'Units seeded successfully.'
        );
    }
}