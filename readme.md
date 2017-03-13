# weya blade #

    git clone https://chaoswey@bitbucket.org/chaoswey/blade.git

## 快速連結 ##

[laravel-mix](#mix-introduction)

[laravel-blade](#blade-introduction)

## 更新說明 ##

* 1.2.0

加入 laravel-mix

## 更新說明 ##
* 1.1.0

加入 gulp 調整資料夾結構

## 資料結構說明 ##

cache - 自動產生 Html 快取

error - 404 錯誤

public - style、js、img...

vendor - 程式

views - blade.php

## require package ##

* laravel-blade

> philo/laravel-blade: https://github.com/PhiloNL/Laravel-Blade

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

## 如何使用-blade ##


<a name="blade-introduction"></a>
## 簡介

Blade 是 Laravel 提供的一個既簡單又強大的樣板引擎。和其他流行的 PHP 樣板引擎不一樣，Blade 並不限制你在視圖中使用原生 PHP 代碼。所有 Blade 視圖文件都將被編譯成原生的 PHP 代碼並緩存起來，除非它被修改，否則不會重新編譯，這就意味著 Blade 基本上不會給你的應用增加任何額外負擔。Blade 視圖文件使用 `.blade.php` 擴展名，一般被存放在 `resources/views` 目錄。

<a name="template-inheritance"></a>
## 樣板繼承

<a name="defining-a-layout"></a>
### 定義頁面layout

Blade 的兩個主要優點是 _樣板繼承_ 和 _區塊_ 。 

為方便開始，讓我們先通過一個簡單的例子來上手。首先，我們需要確認一個 "master" 的頁面layout。因為大多數 web 應用是在不同的頁面中使用相同的layout方式，我們可以很方便的定義這個 Blade layout視圖：

    <!-- 文件保存於 resources/views/layouts/app.blade.php -->

    <html>
        <head>
            <title>網站名稱 - @yield('title')</title>
        </head>
        <body>
            @section('sidebar')
                這是 master 的側邊欄。
            @show

            <div class="container">
                @yield('content')
            </div>
        </body>
    </html>

如你所見，該文件包含了典型的 HTML 語法。不過，請注意 `@section` 和 `@yield` 命令。 `@section` 命令正如其名字所暗示的一樣是用來定義一個視圖區塊的，而  `@yield` 指令是用來顯示指定區塊的內容的。

現在，我們已經定義好了這個應用程序的layout，讓我們接著來定義一個繼承此layout的子頁面。

<a name="extending-a-layout"></a>
### 繼承頁面layout

當定義子頁面時，你可以使用 Blade 提供的 `@extends` 命令來為子頁面指定其所 「繼承」 的頁面layout。 當子頁面繼承layout之後，即可使用 `@section` 命令將內容注入於layout的 `@section` 區塊中。切記，在上面的例子裡，layout中使用 `@yield` 的地方將會顯示這些區塊中的內容：

    <!-- Stored in resources/views/child.blade.php -->

    @extends('layouts.app')

    @section('title', 'Page Title')

    @section('sidebar')
        @@parent

        <p>This is appended to the master sidebar.</p>
    @endsection

    @section('content')
        <p>This is my body content.</p>
    @endsection

在上面的例子裡，`sidebar` 區塊利用了 `@@parent` 命令追加layout中的 sidebar 區塊中的內容，如果不使用則會覆蓋掉layout中的這部分內容。 `@@parent` 命令會在視圖被渲染時替換為layout中的內容。

當然，可以通過在路由中使用全局輔助函數 `view` 來返回 Blade 視圖：

    Route::get('blade', function () {
        return view('child');
    });

<a name="components-and-slots"></a>
## 組件 & Slots

組件和 slots 能提供類似於區塊和layout的好處；不過，一些人可能發現組件和 slots 更容易理解。首先，讓我們假設一個會在我們應用中重復使用的「警告」組件:

    <!-- /resources/views/alert.blade.php -->

    <div class="alert alert-danger">
        {{ $slot }}
    </div>

`{{ $slot }}` 變量將包含我們希望注入到組件的內容。現在，我們可以使用 `@component` 指令來構造這個組件：

    @component('alert')
        <strong>哇！</strong> 出現了一些問題！
    @endcomponent

有些時候它對於定義組件的多個 slots 是非常有幫助的。讓我們修改我們的警告組件，讓它支持注入一個「標題」。 已命名的 slots 將顯示「相對應」名稱的變量的值:

    <!-- /resources/views/alert.blade.php -->

    <div class="alert alert-danger">
        <div class="alert-title">{{ $title }}</div>

        {{ $slot }}
    </div>

現在，我們可以使用 `@slot` 指令注入內容到已命名的 slot 中，任何沒有被 `@slot` 指令包裹住的內容將傳遞給組件中的 `$slot` 變量:

    @component('alert')
        @slot('title')
            拒絕
        @endslot

        你沒有權限訪問這個資源！
    @endcomponent

#### 傳遞額外的Data給組件

有時候你可能需要傳遞額外的Data給組件。為了解決這個問題，你可以傳遞一個數組作為第二個參數傳遞給 `@component` 指令。所有的Data都將以變量的形式傳遞給組件模版:

    @component('alert', ['foo' => 'bar'])
        ...
    @endcomponent

<a name="displaying-data"></a>
## 顯示Data

你可以使用 「中括號」 包住變量以顯示傳遞至 Blade 視圖的Data。如下面的路由設置：

    Route::get('greeting', function () {
        return view('welcome', ['name' => 'Samantha']);
    });

你可以像這樣顯示 `name` 變量的內容：

    Hello, {{ $name }}.

當然也不是說一定只能顯示傳遞至視圖的變量內容。你也可以顯示 PHP 函數的結果。事實上，你可以在 Blade 中顯示任意的 PHP 代碼：

    The current UNIX timestamp is {{ time() }}.

> {note} Blade `{{ }}` 語法會自動調用 PHP `htmlspecialchars` 函數來避免 XSS 攻擊。

#### 當Data存在時輸出

有時候你可能想要輸出一個變量，但是你並不確定這個變量是否已經被定義，我們可以用像這樣的冗長 PHP 代碼表達：

    {{ isset($name) ? $name : 'Default' }}

事實上，Blade 提供了更便捷的方式來代替這種三元運算符表達式：

    {{ $name or 'Default' }}

在這個例子中，如果 `$name` 變量存在，它的值將被顯示出來。但是，如果它不存在，則會顯示 `Default` 。

#### 顯示未轉義過的Data

在默認情況下，Blade 樣板中的 `{{ }}` 表達式將會自動調用 PHP `htmlspecialchars` 函數來轉義Data以避免 XSS 的攻擊。如果你不想你的Data被轉義，你可以使用下面的語法：

    Hello, {!! $name !!}.

> {note} 要非常小心處理用戶輸入的Data時，你應該總是使用 `{{  }}` 語法來轉義內容中的任何的 HTML 元素，以避免 XSS 攻擊。

<a name="blade-and-javascript-frameworks"></a>
### Blade & JavaScript 框架

由於很多 JavaScript 框架都使用花括號來表明所提供的表達式，所以你可以使用 `@` 符號來告知 Blade 渲染引擎你需要保留這個表達式原始形態，例如：

    <h1>Laravel</h1>

    Hello, @{{ name }}.

在這個例子裡，`@` 符號最終會被 Blade 引擎剔除，並且 `{{ name }}` 表達式會被原樣的保留下來，這樣就允許你的 JavaScript 框架來使用它了。

#### `@verbatim` 指令

如果你需要在頁面中大片區塊中展示 JavaScript 變量，你可以使用 `@verbatim` 指令來包裹 HTML 內容，這樣你就不需要為每個需要解析的變量增加 `@` 符號前綴了：

    @verbatim
        <div class="container">
            Hello, {{ name }}.
        </div>
    @endverbatim

<a name="control-structures"></a>
## 控制結構

除了樣板繼承與Data顯示的功能以外，Blade 也給一般的 PHP 結構控制語句提供了方便的縮寫，比如條件表達式和循環語句。這些縮寫提供了更為清晰簡明的方式來使用 PHP 的控制結構，而且還保持與 PHP 語句的相似性。

<a name="if-statements"></a>
### If 語句

你可以通過 `@if`, `@elseif`, `@else` 及  `@endif` 指令構建 `if` 表達式。這些命令的功能等同於在 PHP 中的語法：

    @if (count($records) === 1)
        我有一條記錄！
    @elseif (count($records) > 1)
        我有多條記錄！
    @else
        我沒有任何記錄！
    @endif

為了方便，Blade 也提供了一個 `@unless` 命令：

    @unless (Auth::check())
        你尚未登錄。
    @endunless

<a name="loops"></a>
### 循環

除了條件表達式外，Blade 也支持 PHP 的循環結構，這些命令的功能等同於在 PHP 中的語法：

    @for ($i = 0; $i < 10; $i++)
        目前的值為 {{ $i }}
    @endfor

    @foreach ($users as $user)
        <p>此用戶為 {{ $user->id }}</p>
    @endforeach

    @forelse ($users as $user)
        <li>{{ $user->name }}</li>
    @empty
        <p>沒有用戶</p>
    @endforelse

    @while (true)
        <p>我永遠都在跑循環。</p>
    @endwhile

> {tip} 當循環時，你可以使用 [循環變量](#the-loop-variable) 來獲取循環中有價值的信息，比如循環中的首次或最後的迭代。

當使用循環時，你可能也需要一些結束循環或者跳出當前循環的命令：

    @foreach ($users as $user)
        @if ($user->type == 1)
            @continue
        @endif

        <li>{{ $user->name }}</li>

        @if ($user->number == 5)
            @break
        @endif
    @endforeach

你也可以使用命令聲明包含條件的方式在一條語句中達到中斷:

    @foreach ($users as $user)
        @continue($user->type == 1)

        <li>{{ $user->name }}</li>

        @break($user->number == 5)
    @endforeach

<a name="the-loop-variable"></a>
### 循環變量

當循環時，你可以在循環內訪問 `$loop` 變量。這個變量可以提供一些有用的信息，比如當前循環的索引，當前循環是不是首次迭代，又或者當前循環是不是最後一次迭代：

    @foreach ($users as $user)
        @if ($loop->first)
            This is the first iteration.
        @endif

        @if ($loop->last)
            This is the last iteration.
        @endif

        <p>This is user {{ $user->id }}</p>
    @endforeach

如果你是在一個嵌套的循環中，你可以通過使用 `$loop` 變量的 `parent` 屬性來獲取父循環中的 `$loop` 變量：

    @foreach ($users as $user)
        @foreach ($user->posts as $post)
            @if ($loop->parent->first)
                This is first iteration of the parent loop.
            @endif
        @endforeach
    @endforeach

`$loop` 變量也包含了其它各種有用的屬性：

屬性  | 描述
------------- | -------------
`$loop->index`  |  當前循環所迭代的索引，起始為 0。
`$loop->iteration`  |  當前迭代數，起始為 1。
`$loop->remaining`  |  循環中迭代剩余的數量。
`$loop->count`  |  被迭代項的總數量。
`$loop->first`  |  當前迭代是否是循環中的首次迭代。
`$loop->last`  |  當前迭代是否是循環中的最後一次迭代。
`$loop->depth`  |  當前循環的嵌套深度。
`$loop->parent`  |  當在嵌套的循環內時，可以訪問到父循環中的 $loop 變量。

<a name="comments"></a>
### 注釋

Blade 也允許在頁面中定義注釋，然而，跟 HTML 的注釋不同的是，Blade 注釋不會被包含在應用程序返回的 HTML 內：

    {{-- 此注釋將不會出現在渲染後的 HTML --}}

<a name="php"></a>
### PHP

在某些情況下，它對於你在視圖文件中嵌入 php 代碼是非常有幫助的。你可以在你的模版中使用 Blade 提供的 `@php` 指令來執行一段純 PHP 代碼：

    @php
        //
    @endphp

> {tip} 雖然 Blade 提供了這個功能，但頻繁地使用也同時意味著你在你的模版中嵌入了太多的邏輯了。

<a name="including-sub-views"></a>
## 引入子視圖

你可以使用 Blade 的 `@include` 命令來引入一個已存在的視圖，所有在父視圖的可用變量在被引入的視圖中都是可用的。

    <div>
        @include('shared.errors')

        <form>
            <!-- Form Contents -->
        </form>
    </div>

盡管被引入的視圖會繼承父視圖中的所有Data，你也可以通過傳遞額外的數組Data至被引入的頁面：

    @include('view.name', ['some' => 'data'])

當然，如果你嘗試使用 `@include` 去引用一個不存在的視圖，Laravel 會拋出錯誤。如果你想引入一個視圖，而你又無法確認這個視圖存在與否，你可以使用 `@includeIf` 指令:

    @includeIf('view.name', ['some' => 'data'])

> {note} 請避免在 Blade 視圖中使用 `__DIR__` 及 `__FILE__` 常量，因為他們會引用視圖被緩存的位置。

<a name="rendering-views-for-collections"></a>
### 為集合渲染視圖

你可以使用 Blade 的 `@each` 命令將循環及引入結合成一行代碼：

    @each('view.name', $jobs, 'job')

第一個參數為每個元素要渲染的子視圖，第二個參數是你要迭代的數組或集合，而第三個參數為迭代時被分配至子視圖中的變量名稱。舉個例子，如果你需要迭代一個 `jobs` 數組，通常子視圖會使用 `job` 作為變量來訪問 job 信息。子視圖使用 `key` 變量作為當前迭代的鍵名。

你也可以傳遞第四個參數到 `@each` 命令。當需要迭代的數組為空時，將會使用這個參數提供的視圖來渲染。

    @each('view.name', $jobs, 'job', 'view.empty')

<a name="stacks"></a>
## 堆疊

Blade 也允許你在其它視圖或layout中為已經命名的堆棧中壓入Data，這在子視圖中引入必備的 JavaScript 類庫時尤其有用：

    @push('scripts')
        <script src="/example.js"></script>
    @endpush

你可以根據需要多次壓入堆棧，通過 `@stack` 命令中鍵入堆棧的名字來渲染整個堆棧：

    <head>
        <!-- Head Contents -->

        @stack('scripts')
    </head>

## 如何載入 style、js、img ##


    <link href="{{ asset('styles/bootstrap.min.css') }}" rel="stylesheet">

    <script src="{{ asset('scripts/bootstrap.min.js') }}"></script>

    <img src="{{ asset('images/icon.png') }}" />

## 如何使用連結 ##

    <a href="{{ url('index') }}">首頁</a>

Ajax

    $.get('{{ url('test') }}', {}, function(data){
        console.log(data);
    });