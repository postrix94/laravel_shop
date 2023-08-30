<?php


namespace App\Repositories\Interfaces;


use App\Models\Order;

interface OrderRepositoryInterface
{
    public function create(array $data): Order|bool;

    public function setTransaction(string $vendorOrderId, string $payment, string $transactionStatus );
}
