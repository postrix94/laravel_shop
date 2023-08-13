<?php

namespace App\Observers;

use App\Models\Product;
use App\Services\FileStorageService;

class ProductObserver
{

    /**
     * Handle the Product "deleted" event.
     */
    public function deleted(Product $product): void
    {
       if($product->images) {
           $product->images->each->delete();
       }

       FileStorageService::remove($product->thumbnail);
       \Storage::deleteDirectory('public/' . $product->slug);
    }

}
