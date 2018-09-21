const {mix} = require('laravel-mix');
const CopyWebpackPlugin = require('copy-webpack-plugin');
const ImageminPlugin = require('imagemin-webpack-plugin').default;
const imageminMozjpeg = require('imagemin-mozjpeg');

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
mix.sass('resources/sass/style.scss', 'public/css');

/*
 |--------------------------------------------------------------------------
 | TODO 寫成mix套件
 | 實驗性質
 | 壓縮圖檔
 |--------------------------------------------------------------------------
 */
mix.webpackConfig({
    plugins: [
        new CopyWebpackPlugin([{
            from: 'public/images',
            to: 'images/dist',
        }]),
        new ImageminPlugin({
            test: /\.(jpe?g|png|gif|svg)$/i,
            pngquant: {quality: '70-80'},
            plugins: [
                imageminMozjpeg({
                    quality: 70,
                })
            ]
        })
    ]
});
/*
 |--------------------------------------------------------------------------
 | 設定檔
 |--------------------------------------------------------------------------
 */

mix.setPublicPath('public').options({processCssUrls: false}).sourceMaps();

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
    proxy: 'product.dev:8081'
});