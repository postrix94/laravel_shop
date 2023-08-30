<?php


namespace App\Services\Interfaces;

use App\Http\Requests\CreateOrderRequest;
use App\Repositories\Interfaces\OrderRepositoryInterface;

interface PaypalServiceInterface
{
    public function create(CreateOrderRequest $request, OrderRepositoryInterface $repository);

    public function capture(string $vendorOrderId, OrderRepositoryInterface $repository);
}
