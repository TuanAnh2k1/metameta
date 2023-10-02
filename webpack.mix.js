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

mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/layouts/script.js', 'public/js/layouts')
    .postCss('resources/css/app.css', 'public/css')
    .postCss('resources/css/layouts/style.css', 'public/css/layouts')
    .postCss('resources/css/layouts/responsive.css', 'public/css/layouts')
    .options({
        processCssUrls: false
    });
