<?php

namespace App\Http\Controllers\Platform;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(
        Request $request
    ): View {

        $users =
            User::query()
                ->with([
                    'company',
                    'branch',
                    'role',
                ])
                ->latest()
                ->paginate(30);


        return view(
            'platform.users.index',
            compact(
                'users'
            )
        );
    }
}