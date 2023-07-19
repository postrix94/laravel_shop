<?php

namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Interfaces\IImageRepository;
use Illuminate\Support\Facades\DB;

class ProductRepository implements Interfaces\IProductRepository
{
    protected IImageRepository $imageRepository;

    public function __construct(IImageRepository $imageRepository) {
        $this->imageRepository = $imageRepository;
    }

    public function create(array $data): Product|bool
    {
        try {
            Db::beginTransaction($data);

            $data['slug'] = $data['title'];
            ksort($data);

            $product = Product::create($data);
            $this->setCategories($product, $data['categories'] ?? []);
            $this->imageRepository->attach($product,'imagess', $data['images'], $data['slug']);

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
