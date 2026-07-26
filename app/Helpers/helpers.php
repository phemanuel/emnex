<?php

if (! function_exists('company')) {

    function company()
    {
        return app('currentCompany');
    }

}

if (! function_exists('companyId')) {

    function companyId()
    {
        return company()?->id;
    }

}

if (! function_exists('canAccess')) {

    function canAccess(string $permission): bool
    {
        if (!auth()->check()) {
            return false;
        }

        $user = auth()->user();

        if ($user->is_owner) {
            return true;
        }

        if (!$user->role) {
            return false;
        }

        return $user->role
            ->permissions()
            ->where('permissions.name', $permission)
            ->where('permissions.status', true)
            ->exists();
    }

}