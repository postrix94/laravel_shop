<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductRepository implements Interfaces\IProductRepository
{

    public function create(array $data): Product|bool
    {
        try {
            Db::beginTransaction($data);

            $data['slug'] = $data['title'];
            $data['thumbnail'] = 'resources/images/admin/products/no_products.png';

            $product = Product::create($data);
            $this->setCategories($product, $data['categories'] ?? []);

            Db::commit();

            return $product;
        }catch (\Exception $e) {
            Db::rollBack();
            logs()->warning($e);
            return false;
        }
    }

    protected function setCategories(Product $product, array $categories): void {
        if(count($categories)) {
            $product->categories()->attach($categories);
        }
    }

}
