<?php

namespace App\Providers;

use App\Cart;
use Illuminate\Support\ServiceProvider;

class CartServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
	{
		//
	}

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
	{
        $this->app->singleton(Cart::class, function($app) {
			return new Cart();
		});

    }
}
