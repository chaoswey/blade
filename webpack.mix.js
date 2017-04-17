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
 | 資料夾內檔案統一合併
 |--------------------------------------------------------------------------
 */
mix.js('resources/assets/js/weya.js', 'public/js')

/*
 |--------------------------------------------------------------------------
 | 各個JS合併成一隻檔案
 |--------------------------------------------------------------------------
 */
.scripts([
    'public/js/admin.js',
    'public/js/dashboard.js'
], 'public/js/all.js')

/*
 |--------------------------------------------------------------------------
 | SASS解析
 | processCssUrls 不改變 url:()
 |--------------------------------------------------------------------------
 */
.sass('resources/assets/sass/style.scss', 'public/css')

/*
 |--------------------------------------------------------------------------
 | 設定檔
 |--------------------------------------------------------------------------
 */
.options({ processCssUrls: false })
.sourceMaps();