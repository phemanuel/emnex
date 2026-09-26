<?php

namespace App\Services;

use App\Models\Company;
use App\Models\Storefront;
use App\Models\User;
use Illuminate\Support\Str;

class StorefrontSetupService
{   
    /**
     * Create the Storefront for a company.
     */
    public function createForCompany(
        Company $company,
        ?User $creator = null,
        array $attributes = []
    ): Storefront {

        /*
         * The business model currently permits
         * only one Storefront per company.
         */
        $existing = Storefront::query()
            ->where('company_id', $company->id)
            ->first();

        if ($existing) {
            return $existing;
        }

        $name = trim(
            (string) (
                $attributes['name']
                ?? $company->name
            )
        );

        if ($name === '') {
            $name = 'Online Store';
        }

        return Storefront::create([
            'company_id' => $company->id,

            'name' => $name,

            'slug' => $this->generateSlug(
                $attributes['slug']
                ?? $name
            ),

            'status' => 'Setup',

            'enabled_at' => null,

            'created_by' => $creator?->id,

            'updated_by' => null,
        ]);
    }

    /**
     * Generate a globally unique public Storefront slug.
     */
    protected function generateSlug(string $value): string
    {
        $baseSlug = Str::slug($value);

        if ($baseSlug === '') {
            $baseSlug = 'store';
        }

        $slug = $baseSlug;
        $counter = 1;

        while (
            Storefront::query()
                ->where('slug', $slug)
                ->exists()
        ) {
            $counter++;

            $slug =
                $baseSlug .
                '-' .
                $counter;
        }

        return $slug;
    }
}