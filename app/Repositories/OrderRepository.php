<?php


namespace App\Repositories;


use App\Models\Order;
use App\Models\OrderStatus;
use Gloudemans\Shoppingcart\Facades\Cart;

class OrderRepository implements Interfaces\OrderRepositoryInterface
{

    public function create(array $data): Order|bool
    {
        $status = OrderStatus::default()->first();
        $data = array_merge($data, ['status_id' => $status->id]);
        $order = auth()->user()->orders()->create($data);

        $this->addProductsToOrder($order);

        return $order;
    }

    public function setTransaction(string $vendorOrderId, string $payment, string $transactionStatus ) {
        $order = Order::where('vendor_order_id', $vendorOrderId)->firstOrFail();
        $order->transaction()->create([
            'payment_system' => $payment,
            'status' => $transactionStatus,
        ]);

        $status = match($transactionStatus) {
            config('transaction_status.success') => OrderStatus::paid()->first(),
            config('transaction_status.canceled') => OrderStatus::canceled()->first(),
            default => OrderStatus::default()->first()
        };

        $order->update([
            'status_id'=>$status
        ]);


        return $order;
    }

    public function addProductsToOrder(Order $order) {
        Cart::instance('cart')->content()->each(function ($item) use ($order) {

            $order->products()->attach($item->model, [
                'quantity' => $item->qty,
                'single_price' => $item->price,
            ]);

            $quantity = $item->model->quantity - $item->qty;

            $quantity = ($quantity < 1) ? 0 : $quantity;

            if(is_null($quantity) || !$item->model->update(compact('quantity')) ) {
                throw new \Exception("Error quantity update product {$item->id} " . __CLASS__ . ' Line ' . __LINE__);
            }
        });
    }

}
