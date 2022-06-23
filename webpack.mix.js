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
    .js('resources/js/chat/chat.js', 'public/js/chat.js')
    .js('resources/js/jogo/jogo.js', 'public/js/jogo.js')
    .js('resources/js/jogo/host.js', 'public/js/jogo/host.js')
    .js('resources/js/jogo/client.js', 'public/js/jogo/client.js')
    .sass('resources/sass/app.scss', 'public/css')
    .styles([
        'resources/css/app.css',
        'resources/css/chat.css',
    ], 'public/css/style.css')
    .sourceMaps()
    .version()
    .scripts('resources/bootstrap/dist/js/bootstrap.bundle.js', 'public/js/bootstrap.js')
    .sass('resources/bootstrap/scss/bootstrap.scss', 'public/css/bootstrap.css');
