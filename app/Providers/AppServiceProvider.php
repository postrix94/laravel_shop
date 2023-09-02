<?php

namespace App\Providers;

use App\Repositories\ImageRepository;
use App\Repositories\Interfaces\IImageRepository;
use App\Repositories\Interfaces\IProductRepository;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use App\Repositories\OrderRepository;
use App\Repositories\ProductRepository;
use App\Services\Interfaces\InvoicesServiceInterface;
use App\Services\Interfaces\PaypalServiceInterface;
use App\Services\InvocesService;
use App\Services\PaypalService;
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
        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);
        $this->app->bind(PaypalServiceInterface::class, PaypalService::class);
        $this->app->bind(InvoicesServiceInterface::class, InvocesService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

    }
}
