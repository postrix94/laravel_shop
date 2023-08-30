<?php

namespace App\Http\Controllers\Ajax\Payments;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateOrderRequest;
use App\Services\Interfaces\PaypalServiceInterface;
use Illuminate\Http\Request;

class PaypalController extends Controller
{
    public function create(CreateOrderRequest $request, PaypalServiceInterface $paypal) {
        return app()->call([$paypal, 'create'], compact('request'));
    }

    public function capture(string $vendorOrderId, PaypalServiceInterface $paypal) {
        return app()->call([$paypal, 'capture'], compact('vendorOrderId'));
    }


}

