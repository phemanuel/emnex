<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Services\ActivityLogger;
use Throwable;

class AccountController extends BaseController
{
    protected ActivityLogger $activityLogger;


    public function __construct(ActivityLogger $activityLogger)
    {
        parent::__construct();

        $this->activityLogger = $activityLogger;
    }

    /*
    |--------------------------------------------------------------------------
    | Update Profile
    |--------------------------------------------------------------------------
    */

    public function updateProfile(Request $request)
    {

        try {

            $user = auth()->user();

            \Log::info(
                'Profile Update Request',
                $request->all()
            );


            $validated = $request->validate([

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

                'email' => [

                    'required',

                    'email',

                    'max:255',

                    Rule::unique('users', 'email')
                        ->ignore($user->id),

                ],

            ]);



            $oldValues = [

                'first_name' =>
                    $user->first_name,

                'last_name' =>
                    $user->last_name,

                'email' =>
                    $user->email,

            ];



            $user->update([

                'first_name' =>
                    $validated['first_name'],

                'last_name' =>
                    $validated['last_name'],

                'email' =>
                    $validated['email'],

            ]);



            $newValues = [

                'first_name' =>
                    $user->first_name,

                'last_name' =>
                    $user->last_name,

                'email' =>
                    $user->email,

            ];



            $this->activityLogger->log(

                'Account',

                'Updated',

                'User updated their profile.',

                $user,

                $oldValues,

                $newValues

            );



            return $this->successResponse(

                [

                    'user' => [

                        'first_name' =>
                            $user->first_name,

                        'last_name' =>
                            $user->last_name,

                        'email' =>
                            $user->email,

                    ],

                ],

                'Profile updated successfully.'

            );

        }

        catch (Throwable $exception) {

            return $this->handleException(
                $exception
            );

        }

    }



    /*
    |--------------------------------------------------------------------------
    | Update Password
    |--------------------------------------------------------------------------
    */

    public function updatePassword(Request $request)
    {

        try {

            $validated = $request->validate([

                'current_password' => [
                    'required',
                    'string',
                ],

                'password' => [
                    'required',
                    'string',
                    'min:8',
                    'confirmed',
                ],

            ]);



            $user = auth()->user();



            /*
            |--------------------------------------------------------------------------
            | Current Password
            |--------------------------------------------------------------------------
            */

            if (
                !Hash::check(
                    $validated['current_password'],
                    $user->password
                )
            ) {

                return $this->errorResponse(
                    'The current password is incorrect.',
                    422
                );

            }



            /*
            |--------------------------------------------------------------------------
            | Update Password
            |--------------------------------------------------------------------------
            */

            $user->update([

                'password' =>
                    Hash::make(
                        $validated['password']
                    ),

            ]);



            /*
            |--------------------------------------------------------------------------
            | Activity Log
            |--------------------------------------------------------------------------
            */

            $this->activityLogger->log(

                'Account',

                'Password Changed',

                'User changed their password.',

                $user,

                null,

                null

            );



            return $this->successResponse(

                null,

                'Password changed successfully.'

            );

        }

        catch (Throwable $exception) {

            return $this->handleException(
                $exception
            );

        }

    }

}