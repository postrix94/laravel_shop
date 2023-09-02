<?php

namespace App\Services\Interfaces;


use App\Models\Order;
use LaravelDaily\Invoices\Invoice;

interface InvoicesServiceInterface
{
    public function generate(Order $order): Invoice;
}
