
<?php

use App\Helpers\CompanyHelper;


/*
|--------------------------------------------------------------------------
| Company Helpers
|--------------------------------------------------------------------------
*/

if (! function_exists('company')) {

    function company()
    {
        return CompanyHelper::current();
    }

}


if (! function_exists('companyId')) {

    function companyId()
    {
        return CompanyHelper::id();
    }

}


/*
|--------------------------------------------------------------------------
| Branch Helpers
|--------------------------------------------------------------------------
*/

/**
 * Determine whether the authenticated user
 * can access all branches within the company.
 *
 * Owner and Administrator have company-wide access.
 */
if (! function_exists('canManageAllBranches')) {

    function canManageAllBranches(): bool
    {
        if (! auth()->check()) {
            return false;
        }

        $user = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | Owner
        |--------------------------------------------------------------------------
        */

        if ($user->is_owner) {
            return true;
        }

        /*
        |--------------------------------------------------------------------------
        | Administrator
        |--------------------------------------------------------------------------
        */

        return $user->role?->code === 'administrator';
    }

}


/**
 * Get the authenticated user's assigned branch.
 */
if (! function_exists('currentBranchId')) {

    function currentBranchId(): ?int
    {
        if (! auth()->check()) {
            return null;
        }

        return auth()->user()->branch_id;
    }

}


/*
|--------------------------------------------------------------------------
| Permission Helper
|--------------------------------------------------------------------------
*/

if (! function_exists('canAccess')) {

    function canAccess(string $permission): bool
    {
        if (! auth()->check()) {
            return false;
        }

        $user = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | Owner
        |--------------------------------------------------------------------------
        */

        if ($user->is_owner) {
            return true;
        }

        /*
        |--------------------------------------------------------------------------
        | User Without Role
        |--------------------------------------------------------------------------
        */

        if (! $user->role) {
            return false;
        }

        /*
        |--------------------------------------------------------------------------
        | Permission
        |--------------------------------------------------------------------------
        */

        return $user->role
            ->permissions()
            ->where(
                'permissions.name',
                $permission
            )
            ->where(
                'permissions.status',
                true
            )
            ->exists();
    }

}

