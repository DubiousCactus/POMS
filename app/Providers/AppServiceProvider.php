<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Validators\ToppingsValidator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
		Schema::defaultStringLength(191); //MariaDB fix

		$this->app->bind('ToppingsValidator', function() {
			return new ToppingsValidator();
		});

		/*
		 * Create custom rule for the array of topping ids:
		 * shouldn't be passed if the item's category doesn't support toppings !
		*/
		Validator::extend('toppings_array', 'ToppingsValidator@validate');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
