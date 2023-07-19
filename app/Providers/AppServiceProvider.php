<?php

namespace App\Providers;

use App\Repositories\ImageRepository;
use App\Repositories\Interfaces\IImageRepository;
use App\Repositories\Interfaces\IProductRepository;
use App\Repositories\ProductRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(IProductRepository::class, ProductRepository::class);
        $this->app->bind(IImageRepository::class, ImageRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

    }
}
