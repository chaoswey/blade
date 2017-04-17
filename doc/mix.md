## 如何使用-mix ##

<a name="mix-introduction"></a>
## 簡介

Laravel Mix 提供了簡潔流暢的 API，讓你能夠為你的 Laravel 應用定義 Webpack 的編譯任務。Mix 支持許多常見的 CSS 與 JavaScrtip 預處理器，通過簡單的方法，你可以輕松的管理資源。例如：

	mix.js('resources/assets/js/app.js', 'public/js')
		.sass('resources/assets/sass/app.scss', 'public/css');

如果你曾經對於使用 Webpack 及編譯資源感到困惑，那麼你絕對會愛上 Laravel Mix。當然，在 Laravel 應用開發中使用 Mix 並不是必須的，你也可以選擇任何你喜歡的資源編譯工具，或者不使用任何工具。

<a name="mix-installation"></a>
## 安裝

#### 安裝 Node

在開始使用 Mix 之前，你必須先確定你的開發環境上有安裝 Node.js 和 NPM。

    node -v
    npm -v


默認情況下, Laravel Homestead 會包含你所需的一切。當然，如果你沒有使用 Vagrant，那麼你可以瀏覽 [nodejs](https://nodejs.org/en/download/) 下載可視化的安裝工具來安裝最新版的 Node 和 NPM.

#### Laravel Mix

剩下的只需要安裝 Laravel Mix！隨著新安裝的 Laravel, 你會發現根目錄下有個名為 `package.json` 的文件。就如同 `composer.json` 文件, 只不過 `package.json` 文件定義的是 Node 的依賴，而不是 PHP。你可以使用以下的命令安裝依賴擴展包：

    npm install

如果你使用的是 Windows 系統或運行在 Windows 系統上的 VM, 你需要在運行 `npm install` 命令時將 `--no-bin-links` 開啟：

    npm install --no-bin-links

<a name="running-mix"></a>
## 使用

Mix 基於 [Webpack](https://webpack.js.org) 的配置， 所以運行定義於 `package.json` 文件中的 NPM 腳本即可執行 Mix 的編譯任務:

    // 運行所有 Mix 任務...
    npm run dev

    // 運行所有 Mix 任務和壓縮資源輸出
    npm run production

#### 監控資源文件修改

`npm run watch` 會在你的終端裡持續運行，監控資源文件是否有發生改變。在 watch 命令運行的情況下，一旦資源文件發生變化，Webpack 會自動重新編譯：


    npm run watch

你可能會發現，在某些環境下，當你改變了你的文件的時候而 Webpack 並沒有同步更新。如果在你的系統中出現了這個問題，你可以考慮使用 `watch-poll` 命令：

    npm run watch-poll

<a name="working-with-stylesheets"></a>
## 使用樣式

項目根目錄的 `webpack.mix.js` 文件是資源編譯的入口。可以把它看作是 Webpack 的配置文件。Mix 任務可以使用鏈式調用的寫法來定義你的資源文件該如何進行編譯。

<a name="less"></a>
### Less

`less` 方法可以讓你將 [Less](http://lesscss.org/) 編譯為 CSS。下面的命令可以把 `app.less` 編譯為 `public/css/app.css`。

	mix.less('resources/assets/less/app.less', 'public/css');

多次調用 `less` 方法可以編譯多個文件:

    mix.less('resources/assets/less/app.less', 'public/css')
       .less('resources/assets/less/admin.less', 'public/css');

如果你想自定義編譯後的 CSS 文件名, 你可以傳遞一個完整的路徑到 `less` 方法的第二個參數:

    mix.less('resources/assets/less/app.less', 'public/stylesheets/styles.css');

如果你需要重寫 [底層 Less 插件選項](https://github.com/webpack-contrib/less-loader#options)，你可以傳遞一個對像到 `mix.less()` 的第三個參數：

    mix.less('resources/assets/less/app.less', 'public/css', {
        strictMath: true
    });

<a name="sass"></a>
### Sass

`sass` 方法可以讓你將 [Sass](http://sass-lang.com/) 便以為 CSS。你可以使用此方法：

	mix.sass('resources/assets/sass/app.scss', 'public/css');

同樣的，如同 `less` 方法, 你可以將多個 Sass 文件編譯為多個 CSS 文件，甚至可以自定義生成的 CSS 的輸出目錄：

	mix.sass('resources/assets/sass/app.sass', 'public/css')
       .sass('resources/assets/sass/admin.sass', 'public/css/admin');

另外 [Node-Sass 插件選項](https://github.com/sass/node-sass#options) 可以通過傳遞第三個參數來重寫：

    mix.sass('resources/assets/sass/app.sass', 'public/css', {
        precision: 5
    });

<a name="stylus"></a>
### Stylus

類似於 Less 和 Sass，`stylus` 方法允許你編譯 [Stylus](http://stylus-lang.com/) 為 CSS：

    mix.stylus('resources/assets/stylus/app.styl', 'public/css');

你也可以安裝其他的 Stylus 插件，例如 [Rupture](https://github.com/jescalan/rupture)。首先，通過 NPM(`npm install rupture`) 來安裝插件，然後在調用 `mix.stylus()` 的時候引用插件：

    mix.stylus('resources/assets/stylus/app.styl', 'public/css', {
        use: [
            require('rupture')()
        ]
    });

<a name="postcss"></a>
### PostCSS

[PostCSS](http://postcss.org/)，一個用來轉換 CSS 的強大工具，已經包含在 Laravel Mix 中。默認， Mix 利用了流行的 [Autoprefixer](https://github.com/postcss/autoprefixer) 插件來自動添加所需要的 CSS3 供應商前綴。不過，你也可以自由添加任何適合你應用程序的插件。首先，通過 NPM 來安裝想要的插件，然後在你的 `webpack.mix.js` 文件中引用：

    mix.sass('resources/assets/sass/app.scss', 'public/css')
       .options({
            postCss: [
                require('postcss-css-variables')()
            ]
       });

<a name="plain-css"></a>
### 純 CSS

如果你只是想將一些純 CSS 樣式合並成單個的文件, 你可以使用 `styles` 方法。

    mix.styles([
        'public/css/vendor/normalize.css',
        'public/css/vendor/videojs.css'
    ], 'public/css/all.css');

<a name="url-processing"></a>
### URL 處理

由於 Laravel Mix 是建立在 Webpack 之上，所以了解一些 Webpack 概念就非常有必要。編譯 CSS 的時候，Webpack 會重寫和優化那些你樣式表中調用 `url()` 的地方。 雖然可能一開始聽起來覺得奇怪，不過這確實是一個強大的功能。試想一下我們編譯一個包含相對路徑圖片的 Sass 文件:

    .example {
        background: url('../images/example.png');
    }

> {note} `url()` 方法會在 URL 重寫中排除絕對路徑。例如 `url('/images/thing.png')` 或者 `url('http://example.com/images/thing.png')` 不會被修改。

Laravel Mix 和 Webpack 默認會找到 `example.png`，把它復制到你的 `public/images` 目錄下，然後在你生成的樣式表中重寫  `url()`。這樣，你編譯之後的 CSS 會變成：

    .example {
      background: url(/images/example.png?d41d8cd98f00b204e9800998ecf8427e);
    }

與此功能相同，可能你的現在的文件夾結構已經按照你喜歡的方式來配置。如果是這種情況，你可以像這樣來禁用 `url()` 重寫：

    mix.sass('resources/assets/app/app.scss', 'public/css')
       .options({
          processCssUrls: false
       });

如果在你的 `webpack.mix.js` 文件這樣配置之後，Mix 將不再匹配 `url()` 或者復制 assets 到你的 public 目錄。換句話來說，編譯後的 CSS 跟你原來輸入的看起來一樣：

    .example {
        background: url("../images/thing.png");
    }

<a name="css-source-maps"></a>
### 資源地圖

source maps 默認狀態下是禁用的，你可以通過在 `webpack.mix.js` 文件中調用 `mix.sourceMaps()` 方法來開啟。它會帶來一些編譯成本，但在使用編譯後的資源文件時可以更方便的在瀏覽器中進行調試：

    mix.js('resources/assets/js/app.js', 'public/js')
       .sourceMaps();

<a name="working-with-scripts"></a>
## 使用腳本

Mix 也提供了一些函數來幫助你使用 JavaScript 文件，像是編譯 ECMAScript 2015、模塊編譯、壓縮、及簡單的串聯純 JavaScript 文件。更棒的是，這些都不需要自定義的配置：

    mix.js('resources/assets/js/app.js', 'public/js');

這一行簡單的代碼，支持：

<div class="content-list" markdown="1">
- ECMAScript 2015 語法.
- Modules
- 編譯 `.vue` 文件.
- 針對生產環境壓縮代碼.
</div>

<a name="vendor-extraction"></a>
### Vendor Extraction

將應用程序的 JavaScript 與依賴庫捆綁在一起的一個潛在缺點是，使得長期緩存更加困難。如，對應用程序代碼的單獨更新將強制瀏覽器重新下載所有依賴庫，即使它們沒有更改。

如果你打算頻繁更新應用程序的 JavaScript，應該考慮將所有的依賴庫提取到單獨文件中。這樣，對應用程序代碼的更改不會影響 vendor.js 文件的緩存。Mix 的 `extract` 方法可以輕松做到：

    mix.js('resources/assets/js/app.js', 'public/js')
       .extract(['vue'])

`extract` 方法接受你希望提取到 `vendor.js` 文件中的所有的依賴庫或模塊的數組。使用以上代碼片段作為示例，Mix 將生成以下文件：

<div class="content-list" markdown="1">
- `public/js/manifest.js`: *Webpack 顯示運行時*
- `public/js/vendor.js`: *依賴庫*
- `public/js/app.js`: *應用代碼*
</div>

為了避免 `JavaScript` 錯誤，請務必按正確的順序加載這些文件：

    <script src="/js/manifest.js"></script>
    <script src="/js/vendor.js"></script>
    <script src="/js/app.js"></script>

<a name="react"></a>
### React

Mix 可以自動安裝 Babel 插件來支持 React。你只需要替換你的 `mix.js()` 變成 `mix.react()` 即可：

    mix.react('resources/assets/js/app.jsx', 'public/js');

在背後，React 會自動下載，並且自動下載適當的 `babel-preset-react` Babel 插件。

<a name="vanilla-js"></a>
### 原生 JS

類似使用 `mix.styles()` 來組合多個樣式表一樣，你也可以使用 `scripts()` 方法來合並並且壓縮多個 JavaScript 文件：

    mix.scripts([
        'public/js/admin.js',
        'public/js/dashboard.js'
    ], 'public/js/all.js');

這個選項對於那些沒有使用 Webpack 的歷史項目非常有用。

> {tip} `mix.babel()` 和 `mix.scripts()` 有點稍微不一樣。`babel` 方法用法和 `scripts` 一樣；不過，這些文件會經過 Bable 編譯，把所有 ES2015 的代碼轉換為原生 JavaScript，這樣所有瀏覽器都能識別。

<a name="custom-webpack-configuration"></a>
### 自定義 Webpack 配置

Laravel Mix 默認引用了一個預先配置的 `webpack.config.js` 文件，以便盡快啟動和運行。有時，你可能需要手動修改此文件。例如，你可能有一個特殊的加載器或插件需要被引用，或者也許你喜歡使用 Stylus 而不是 Sass。在這種情況下，你有兩個選擇：

#### 合併

Mix 提供了一個有用的 `webpackConfig` 方法，允許合並任何 `Webpack` 配置以覆蓋默認配置。這是一個非常好的選擇，你不需要復制和維護 `webpack.config.js` 文件。webpackConfig 方法接受一個對像，該對像應包含要應用的任何 [Webpack 配置項](https://webpack.js.org/configuration/)：

    mix.webpackConfig({
        resolve: {
            modules: [
                path.resolve(__dirname, 'vendor/laravel/spark/resources/assets/js')
            ]
        }
    });

<a name="copying-files-and-directories"></a>
## 復制文件與目錄

`copy` 方法可以復制文件與目錄至新位置。當 `node_modules` 目錄中的特定資源需要復制到 `public` 文件夾時會很有用。

    mix.copy('node_modules/foo/bar.css', 'public/css/bar.css');

<a name="versioning-and-cache-busting"></a>
## 版本與緩存清除

許多的開發者會在它們編譯後的資源文件中加上時間戳或是唯一的 token，強迫瀏覽器加載全新的資源文件以取代提供的舊版本代碼副本。你可以使用 version 方法讓 Mix 處理它們。

`version` 方法為你的文件名稱加上唯一的哈希值，以防止文件被緩存：

    mix.js('resources/assets/js/app.js', 'public/js')
       .version();

在為文件生成版本之後，你將不知道確切的文件名。因此，你應該在你的視圖 中使用 Laravel 的全局 `mix` PHP 輔助函數來正確加載名稱被哈希後的文件。 `mix` 函數會自動判斷被哈希的文件名稱：

    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">

在開發中通常是不需要版本化，你可能希望僅在運行 `npm run production` 的時候進行版本化：

    mix.js('resources/assets/js/app.js', 'public/js');

    if (mix.config.inProduction) {
        mix.version();
    }

<a name="browsersync-reloading"></a>
## Browsersync 自動加載刷新

[BrowserSync](https://browsersync.io/) 可以監控你的文件變化，並且無需手動刷新就可以把你的變化注入到瀏覽器中。你可以通過調用 `mix.browserSync()` 方法來啟用這個功能支持：

    mix.browserSync('my-domain.dev');

    // 或者...

    // https://browsersync.io/docs/options
    mix.browserSync({
        proxy: 'my-domain.dev'
    });

你可以通過傳遞一個字符串 (代理) 或者一個對像 (BrowserSync 設置) 給這個方法。接著，使用 `npm run watch` 命令來開啟 Webpack 的開發服務器。現在，當你修改一個腳本或者 PHP 文件，看著瀏覽器立即刷新出來的頁面來反饋你的改變。

<a name="notifications"></a>
## 通知

在可用的時候，Mix 會將每個包的編譯是否成功以系統通知的方式反饋給你。如果你希望停用這些通知，可以通過 `disableNotifications` 方法實現：
    
    mix.disableNotifications();
