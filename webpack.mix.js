const { mix } = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/assets/js/app.js', 'public/js')
	.scripts([
		'resources/assets/js/laravel.js',
		'resources/assets/js/sweetalert2.min.js',
	], 'public/js/all.js')
	.js('resources/assets/js/home.js', 'public/js')
	.js('resources/assets/js/basket.js', 'public/js')
	.js('resources/assets/js/delivery.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css')
	.styles('resources/assets/css/sweetalert2.css', 'public/css/all.css')
	.styles('resources/assets/css/basket.css', 'public/css/basket.css')
	.styles('resources/assets/css/delivery.css', 'public/css/delivery.css');
