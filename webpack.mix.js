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

mix
    .js('resources/js/app.js', 'public/js')
    .js('resources/js/backend.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .sass('resources/sass/backend.scss', 'public/css')
    .copy('resources/gameforest/dist/css', 'public/css')
    .copy('resources/gameforest/dist/js', 'public/js')
    .copy('resources/gameforest/dist/fonts', 'public/fonts')
    .copy('resources/img', 'public/img')
    .copy('resources/clip/html/clip-2/images', 'public/img')
    .copy('resources/pages/dist/pages/css', 'public/css')
    .copy('resources/pages/dist/pages/js', 'public/js')
    .copy('resources/pages/dist/pages/fonts', 'public/fonts')
    .copy('resources/pages/dist/pages/img', 'public/img')
    .copy('resources/pages/dist/pages/ico', 'public/ico')
    .copy('resources/pages/plugins', 'public/plugins')
;
