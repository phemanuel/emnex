<?php

namespace App\Http\Controllers\Platform;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ActivityController extends Controller
{
    public function index(
        Request $request
    ): View {

        $activities =
            ActivityLog::query()
                ->with([
                    'user',
                ])
                ->latest()
                ->paginate(40)
                ->withQueryString();


        return view(
            'platform.activity.index',
            compact(
                'activities'
            )
        );
    }
}