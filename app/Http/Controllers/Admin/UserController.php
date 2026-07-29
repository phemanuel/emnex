<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Services\ActivityLogger;
use Illuminate\Support\Facades\Auth;

    class UserController extends Controller
    {

       public function index()
        {
            $companyId = auth()->user()->company_id;


            $users = User::where(
                    'company_id',
                    $companyId
                )
                ->with([
                    'role',
                    'branch'
                ])
                ->latest()
                ->paginate(15);



            $roles = Role::where(
                    'company_id',
                    $companyId
                )
                ->where('status', true)
                ->get();



            $branches = Branch::where(
                    'company_id',
                    $companyId
                )
                ->get();



            $totalUsers = User::where(
                'company_id',
                $companyId
            )->count();



            $activeUsers = User::where(
                'company_id',
                $companyId
            )
            ->where('status', true)
            ->count();



            $disabledUsers = User::where(
                'company_id',
                $companyId
            )
            ->where('status', false)
            ->count();



            $roleCount = Role::where(
                'company_id',
                $companyId
            )->count();



            return view(
                'users.index',
                compact(
                    'users',
                    'roles',
                    'branches',
                    'totalUsers',
                    'activeUsers',
                    'disabledUsers',
                    'roleCount'
                )
            );
        }

    }

