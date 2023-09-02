<?php

namespace App\Http\Controllers\Orders;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;

class ThankYouPageController extends Controller
{
    /**
     * @param string $orderId
     */
    public function paypal(string $orderId) {
        $order = Order::where('id', $orderId)->firstOrFail();
        $order->loadMissing(['user', 'transaction', 'products']);
        Cart::instance('cart')->destroy();

        return view('thankyou/summary', compact('order'));
    }
}
