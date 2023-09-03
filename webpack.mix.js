const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

 mix.js('resources/js/app.js', 'public/js').version();

// //apex charts
 mix.copy('node_modules/apexcharts/dist/apexcharts.min.js', 'public/js/apexcharts/apexcharts.js')

     .postCss('resources/css/app.css', 'public/css', [
         require('tailwindcss'),
     ])
     .sass('resources/sass/app.scss', 'public/css').version();
