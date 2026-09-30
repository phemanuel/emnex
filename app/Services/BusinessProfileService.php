<?php

namespace App\Services;

use App\Models\Company;
use App\Models\CompanyBusinessProfile;
use Illuminate\Support\Arr;

class BusinessProfileService
{
    /*
    |--------------------------------------------------------------------------
    | Product Field Modes
    |--------------------------------------------------------------------------
    */

    public const FIELD_HIDDEN = 'hidden';

    public const FIELD_OPTIONAL = 'optional';

    public const FIELD_REQUIRED = 'required';


    /*
    |--------------------------------------------------------------------------
    | Business Types
    |--------------------------------------------------------------------------
    |
    | Returns the business types EMNEX currently supports.
    |
    | This means onboarding and any future company settings page no longer
    | need to maintain their own hardcoded business type lists.
    |
    */

    public function businessTypes(): array
    {
        return array_keys(
            config(
                'business_profiles.types',
                []
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Resolve Profile From Business Type
    |--------------------------------------------------------------------------
    */

    public function profileKeyForBusinessType(
        ?string $businessType
    ): string {

        $types =
            config(
                'business_profiles.types',
                []
            );

        $profileKey =
            $businessType !== null
                ? ($types[$businessType] ?? null)
                : null;


        if (
            $profileKey &&
            $this->isValidProfileKey(
                $profileKey
            )
        ) {

            return $profileKey;
        }


        return $this->defaultProfileKey();
    }


    /*
    |--------------------------------------------------------------------------
    | Resolve Company's Profile Key
    |--------------------------------------------------------------------------
    |
    | Priority:
    |
    | 1. Persisted company_business_profiles.profile_key
    | 2. Company business_type mapping
    | 3. Platform default profile
    |
    | Existing companies therefore work even before they have a profile row.
    |
    */

    public function profileKey(
        Company $company
    ): string {

        $businessProfile =
            $this->businessProfileRecord(
                $company
            );


        if (
            $businessProfile &&
            $this->isValidProfileKey(
                $businessProfile->profile_key
            )
        ) {

            return $businessProfile->profile_key;
        }


        return $this->profileKeyForBusinessType(
            $company->business_type
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Profile Label
    |--------------------------------------------------------------------------
    */

    public function profileLabel(
        Company $company
    ): string {

        $profileKey =
            $this->profileKey(
                $company
            );


        return (string) config(
            "business_profiles.profiles.{$profileKey}.label",
            $profileKey
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Resolved Capabilities
    |--------------------------------------------------------------------------
    |
    | Resolution order:
    |
    | Platform defaults
    |       ↓
    | Business profile
    |       ↓
    | Company-specific overrides
    |
    */

    public function capabilities(
        Company $company
    ): array {

        $defaults =
            config(
                'business_profiles.defaults',
                []
            );


        $profileKey =
            $this->profileKey(
                $company
            );


        $profile =
            config(
                "business_profiles.profiles.{$profileKey}",
                []
            );


        /*
        |--------------------------------------------------------------------------
        | Remove Presentation Metadata
        |--------------------------------------------------------------------------
        |
        | "label" describes the profile itself.
        | It is not an operational capability.
        |
        */

        unset(
            $profile['label']
        );


        $capabilities =
            array_replace_recursive(
                $defaults,
                $profile
            );


        $businessProfile =
            $this->businessProfileRecord(
                $company
            );


        $overrides =
            $businessProfile
                ? (
                    $businessProfile
                        ->capability_overrides
                    ?? []
                )
                : [];


        return $this->applyOverrides(
            $capabilities,
            $overrides
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Read Capability
    |--------------------------------------------------------------------------
    |
    | Example:
    |
    | $service->get(
    |     $company,
    |     'product.track_stock.default'
    | );
    |
    */

    public function get(
        Company $company,
        string $key,
        mixed $default = null
    ): mixed {

        return data_get(
            $this->capabilities(
                $company
            ),
            $key,
            $default
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Product Field Mode
    |--------------------------------------------------------------------------
    |
    | Example:
    |
    | $service->productFieldMode(
    |     $company,
    |     'expiry_date'
    | );
    |
    */

    public function productFieldMode(
        Company $company,
        string $field
    ): string {

        $mode =
            $this->get(
                $company,
                "product.fields.{$field}",
                self::FIELD_OPTIONAL
            );


        if (
            !in_array(
                $mode,
                [
                    self::FIELD_HIDDEN,
                    self::FIELD_OPTIONAL,
                    self::FIELD_REQUIRED,
                ],
                true
            )
        ) {

            return self::FIELD_OPTIONAL;
        }


        return $mode;
    }


    /*
    |--------------------------------------------------------------------------
    | Product Field Helpers
    |--------------------------------------------------------------------------
    */

    public function productFieldVisible(
        Company $company,
        string $field
    ): bool {

        return $this->productFieldMode(
            $company,
            $field
        ) !== self::FIELD_HIDDEN;
    }


    public function productFieldRequired(
        Company $company,
        string $field
    ): bool {

        return $this->productFieldMode(
            $company,
            $field
        ) === self::FIELD_REQUIRED;
    }


    public function productFieldOptional(
        Company $company,
        string $field
    ): bool {

        return $this->productFieldMode(
            $company,
            $field
        ) === self::FIELD_OPTIONAL;
    }


    /*
    |--------------------------------------------------------------------------
    | Product Stock Behaviour
    |--------------------------------------------------------------------------
    */

    public function productTracksStockByDefault(
        Company $company
    ): bool {

        return (bool) $this->get(
            $company,
            'product.track_stock.default',
            true
        );
    }


    public function productStockTrackingIsChangeable(
        Company $company
    ): bool {

        return (bool) $this->get(
            $company,
            'product.track_stock.changeable',
            false
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Initialize Company Profile
    |--------------------------------------------------------------------------
    |
    | Intended for onboarding.
    |
    | This deliberately uses firstOrCreate rather than updateOrCreate.
    |
    | Once a company has an operating profile, changing the descriptive
    | business_type value must not silently replace the company's profile.
    |
    */

    public function initializeForCompany(
        Company $company
    ): CompanyBusinessProfile {

        $businessProfile =
            $company
                ->businessProfile()
                ->firstOrCreate(
                    [],
                    [
                        'profile_key' =>
                            $this->profileKeyForBusinessType(
                                $company->business_type
                            ),

                        'capability_overrides' =>
                            null,
                    ]
                );


        /*
        |--------------------------------------------------------------------------
        | Refresh Loaded Relationship
        |--------------------------------------------------------------------------
        */

        $company->setRelation(
            'businessProfile',
            $businessProfile
        );


        return $businessProfile;
    }


    /*
    |--------------------------------------------------------------------------
    | Company Overrides
    |--------------------------------------------------------------------------
    |
    | Primary persisted format:
    |
    | {
    |   "product.fields.sku": "required",
    |   "product.fields.weight": "hidden"
    | }
    |
    | Nested arrays are also accepted so the service remains tolerant if
    | configuration is ever written in nested form.
    |
    */

    protected function applyOverrides(
        array $capabilities,
        array $overrides
    ): array {

        foreach (
            $overrides as
            $key => $value
        ) {

            /*
            |--------------------------------------------------------------------------
            | Dot Notation
            |--------------------------------------------------------------------------
            */

            if (
                is_string($key) &&
                str_contains(
                    $key,
                    '.'
                )
            ) {

                Arr::set(
                    $capabilities,
                    $key,
                    $value
                );

                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | Nested Configuration
            |--------------------------------------------------------------------------
            */

            if (
                is_array($value) &&
                isset($capabilities[$key]) &&
                is_array(
                    $capabilities[$key]
                )
            ) {

                $capabilities[$key] =
                    array_replace_recursive(
                        $capabilities[$key],
                        $value
                    );

                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | Direct Value
            |--------------------------------------------------------------------------
            */

            $capabilities[$key] =
                $value;
        }


        return $capabilities;
    }


    /*
    |--------------------------------------------------------------------------
    | Business Profile Record
    |--------------------------------------------------------------------------
    */

    protected function businessProfileRecord(
        Company $company
    ): ?CompanyBusinessProfile {

        if (
            $company->relationLoaded(
                'businessProfile'
            )
        ) {

            return $company->businessProfile;
        }


        return $company
            ->businessProfile()
            ->first();
    }


    /*
    |--------------------------------------------------------------------------
    | Profile Validation
    |--------------------------------------------------------------------------
    */

    protected function isValidProfileKey(
        string $profileKey
    ): bool {

        return array_key_exists(
            $profileKey,
            config(
                'business_profiles.profiles',
                []
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Default Profile
    |--------------------------------------------------------------------------
    */

    protected function defaultProfileKey(): string
    {
        $default =
            (string) config(
                'business_profiles.default_profile',
                'general_retail'
            );


        if (
            $this->isValidProfileKey(
                $default
            )
        ) {

            return $default;
        }


        $profiles =
            config(
                'business_profiles.profiles',
                []
            );


        return array_key_first(
            $profiles
        ) ?? 'general_retail';
    }
}