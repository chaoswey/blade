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

/*
 |--------------------------------------------------------------------------
 | 各個JS合併成一隻檔案
 |--------------------------------------------------------------------------
 */
mix.scripts([
    'resources/assets/js/weya.js'
], 'public/js/weya.js');

/*
 |--------------------------------------------------------------------------
 | SASS解析
 | processCssUrls 不改變 url:()
 |--------------------------------------------------------------------------
 */
mix.sass('resources/assets/sass/style.scss', 'public/css');

/*
 |--------------------------------------------------------------------------
 | 設定檔
 |--------------------------------------------------------------------------
 */
mix.options({ processCssUrls: false });
mix.sourceMaps();