const mix = require('laravel-mix');

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

mix.js('resources/js/app.js', 'public/js')
    .copy('resources/css/app.css', 'public/src/css')
    .copy('resources/js/main.js', 'public/src/js')
    .copy('resources/js/mask.js', 'public/src/js')
    .vue()
    .sass('resources/sass/app.scss', 'public/css');
