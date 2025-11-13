<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Controllers\ProductController;
use App\Repositories\Eloquent\OrderRepository;
use App\Repositories\Interfaces\OrderInterface;
use App\Repositories\Eloquent\BillingRepository;
use App\Repositories\Eloquent\ProductRepository;
use App\Repositories\Eloquent\StationRepository;
use App\Repositories\Eloquent\TranslationRepository;
use App\Repositories\Interfaces\BillingInterface;
use App\Repositories\Interfaces\ProductInterface;
use App\Repositories\Interfaces\StationInterface;
use App\Repositories\Interfaces\TranslationInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        $this->app->bind(OrderInterface::class, OrderRepository::class);
        $this->app->bind(StationInterface::class, StationRepository::class);
        $this->app->bind(ProductInterface::class, ProductRepository::class);
        $this->app->bind(BillingInterface::class, BillingRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
