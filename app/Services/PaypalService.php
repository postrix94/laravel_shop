<?php

namespace App\Services;

use App\Http\Requests\CreateOrderRequest;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\DB;
use Srmklive\PayPal\Services\PayPal;

class PaypalService implements Interfaces\PaypalServiceInterface
{
    protected PayPal $payPalClient;
    protected const STATUS_COMPLETED = 'COMPLETED';
    protected const STATUS_APPROVED = 'APPROVED';
    protected const STATUS_CREATED = 'CREATED';
    protected const STATUS_SAVED = 'SAVED';

    public function __construct() {
        $this->payPalClient = new PayPal();
        $this->payPalClient->setApiCredentials(config('paypal'));
        $this->payPalClient->setAccessToken($this->payPalClient->getAccessToken());


    }

    public function create(CreateOrderRequest $request, OrderRepositoryInterface $repository)
    {
        try {
            DB::beginTransaction();
            $total = Cart::instance('cart')->total();
            $paypalOrder = $this->createPaymentOrder($total);

            $request = array_merge(
                $request->validated(),
                [
                    'vendor_order_id' => $paypalOrder['id'],
                    'total' => $total
                ]
            );
            $order = $repository->create($request);

            DB::commit();
            return response()->json($order);
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->errorHandler($exception);
        }
    }

    public function capture(string $vendorOrderId, OrderRepositoryInterface $repository)
    {
        try {
            DB::beginTransaction();

            $result = $this->payPalClient->capturePaymentOrder($vendorOrderId);
            $order = $repository->setTransaction(
                $vendorOrderId,
                config('payment_system.PAYPAL'),
                $this->convertStatus($result['status'])
            );

            $result['orderId'] = $order-id;
            DB::commit();

            return response()->json($order);

        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->errorHandler($exception);
        }
    }

    protected function createPaymentOrder($total): array
    {
        return $this->payPalClient->createOrder([
            'intent' => 'CAPTURE',
            'purchase_units' => [
                [
                    'amount' => [
                        'currency_code' => config('paypal.currency'),
                        'value' => $total
                    ]
                ]
            ]
        ]);
    }

    protected function errorHandler(\Exception $exception)
    {
        logs()->warning($exception);
        return response()->json(['error' => $exception->getMessage()], 422);
    }

    protected function convertStatus(string $status) {
        return match($status) {
            self::STATUS_COMPLETED, self::STATUS_APPROVED => config('transaction_status.success'),
            self::STATUS_SAVED,self::STATUS_CREATED => config('transaction_status.pending'),
            default => config('transaction_status.canceled')
        };
    }

}
