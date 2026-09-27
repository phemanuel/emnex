<?php

namespace App\Http\Controllers\Platform;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\View\View;

class PaymentController extends Controller
{
    public function index(): View
    {
        $payments =
            Payment::query()
                ->with([
                    'company',
                    'order',
                    'customer',
                ])
                ->latest()
                ->paginate(30);


        return view(
            'platform.payments.index',
            compact(
                'payments'
            )
        );
    }
}