<?php


namespace App\Services;


use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;
use LaravelDaily\Invoices\Classes\Buyer;
use LaravelDaily\Invoices\Classes\InvoiceItem;
use LaravelDaily\Invoices\Invoice;
use LaravelDaily\Invoices\Facades\Invoice as InvoiceBuilder;

class InvocesService implements Interfaces\InvoicesServiceInterface
{

    public function generate(Order $order): Invoice
    {
        $fullName = $order->name . " " . $order->surname;
        $orderSerial = $order->vendorOrderId ?? $order->id;
        $fileName = $fullName . "_" . $orderSerial;

        $customer = new Buyer([
            'name' => $fullName,
            'custom_fields' => [
                'email' => $order->email,
                'phone' => $order->phone,
                'city' => $order->city,
                'address' => $order->address,
            ]
        ]);

        $invoice = InvoiceBuilder::make()
            ->serialNumberFormat($orderSerial)
            ->status($order->status->name)
            ->buyer($customer)
            ->taxRate(config('cart.tax'))
            ->fileName($fileName)
            ->addItems($this->getInvoiceItems($order->products))
            ->save('public');

        if($order->status->name === config('order_status.in_process')) {
            $invoice->payUntilDays(3);
        }

        return $invoice;
    }

    protected function getInvoiceItems(Collection $products): array {
        $items = [];

        foreach ($products as $product) {
            $items[] = (new InvoiceItem)
                ->title($product->title)
                ->pricePerUnit($product->pivot->single_price)
                ->title($product->pivot->quantity)
                ->units('st');
        }

        return $items;
    }
}
