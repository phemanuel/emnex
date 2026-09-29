<?php

namespace App\Services;

use App\Models\Storefront;
use Illuminate\Support\Facades\View;


class StorefrontThemeService
{
    public const DEFAULT_THEME = 'editorial';


    public const THEMES = [

        'editorial' => [

            'name' =>
                'Editorial',

            'description' =>
                'A refined, editorial-style storefront with spacious layouts and strong product storytelling.',

            'views' => [

                'home' =>
                    'storefront.public.home',

                'category' =>
                    'storefront.public.category',

                'product' =>
                    'storefront.public.product',

                'cart' =>
                    'storefront.public.cart',

                'checkout' =>
                    'storefront.public.checkout',

                'checkout-success' =>
                    'storefront.public.checkout-success',

                'checkout-failed' =>
                    'storefront.public.checkout-failed',

            ],

        ],


        'modern' => [

            'name' =>
                'Modern',

            'description' =>
                'A clean contemporary storefront with polished cards, visual commerce layouts and modern spacing.',

            'views' => [

                'home' =>
                    'storefront.public.themes.modern.home',

                'category' =>
                    'storefront.public.themes.modern.category',

                'product' =>
                    'storefront.public.themes.modern.product',

                'cart' =>
                    'storefront.public.themes.modern.cart',

                'checkout' =>
                    'storefront.public.themes.modern.checkout',

                'checkout-success' =>
                    'storefront.public.themes.modern.checkout-success',

                'checkout-failed' =>
                    'storefront.public.themes.modern.checkout-failed',

            ],

        ],


        'marketplace' => [

            'name' =>
                'Marketplace',

            'description' =>
                'A dense catalogue-first storefront designed for larger inventories, quick browsing and frequent shopping.',

            'views' => [

                'home' =>
                    'storefront.public.themes.marketplace.home',

                'category' =>
                    'storefront.public.themes.marketplace.category',

                'product' =>
                    'storefront.public.themes.marketplace.product',

                'cart' =>
                    'storefront.public.themes.marketplace.cart',

                'checkout' =>
                    'storefront.public.themes.marketplace.checkout',

                'checkout-success' =>
                    'storefront.public.themes.marketplace.checkout-success',

                'checkout-failed' =>
                    'storefront.public.themes.marketplace.checkout-failed',

            ],

        ],


        'boutique' => [
            'name' => 'Boutique',

            'views' => [

                'home' =>
                    'storefront.public.themes.boutique.home',

                'category' =>
                    'storefront.public.themes.boutique.category',

                'product' =>
                    'storefront.public.themes.boutique.product',

                'cart' =>
                    'storefront.public.themes.boutique.cart',

                'checkout' =>
                    'storefront.public.themes.boutique.checkout',

                'checkout-success' =>
                    'storefront.public.themes.boutique.checkout-success',

                'checkout-failed' =>
                    'storefront.public.themes.boutique.checkout-failed',

            ],
        ],

    ];


    public function resolveThemeKey(
        Storefront $storefront
    ): string {

        $themeKey =
            $storefront->theme_key
            ?: self::DEFAULT_THEME;


        if (
            !array_key_exists(
                $themeKey,
                self::THEMES
            )
        ) {

            return self::DEFAULT_THEME;

        }


        return $themeKey;

    }


    public function view(
        Storefront $storefront,
        string $page
    ): string {

        $themeKey =
            $this->resolveThemeKey(
                $storefront
            );


        /*
        |--------------------------------------------------------------------------
        | Theme-specific view
        |--------------------------------------------------------------------------
        */

        $themeView =
            self::THEMES[$themeKey]['views'][$page]
            ?? null;


        if (
            $themeView
            &&
            View::exists(
                $themeView
            )
        ) {

            return $themeView;

        }


        /*
        |--------------------------------------------------------------------------
        | Editorial fallback
        |--------------------------------------------------------------------------
        */

        $fallbackView =
            self::THEMES[
                self::DEFAULT_THEME
            ]['views'][$page]
            ?? null;


        if (
            $fallbackView
            &&
            View::exists(
                $fallbackView
            )
        ) {

            return $fallbackView;

        }


        /*
        |--------------------------------------------------------------------------
        | Unknown page
        |--------------------------------------------------------------------------
        */

        throw new \InvalidArgumentException(
            "No storefront view is configured for page [{$page}]."
        );

    }


    public function themes(): array
    {
        return self::THEMES;
    }


    public function isValid(
        string $themeKey
    ): bool {

        return array_key_exists(
            $themeKey,
            self::THEMES
        );

    }
}