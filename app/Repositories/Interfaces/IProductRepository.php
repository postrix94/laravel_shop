<?php

namespace App\Repositories\Interfaces;

use App\Models\Product;

interface IProductRepository
{
    public function create(array $data): Product|bool;

}
