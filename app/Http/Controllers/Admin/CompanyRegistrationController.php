<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use App\Services\CompanyOnboardingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Services\BusinessProfileService;
use Throwable;

class CompanyRegistrationController extends Controller
{
    public function __construct(
        protected CompanyOnboardingService $onboardingService,
        protected AuthService $authService,
        protected BusinessProfileService $businessProfileService
    ) {
    }

    /*
    |--------------------------------------------------------------------------
    | Registration Page
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        return view(
            'onboarding.register',
            [
                'businessTypes' =>
                    $this->businessProfileService
                        ->businessTypes(),
            ]
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Complete Registration
    |--------------------------------------------------------------------------
    */

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make(
            $request->all(),
            $this->validationRules(),
            $this->validationMessages()
        );

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Please correct the highlighted fields and try again.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $validated = $validator->validated();

        $companyData = [
            'company_name' => $validated['company_name'],
            'business_type' => $validated['business_type'],
            'company_email' => $validated['company_email'] ?? null,
            'company_phone' => $validated['company_phone'] ?? null,
            'company_address' => $validated['company_address'] ?? null,
            'currency' => $validated['currency'],
            'timezone' => $validated['timezone'],
        ];

        $ownerData = [
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'password' => $validated['password'],
        ];

        try {
            $result = $this->onboardingService->create(
                $companyData,
                $ownerData,
                (bool) ($validated['add_storefront'] ?? false)
            );

            /*
             * Authenticate the owner using the same authentication
             * service used by the normal login flow.
             */
            $this->authService->login([
                'company_code' => $result['company']->company_code,
                'username' => $result['owner']->username,
                'password' => $validated['password'],
            ]);

            /*
             * Regenerate the session after authentication to prevent
             * session fixation and establish the new authenticated session.
             */
            $request->session()->regenerate();

            return response()->json([
                'success' => true,
                'message' => 'Your EMNEX workspace has been created successfully.',
                'redirect_url' => route('dashboard'),
            ]);
        } catch (Throwable $e) {

            Log::error('Company onboarding failed.', [
                'company_name' => $validated['company_name'] ?? null,
                'owner_username' => $validated['username'] ?? null,
                'owner_email' => $validated['email'] ?? null,
                'exception' => $e,
            ]);

            return response()->json([
                'success' => false,
                'message' => 'We could not complete your registration right now. Please try again.',
            ], 500);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Validation Rules
    |--------------------------------------------------------------------------
    */

    protected function validationRules(): array
    {
        return [
            /*
             * Company
             */
            'company_name' => [
                'required',
                'string',
                'max:150',
            ],

            'business_type' => [
                'required',
                'string',
                'max:100',

                Rule::in(
                    $this->businessProfileService
                        ->businessTypes()
                ),
            ],

            'company_email' => [
                'nullable',
                'email',
                'max:150',
            ],

            'company_phone' => [
                'nullable',
                'string',
                'max:30',
            ],

            'company_address' => [
                'nullable',
                'string',
                'max:1000',
            ],

            'currency' => [
                'required',
                Rule::in([
                    'NGN',
                    'USD',
                    'GBP',
                    'EUR',
                ]),
            ],

            'timezone' => [
                'required',
                Rule::in([
                    'Africa/Lagos',
                    'Africa/Accra',
                    'Europe/London',
                    'America/New_York',
                    'America/Los_Angeles',
                ]),
            ],

            'add_storefront' => [
                'nullable',
                'boolean',
            ],

            /*
             * Owner
             */
            'first_name' => [
                'required',
                'string',
                'max:100',
            ],

            'last_name' => [
                'required',
                'string',
                'max:100',
            ],

            'username' => [
                'required',
                'string',
                'min:3',
                'max:50',
                'regex:/^[A-Za-z0-9._-]+$/',
            ],

            'email' => [
                'required',
                'email',
                'max:150',
            ],

            'phone' => [
                'nullable',
                'string',
                'max:30',
            ],

            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],

            'password_confirmation' => [
                'required',
                'string',
            ],

            /*
             * Terms
             */
            'accept_terms' => [
                'required',
                'accepted',
            ],
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Validation Messages
    |--------------------------------------------------------------------------
    */

    protected function validationMessages(): array
    {
        return [
            'company_name.required' => 'Please enter your company name.',
            
            'business_type.required' =>
                'Please select your business type.',

            'business_type.in' =>
                'The selected business type is not supported.',

            'company_email.email' => 'Please enter a valid company email address.',
            'company_phone.max' => 'The company phone number is too long.',

            'currency.required' => 'Please select your currency.',
            'currency.in' => 'The selected currency is not supported.',

            'timezone.required' => 'Please select your timezone.',
            'timezone.in' => 'The selected timezone is not supported.',

            'first_name.required' => 'Please enter your first name.',
            'last_name.required' => 'Please enter your last name.',

            'username.required' => 'Please choose a username.',
            'username.min' => 'Your username must contain at least 3 characters.',
            'username.regex' => 'Your username may only contain letters, numbers, dots, underscores, and hyphens.',

            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',

            'password.required' => 'Please create a password.',
            'password.min' => 'Your password must contain at least 8 characters.',
            'password.confirmed' => 'Your password confirmation does not match.',

            'password_confirmation.required' => 'Please confirm your password.',

            'accept_terms.required' => 'You must accept the terms to create your workspace.',
            'accept_terms.accepted' => 'You must accept the terms to create your workspace.',
        ];
    }
}

