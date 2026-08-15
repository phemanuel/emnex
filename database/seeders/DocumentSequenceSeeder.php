<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\DocumentSequence;
use Illuminate\Database\Seeder;

class DocumentSequenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $company = Company::first();

        if (!$company) {
            $this->command->error('Company not found. Please run CompanySeeder first.');
            return;
        }

        $documents = [

            ['document_type' => 'category',         'prefix' => 'CAT'],
            ['document_type' => 'product',          'prefix' => 'PRD'],
            ['document_type' => 'customer',         'prefix' => 'CUS'],
            ['document_type' => 'supplier',         'prefix' => 'SUP'],
            ['document_type' => 'order',            'prefix' => 'ORD'],
            ['document_type' => 'payment',          'prefix' => 'PAY'],
            ['document_type' => 'purchase',         'prefix' => 'PUR'],
            ['document_type' => 'purchase_return',  'prefix' => 'PRN'],
            ['document_type' => 'sales_return',     'prefix' => 'SRN'],
            ['document_type' => 'stock_movement',   'prefix' => 'STM'],
            ['document_type' => 'stock_adjustment', 'prefix' => 'ADJ'],
            ['document_type' => 'stock_transfer',   'prefix' => 'ST'],
            ['document_type' => 'stock_count',      'prefix' => 'SC'], 
            ['document_type' => 'expense',          'prefix' => 'EXP'],
            ['document_type' => 'unit',             'prefix' => 'UNT'],
            ['document_type' => 'tax',              'prefix' => 'TAX'],
            ['document_type' => 'discount',         'prefix' => 'DIS'],

        ];

        foreach ($documents as $document) {

            DocumentSequence::updateOrCreate(

                [
                    'company_id'    => $company->id,
                    'document_type' => $document['document_type'],
                ],

                [
                    'company_id'         => $company->id,
                    'document_type'      => $document['document_type'],
                    'prefix'             => $document['prefix'],
                    'suffix'             => null,
                    'separator'          => '-',
                    'current_number'     => 1,
                    'number_length'      => 6,
                    'reset_frequency'    => 'Never',
                    'status'             => true,
                ]

            );

        }
    }
}