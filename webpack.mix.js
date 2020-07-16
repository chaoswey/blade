const mix = require('laravel-mix');
/*
 |--------------------------------------------------------------------------
 | 各個JS合併成一隻檔案
 |--------------------------------------------------------------------------
 */
mix.scripts(['resources/js/weya.js'], 'public/js/weya.js');

/*
 |--------------------------------------------------------------------------
 | SASS解析
 | processCssUrls 不改變 url:()
 |--------------------------------------------------------------------------
 */
mix.sass('resources/sass/style.scss', 'public/css').options({postCss: [require('autoprefixer')]});

/*
 |--------------------------------------------------------------------------
 | 設定檔
 |--------------------------------------------------------------------------
 */

mix.options({processCssUrls: false});

if (!mix.inProduction()) {
    mix.webpackConfig({devtool: 'source-map'}).sourceMaps()
}

if (mix.inProduction()) {
    mix.setPublicPath(path.resolve('./'));
    mix.version();
}

/*
 |--------------------------------------------------------------------------
 | 同步瀏覽器
 |--------------------------------------------------------------------------
 */

mix.browserSync({
    files: [
        'public/**/*',
        'resources/views/**/*',
        'resources/views/**/**/**'
    ],
    proxy: 'localhost:8080'
});