<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Storefront;
use App\Services\StorefrontSetupService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

class StorefrontController extends Controller
{
    public function __construct(
        protected StorefrontSetupService $storefrontSetupService
    ) {
    }

    /**
     * Storefront management page.
     */
    public function manage(): View
    {
        $user = auth()->user();

        $company = Company::query()
            ->findOrFail($user->company_id);

        /*
         * Returns existing Storefront or creates one
         * in Setup state if the company does not have one.
         */
        $storefront = $this->storefrontSetupService
            ->createForCompany(
                $company,
                $user
            );

        return view(
            'storefront.index',
            compact(
                'company',
                'storefront'
            )
        );
    }

    /**
     * Update basic Storefront configuration.
     */
    public function update(
        Request $request
    ): JsonResponse {

        $storefront =
            $this->currentStorefront();


        /**
         * Normalise the public slug
         * before validation.
         */
        $request->merge([
            'slug' => Str::slug(
                (string) $request->input('slug')
            ),
        ]);


        $validated =
            $request->validate([

                'name' => [
                    'required',
                    'string',
                    'max:255',
                ],

                'slug' => [
                    'required',
                    'string',
                    'max:255',

                    Rule::unique(
                        'storefronts',
                        'slug'
                    )->ignore(
                        $storefront->id
                    ),
                ],

                'theme_key' => [
                    'required',
                    'string',

                    Rule::in([
                        'editorial',
                        'modern',
                        'marketplace',
                        'boutique',
                    ]),
                ],

            ]);


        $storefront->update([

            'name' =>
                $validated['name'],

            'slug' =>
                $validated['slug'],

            'theme_key' =>
                $validated['theme_key'],

            'updated_by' =>
                auth()->id(),

        ]);


        return response()->json([

            'success' => true,

            'message' =>
                'Storefront settings updated successfully.',

            'data' => [

                'id' =>
                    $storefront->id,

                'name' =>
                    $storefront->name,

                'slug' =>
                    $storefront->slug,

                'theme_key' =>
                    $storefront->theme_key,

                'status' =>
                    $storefront->status,

                'public_url' =>
                    url(
                        '/store/' .
                        $storefront->slug
                    ),

            ],

        ]);
    }

    /**
     * Make Storefront publicly active.
     */
    public function activate(): JsonResponse
    {
        $storefront =
            $this->currentStorefront();


        /**
         * Store must have the minimum
         * public identity before activation.
         */
        if (
            blank($storefront->name) ||
            blank($storefront->slug)
        ) {

            return response()->json([
                'success' => false,

                'message' =>
                    'Complete your Storefront name and URL before activating it.',
            ], 422);

        }


        /**
         * Already active.
         */
        if (
            $storefront->status === 'Active'
        ) {

            return response()->json([
                'success' => true,

                'message' =>
                    'Your Storefront is already active.',

                'data' => [
                    'status' =>
                        $storefront->status,
                ],
            ]);

        }


        $storefront->update([

            'status' =>
                'Active',

            'enabled_at' =>
                $storefront->enabled_at
                ?? now(),

            'updated_by' =>
                auth()->id(),

        ]);


        return response()->json([
            'success' => true,

            'message' =>
                'Your Storefront is now live.',

            'data' => [

                'status' =>
                    $storefront->status,

                'enabled_at' =>
                    $storefront
                        ->enabled_at
                        ?->toISOString(),

                'public_url' =>
                    url(
                        '/store/' .
                        $storefront->slug
                    ),

            ],
        ]);
    }
    /**
     * Disable public Storefront access.
     *
     * No Storefront or sales history is deleted.
     */
    public function disable(): JsonResponse
    {
        $storefront =
            $this->currentStorefront();


        if (
            $storefront->status === 'Disabled'
        ) {

            return response()->json([
                'success' => true,

                'message' =>
                    'Your Storefront is already disabled.',
            ]);

        }


        $storefront->update([

            'status' =>
                'Disabled',

            'updated_by' =>
                auth()->id(),

        ]);


        return response()->json([
            'success' => true,

            'message' =>
                'Your Storefront has been disabled. Your configuration and history remain intact.',

            'data' => [

                'status' =>
                    $storefront->status,

            ],
        ]);
    }

    /**
     * Get Storefront belonging to authenticated company.
     */
    protected function currentStorefront(): Storefront
    {
        return Storefront::query()
            ->where(
                'company_id',
                auth()->user()->company_id
            )
            ->firstOrFail();
    }
}