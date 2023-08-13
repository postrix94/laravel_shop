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
            Db::beginTransaction();

            $data['slug'] = $data['title'];
            ksort($data);

            $product = Product::create($data);
            $this->setCategories($product, $data['categories'] ?? []);
            $this->imageRepository->attach($product,'images', $data['images'], $product->slug);

            Db::commit();

            return $product;
        }catch (\Exception $e) {
            Db::rollBack();
            logs()->warning($e);
            return false;
        }
    }

    public function update(Product $product, array $data) {
        try {
            Db::beginTransaction();

            $data['slug'] = $data['title'];
            ksort($data);

            $product->update($data);

            $this->updateCategories($product, $data['categories'] ?? []);

            $this->imageRepository->attach($product,'images', $data['images'] ?? [], $product->slug);

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

    protected function updateCategories(Product $product, array $categories): void
    {

       $index = array_search(null, $categories);

       if($index === 0) {
           unset($categories[$index]);
       }

        if(empty($categories)) {
            $product->categories()->detach();
            return;
        }

        if(!$product->categories->count()) {
            $product->categories()->attach($categories);
            return;
        }

        $product->categories()->detach();
        $product->categories()->attach($categories);


    }

}
