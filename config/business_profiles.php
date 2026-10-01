<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Profile
    |--------------------------------------------------------------------------
    |
    | Used when a company has no resolvable profile.
    |
    */

    'default_profile' => 'general_retail',


    /*
    |--------------------------------------------------------------------------
    | Business Types
    |--------------------------------------------------------------------------
    |
    | These are the values presented during onboarding.
    |
    | The value on the right is the EMNEX operating profile applied to that
    | business type.
    |
    */

    'types' => [

        'Retail Store' =>
            'general_retail',

        'Supermarket' =>
            'grocery',

        'Convenience Store' =>
            'grocery',

        'Mini Mart' =>
            'grocery',

        'Grocery Store' =>
            'grocery',

        'Pharmacy' =>
            'pharmacy',

        'Electronics Store' =>
            'electronics',

        'Mobile & Digital Accessories' =>
            'electronics',

        'Fashion & Clothing' =>
            'fashion',

        'Beauty & Cosmetics' =>
            'beauty',

        'Restaurant' =>
            'food_service',

        'Cafe & Coffee Shop' =>
            'food_service',

        'Bakery' =>
            'food_service',

        'Fast Food' =>
            'food_service',

        'Wholesale' =>
            'wholesale',

        'Distributor' =>
            'wholesale',

        'Hardware & Building Materials' =>
            'specialty_retail',

        'Auto Parts' =>
            'specialty_retail',

        'Furniture & Home Goods' =>
            'specialty_retail',

        'General Merchandise' =>
            'general_retail',

        'Other' =>
            'general_retail',

    ],


    /*
    |--------------------------------------------------------------------------
    | Platform Defaults
    |--------------------------------------------------------------------------
    |
    | Profiles inherit these values unless they explicitly override them.
    |
    | Product field modes:
    |
    | hidden   = field does not apply to the business by default
    | optional = field is available but not mandatory
    | required = field must contain a value
    |
    */

    'defaults' => [

        'product' => [

             /*
            |--------------------------------------------------------------------------
            | Product Images
            |--------------------------------------------------------------------------
            |
            | "enabled" controls whether products can have images.
            |
            | "multiple" controls whether more than one image may be uploaded.
            |
            | "max_images" is the maximum number of images a product may have,
            | including the primary image.
            |
            */

            'images' => [

                'enabled' =>
                    true,

                'multiple' =>
                    false,

                'max_images' =>
                    1,

            ],

            'track_stock' => [
                'default' => true,

                /*
                | We are deliberately keeping this locked initially.
                |
                | POS, Inventory, Purchasing and Storefront must all respect
                | non-stock products before companies can freely disable stock
                | tracking.
                */
                'changeable' => true,
            ],

            'fields' => [

                'product_code' =>
                    'required',

                'name' =>
                    'required',

                'product_category_id' =>
                    'required',

                'description' =>
                    'optional',

                'image' =>
                    'optional',

                'sku' =>
                    'optional',

                'barcode' =>
                    'optional',

                'qr_code' =>
                    'optional',

                'unit_id' =>
                    'optional',

                'brand' =>
                    'optional',

                'manufacturer' =>
                    'optional',

                'cost_price' =>
                    'required',

                'selling_price' =>
                    'required',

                'tax_rate_id' =>
                    'optional',

                'discount_id' =>
                    'optional',

                'minimum_stock' =>
                    'optional',

                'maximum_stock' =>
                    'optional',

                'opening_stock' =>
                    'optional',

                'weight' =>
                    'optional',

                'expiry_date' =>
                    'optional',

            ],

        ],

    ],


    /*
    |--------------------------------------------------------------------------
    | Business Profiles
    |--------------------------------------------------------------------------
    |
    | Only differences from the platform defaults need to be declared here.
    |
    */

    'profiles' => [

        /*
        |--------------------------------------------------------------------------
        | General Retail
        |--------------------------------------------------------------------------
        */

        'general_retail' => [

            'label' =>
                'General Retail',

            'product' => [

                'images' => [

                    'enabled' =>
                        true,

                    'multiple' =>
                        true,

                    'max_images' =>
                        5,

                ],


                'track_stock' => [
                    'default' => true,
                    'changeable' => true,
                ],

                'fields' => [

                    'unit_id' =>
                        'optional',

                    'expiry_date' =>
                        'optional',

                ],

            ],

        ],


        /*
        |--------------------------------------------------------------------------
        | Grocery / Supermarket
        |--------------------------------------------------------------------------
        */

        'grocery' => [

            'label' =>
                'Supermarket & Grocery',

            'product' => [

                'images' => [

                    'enabled' =>
                        true,

                    'multiple' =>
                        true,

                    'max_images' =>
                        3,

                ],

                'track_stock' => [
                    'default' => true,
                    'changeable' => false,
                ],

                'fields' => [

                    'unit_id' =>
                        'required',

                    'barcode' =>
                        'optional',

                    'expiry_date' =>
                        'optional',

                    'minimum_stock' =>
                        'optional',

                    'maximum_stock' =>
                        'optional',

                    'opening_stock' =>
                        'optional',

                ],

            ],

        ],


        /*
        |--------------------------------------------------------------------------
        | Pharmacy
        |--------------------------------------------------------------------------
        |
        | Pharmacy remains separate because future batch and expiry behaviour
        | will likely be stronger than ordinary grocery inventory.
        |
        */

        'pharmacy' => [

            'label' =>
                'Pharmacy',

            'product' => [

                'images' => [

                        'enabled' =>
                            true,

                        'multiple' =>
                            true,

                        'max_images' =>
                            4,

                    ],

                    'track_stock' => [
                        'default' => true,
                        'changeable' => false,
                    ],

                'fields' => [

                    'unit_id' =>
                        'required',

                    'barcode' =>
                        'optional',

                    'brand' =>
                        'optional',

                    'manufacturer' =>
                        'optional',

                    'expiry_date' =>
                        'optional',

                    'minimum_stock' =>
                        'optional',

                    'maximum_stock' =>
                        'optional',

                ],

            ],

        ],


        /*
        |--------------------------------------------------------------------------
        | Electronics
        |--------------------------------------------------------------------------
        */

        'electronics' => [

            'label' =>
                'Electronics & Gadgets',

            'product' => [

                'images' => [

                        'enabled' =>
                            true,

                        'multiple' =>
                            true,

                        'max_images' =>
                            8,

                    ],

                'fields' => [

                    'sku' =>
                        'optional',

                    'barcode' =>
                        'optional',

                    'qr_code' =>
                        'hidden',

                    'unit_id' =>
                        'hidden',

                    'brand' =>
                        'optional',

                    'manufacturer' =>
                        'optional',

                    'expiry_date' =>
                        'hidden',

                    'weight' =>
                        'optional',

                    'minimum_stock' =>
                        'optional',

                    'maximum_stock' =>
                        'optional',

                    'opening_stock' =>
                        'optional',

                ],

            ],

        ],


        /*
        |--------------------------------------------------------------------------
        | Fashion
        |--------------------------------------------------------------------------
        */

        'fashion' => [

            'label' =>
                'Fashion & Clothing',

            'product' => [

                'images' => [

                    'enabled' =>
                        true,

                    'multiple' =>
                        true,

                    'max_images' =>
                        8,

                ],

                'track_stock' => [
                    'default' => true,
                    'changeable' => true,
                ],

                'fields' => [

                    'sku' =>
                        'optional',

                    'barcode' =>
                        'optional',

                    'qr_code' =>
                        'hidden',

                    'unit_id' =>
                        'hidden',

                    'brand' =>
                        'optional',

                    'manufacturer' =>
                        'hidden',

                    'expiry_date' =>
                        'hidden',

                    'weight' =>
                        'hidden',

                    'minimum_stock' =>
                        'optional',

                    'maximum_stock' =>
                        'optional',

                ],

            ],

        ],


        /*
        |--------------------------------------------------------------------------
        | Beauty
        |--------------------------------------------------------------------------
        */

        'beauty' => [

            'label' =>
                'Beauty & Cosmetics',

            'product' => [

                'images' => [

                    'enabled' =>
                        true,

                    'multiple' =>
                        true,

                    'max_images' =>
                        6,

                ],

                'track_stock' => [
                    'default' => true,
                    'changeable' => true,
                ],

                'fields' => [

                    'unit_id' =>
                        'optional',

                    'brand' =>
                        'optional',

                    'manufacturer' =>
                        'optional',

                    'expiry_date' =>
                        'optional',

                    'barcode' =>
                        'optional',

                ],

            ],

        ],


        /*
        |--------------------------------------------------------------------------
        | Food Service
        |--------------------------------------------------------------------------
        */

        'food_service' => [

            'label' =>
                'Food Service',

            'product' => [

                'images' => [

                    'enabled' =>
                        true,

                    'multiple' =>
                        true,

                    'max_images' =>
                        5,

                ],

                'track_stock' => [
                    'default' => false,
                    'changeable' => true,
                ],

                'fields' => [

                    'sku' =>
                        'hidden',

                    'barcode' =>
                        'hidden',

                    'qr_code' =>
                        'hidden',

                    'unit_id' =>
                        'optional',

                    'brand' =>
                        'hidden',

                    'manufacturer' =>
                        'hidden',

                    'expiry_date' =>
                        'hidden',

                    'weight' =>
                        'hidden',

                    'minimum_stock' =>
                        'optional',

                    'maximum_stock' =>
                        'hidden',

                ],

            ],

        ],


        /*
        |--------------------------------------------------------------------------
        | Wholesale / Distribution
        |--------------------------------------------------------------------------
        */

        'wholesale' => [

            'label' =>
                'Wholesale & Distribution',

            'product' => [

                'images' => [

                    'enabled' =>
                        true,

                    'multiple' =>
                        true,

                    'max_images' =>
                        5,

                ],

                'track_stock' => [
                    'default' => true,
                    'changeable' => false,
                ],

                'fields' => [

                    'unit_id' =>
                        'required',

                    'sku' =>
                        'optional',

                    'barcode' =>
                        'optional',

                    'brand' =>
                        'optional',

                    'manufacturer' =>
                        'optional',

                    'expiry_date' =>
                        'optional',

                ],

            ],

        ],


        /*
        |--------------------------------------------------------------------------
        | Specialty Retail
        |--------------------------------------------------------------------------
        */

        'specialty_retail' => [

            'label' =>
                'Specialty Retail',

            'product' => [

                'images' => [

                    'enabled' =>
                        true,

                    'multiple' =>
                        true,

                    'max_images' =>
                        8,

                ],

                'track_stock' => [
                    'default' => true,
                    'changeable' => true,
                ],

                'fields' => [

                    'unit_id' =>
                        'optional',

                    'sku' =>
                        'optional',

                    'barcode' =>
                        'optional',

                    'brand' =>
                        'optional',

                    'manufacturer' =>
                        'optional',

                    'expiry_date' =>
                        'hidden',

                    'weight' =>
                        'optional',

                ],

            ],

        ],

    ],

];