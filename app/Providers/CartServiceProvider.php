<?php

namespace App\Providers;

use App\ShoppingCart;
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
		$this->app->singleton('cart', function() {
			return new ShoppingCart();
		});
    }
}
