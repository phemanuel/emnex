<?php

namespace App\Http\Middleware;

use App\Models\Company;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CompanyMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {

            $company = Company::find(auth()->user()->company_id);

            if (!$company) {
                abort(403, 'Company not found.');
            }

            // Make the company available everywhere
            app()->instance('currentCompany', $company);

            // Share with all Blade views
            view()->share('currentCompany', $company);
        }

        return $next($request);
    }
}