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
	.js('resources/assets/js/laravel.js', 'public/js')
	.js('resources/assets/js/sweetalert.min.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css')
	.styles([
		'resources/assets/css/sweetalert.css'
	], 'public/css/all.css');
