# Blade模板

- [簡介](#introduction)
- [模板繼承](#template-inheritance)
    - [定義布局](#defining-a-layout)
    - [繼承布局](#extending-a-layout)
- [Components & Slots](#components-and-slots)
- [顯示數據](#displaying-data)
    - [Blade & JavaScript 框架](#blade-and-javascript-frameworks)
- [流程控制](#control-structures)
    - [If 語句](#if-statements)
    - [Switch 語句](#switch-statements)
    - [循環](#loops)
    - [循環變量](#the-loop-variable)
    - [註釋](#comments)
    - [PHP](#php)
- [表單](#forms)
    - [CSRF 字段](#csrf-field)
    - [Method 字段](#method-field)
- [引入子視圖](#including-sub-views)
    - [為集合渲染視圖](#rendering-views-for-collections)
- [堆棧](#stacks)
- [服務註入](#service-injection)
- [Blade 擴展](#extending-blade)
    - [自定義 If 語句](#custom-if-statements)

<a name="introduction"></a>
## 簡介

Blade 是 Laravel 提供的一個簡單而又強大的模板引擎。和其他流行的 PHP 模板引擎不同，Blade 並不限制你在視圖中使用原生 PHP 代碼。所有 Blade 視圖文件都將被編譯成原生的 PHP 代碼並緩存起來，除非它被修改，否則不會重新編譯，這就意味著 Blade 基本上不會給你的應用增加任何負擔。Blade 視圖文件使用 `.blade.php` 作為文件擴展名，被存放在 `resources/views` 目錄。

<a name="template-inheritance"></a>
## 模板繼承

<a name="defining-a-layout"></a>
### 定義布局

Blade 的兩個主要優點是`模板繼承`和`區塊 `。為方便入門，讓我們先通過一個簡單的例子來上手。首先，我們來研究一個「主」頁面布局。因為大多數 web 應用會在不同的頁面中使用相同的布局方式，因此可以很方便地定義單個 Blade 布局視圖：

    <!-- 保存在  resources/views/layouts/app.blade.php 文件中 -->

    <html>
        <head>
            <title>App Name - @yield('title')</title>
        </head>
        <body>
            @section('sidebar')
                This is the master sidebar.
            @show

            <div class="container">
                @yield('content')
            </div>
        </body>
    </html>

如你所見，該文件包含了典型的 HTML 語法。不過，請註意 `@section` 和 `@yield` 指令。 `@section` 指令定義了視圖的一部分內容，而 `@yield` 指令是用來顯示指定部分的內容。

現在，我們已經定義好了這個應用程序的布局，接下來，我們定義一個繼承此布局的子頁面。

<a name="extending-a-layout"></a>
### 擴展布局

在定義一個子視圖時，使用 Blade 的 `@extends` 指令指定子視圖要「繼承」的視圖。擴展自 Blade 布局的視圖可以使用 `@section` 指令向布局片段註入內容。就如前面的示例中所示，這些片段的內容將由布局中的顯示在布局中 `@yield` 指令控制顯示：

    <!-- 保存在 resources/views/child.blade.php 中 -->

    @extends('layouts.app')

    @section('title', 'Page Title')

    @section('sidebar')
        @parent

        <p>This is appended to the master sidebar.</p>
    @endsection

    @section('content')
        <p>This is my body content.</p>
    @endsection

在這個示例中， `sidebar` 片段利用 `@parent` 指令向布局的 sidebar 追加（而非覆蓋）內容。 在渲染視圖時，`@parent` 指令將被布局中的內容替換。

> {tip} 和上一個示例相反，這裏的  `sidebar` 片段使用  `@endsection` 代替 `@show` 來結尾。 `@endsection` 指令僅定義了一個片段， `@show` 則在定義的同時 **立即 yield** 這個片段。

Blade 視圖可以使用全局  `view` 助手自路由中返回：

    Route::get('blade', function () {
        return view('child');
    });

<a name="components-and-slots"></a>
## 組件 & 插槽

組件和插槽提供了與片段和布局類似的好處；不過組件和插槽的思維模型更易於理解。我們先來看一個可覆用的「alert」組件，我們想在應用中覆用它：

    <!-- /resources/views/alert.blade.php -->

    <div class="alert alert-danger">
        {{ $slot }}
    </div>

 `{{ $slot }}` 變量將包含我們想要註入到組件的內容。現在，我們使用 Blade 的 `@component`  指令構建這個組件：

    @component('alert')
        <strong>Whoops!</strong> Something went wrong!
    @endcomponent

有時候為一個組件定義多個插槽是很有用的。修改 alert 組件以允許其註入 「title」。命名插槽可以通過與其匹配的 「回顯」 變量顯示：

    <!-- /resources/views/alert.blade.php -->

    <div class="alert alert-danger">
        <div class="alert-title">{{ $title }}</div>

        {{ $slot }}
    </div>

現在，我們能夠使用 `@slot` 指令向命名插槽註入內容。不在  `@slot` 指令內的內容都將傳遞給組件中的  `$slot` 變量：

    @component('alert')
        @slot('title')
            Forbidden
        @endslot

        You are not allowed to access this resource!
    @endcomponent

#### 向組件傳遞額外的數據

有時你可能需要向組件傳遞額外的數據。在這種情況下，可以把包含數據組織成數組，作為 `@component` 指令的第二個參數。所有的數據將作為變更提供給組件模板：

    @component('alert', ['foo' => 'bar'])
        ...
    @endcomponent



#### 給組件起別名

如果組件存儲在子目錄中，你可能希望給它們起個別名以方便訪問。舉例來說，如果一個 Blade 組件存儲在 `resources/views/components/alert.blade.php`中，. 就可以使用 `component` 方法將 `components.alert` 的別名命名為 `alert`。. 通常情況下，這一過程將在 `AppServiceProvider` 的  `boot` 方法中完成：

    use Illuminate\Support\Facades\Blade;

    Blade::component('components.alert', 'alert');

一旦組件有了別名，就可以使用一條指令渲染它：

    @alert(['type' => 'danger'])
        You are not allowed to access this resource!
    @endalert

如果沒有額外的插槽，還可以省略組件參數：

    @alert
        You are not allowed to access this resource!
    @endalert

<a name="displaying-data"></a>
## 顯示數據

可以通過包裹在雙花括號內的變量顯示傳遞給 Blade 視圖的數據。比如給出如下路由：

    Route::get('greeting', function () {
        return view('welcome', ['name' => 'Samantha']);
    });

就可以這樣利用 `name` 變量顯示其內容：

    Hello, {{ $name }}.

> {tip} Blade `{{ }}` 語句是自動經過  PHP 的 `htmlspecialchars`函數傳遞來防範  XSS 攻擊的。

不限於顯示傳遞給視圖的變量的內容，你還可以顯示任一 PHP 函數的結果。實際上，你可以在Blade 的回顯語句中放置你想要的任意 PHP 代碼：

    The current UNIX timestamp is {{ time() }}.

#### 顯示非轉義字符

默認情況下， Blade 中 `{{ }}` 語句自動經由 PHP 的 `htmlspecialchars` 函數傳遞以防範 XSS 攻擊。如果不希望數據被轉義，可以使用下面的語法：

    Hello, {!! $name !!}.

> {note} 在回顯應用的用戶提供的內容時需要謹慎小心。在顯示用戶提供的數據時，有必要一直使用雙花括號語法轉義來防範 XSS 攻擊。



#### 渲染 JSON

有時，為了初始化一個 JavaScript 變量，你可能會向視圖傳遞一個數據，並將其渲染成 JSON：

    <script>
        var app = <?php echo json_encode($array); ?>;
    </script>

不過，你可以使用 `@json` Blade 指令代替手動調用 `json_encode` 函數：

    <script>
        var app = @json($array);
    </script>

#### HTML 實體編碼

默認情況下，Blade （以及 Laravel 的 `e` 助手）將對 HTML 實體雙重編碼。如果要禁用雙重編碼，可以在 `AppServiceProvider` 的 `boot` 中調用 `Blade::withoutDoubleEncoding` 方法：

    <?php

    namespace App\Providers;

    use Illuminate\Support\Facades\Blade;
    use Illuminate\Support\ServiceProvider;

    class AppServiceProvider extends ServiceProvider
    {
        /**
         * 引導任意應用服務。
         *
         * @return void
         */
        public function boot()
        {
            Blade::withoutDoubleEncoding();
        }
    }

<a name="blade-and-javascript-frameworks"></a>
### Blade & JavaScript 框架

由於很多 JavaScript 框架也使用花括號表明給定的表達式將要在瀏覽器中顯示， 可以使用 `@` 符號通知 Blade 渲染引擎某個表達式應保持不變。示例如下：

    <h1>Laravel</h1>

    Hello, @{{ name }}.

在這個例子中， `@` 符號將被 Blade 刪除；在 Blade 引擎中 `{{ name }}` 表達式將保持不變，取而代之的是 JavaScript 引擎將渲染該表達式。

####  `@verbatim` 指令

如果要在大段的模板中 JavaScript 變量，可以將 HTML 包裹在 `@verbatim` 指令中，這樣就不需要為每個 Blade 回顯語句添加 `@` 符號:

    @verbatim
        <div class="container">
            Hello, {{ name }}.
        </div>
    @endverbatim

<a name="control-structures"></a>
## 控制結構

除了模板繼承和數據顯示， Blade 還為分支和循環等 PHP 控制結構提供了方便的快捷方式。這些快捷方式提供了幹凈、簡捷地處理 PHP 控制結構的方法，同時保持了與 PHP 中的對應結構的相似性。

<a name="if-statements"></a>
### If 語句

可以使用 `@if`、 `@elseif`、 `@else` 和 `@endif` 指令構造 `if` 語句。這些指令的功能與相應的 PHP 指令相同：

    @if (count($records) === 1)
        I have one record!
    @elseif (count($records) > 1)
        I have multiple records!
    @else
        I don't have any records!
    @endif

方便起見， Blade 還提供了 `@unless` 指令：

    @unless (Auth::check())
        You are not signed in.
    @endunless

除了已經討論過的條件指令， `@isset` 和 `@empty` 指令可以作為各自對應的 PHP 函數的快捷方式：

    @isset($records)
        // $records 被定義且不是  null...
    @endisset

    @empty($records)
        // $records 為空...
    @endempty



#### 身份驗證指令

 `@auth` 和 `@guest` 指令能夠用於快速確定當前用戶是經過身份驗證的，還是一個訪客：

    @auth
        // 此用戶身份已驗證...
    @endauth

    @guest
        // 此用戶身份未驗證...
    @endguest

如果需要，可以在使用 `@auth` 和 `@guest` 指令時指定應被校驗的 [身份](/docs/{{version}}/authentication) ：

    @auth('admin')
        // 此用戶身份已驗證...
    @endauth

    @guest('admin')
        // 此用戶身份未驗證...
    @endguest

#### 片段指令

可以使用 `@hasSection` 指令檢查片斷是否存在內容：

    @hasSection('navigation')
        <div class="pull-right">
            @yield('navigation')
        </div>

        <div class="clearfix"></div>
    @endif

<a name="switch-statements"></a>
### Switch 指令

可以使用  `@switch`、 `@case`、 `@break`、 `@default` 和 `@endswitch` 指令構造 switch 語句：

    @switch($i)
        @case(1)
            First case...
            @break

        @case(2)
            Second case...
            @break

        @default
            Default case...
    @endswitch

<a name="loops"></a>
### 循環

除了分支語句，Blade 還提供了與 PHP 的循環結構相同的簡化指令。這些指令的功能也與相應的 PHP 指令相同：

    @for ($i = 0; $i < 10; $i++)
        The current value is {{ $i }}
    @endfor

    @foreach ($users as $user)
        <p>This is user {{ $user->id }}</p>
    @endforeach

    @forelse ($users as $user)
        <li>{{ $user->name }}</li>
    @empty
        <p>No users</p>
    @endforelse

    @while (true)
        <p>I'm looping forever.</p>
    @endwhile

> {tip} 循環中可以使用 [循環變量](#the-loop-variable) 獲取循環的可評估信息，比如現在是處於循環的第一次叠代還是最後一次叠代中：

在循環中，還可以終結循環或路過本次叠代：

    @foreach ($users as $user)
        @if ($user->type == 1)
            @continue
        @endif

        <li>{{ $user->name }}</li>

        @if ($user->number == 5)
            @break
        @endif
    @endforeach

也可以在一行中聲明帶有條件的指令：

    @foreach ($users as $user)
        @continue($user->type == 1)

        <li>{{ $user->name }}</li>

        @break($user->number == 5)
    @endforeach



<a name="the-loop-variable"></a>
### 循環變量

循環過程中，在循環體內有一個可用的 `$loop` 變量。該變量提供了用於訪問諸如當前循環的索引、當前是否為第一次或最後一次循環之類的少數有用的信息的途徑：

    @foreach ($users as $user)
        @if ($loop->first)
            This is the first iteration.
        @endif

        @if ($loop->last)
            This is the last iteration.
        @endif

        <p>This is user {{ $user->id }}</p>
    @endforeach

在嵌套循環中，可以借助 `parent` 屬性訪問父循環的 `$loop`變量：

    @foreach ($users as $user)
        @foreach ($user->posts as $post)
            @if ($loop->parent->first)
                This is first iteration of the parent loop.
            @endif
        @endforeach
    @endforeach

 `$loop` 變量還包含其它幾種有用的屬性：

屬性  | 描述
------------- | -------------
`$loop->index`  |  當前叠代的索引（從 0 開始計數）。
`$loop->iteration`  |  當前循環叠代 (從 1 開始計算）。
`$loop->remaining`  |  循環中剩余叠代的數量。
`$loop->count`  |  被叠代的數組元素的總數。
`$loop->first`  |  是否為循環的第一次叠代。
`$loop->last`  |  是否為循環的最後一次叠代。
`$loop->depth`  |  當前叠代的嵌套深度級數。
`$loop->parent`  |  嵌套循環中，父循環的循環變量

<a name="comments"></a>
### 註釋

Blade 也允許在視圖中定義註釋。不過與 HTML 註釋不同，Blade 註釋不會包含在返回給應用的 HTML 中：

    {{-- This comment will not be present in the rendered HTML --}}

<a name="php"></a>
### PHP

某些情況下，在視圖中嵌入 PHP 代碼很有用。可以在模板中使用  `@php` 指令執行原生的 PHP 代碼塊：

    @php
        //
    @endphp

> {tip} 盡管 Blade 提供了這個特性，但頻繁使用意味著模板中嵌入了過多的邏輯。

<a name="forms"></a>
## 表單

<a name="csrf-field"></a>
### CSRF 域

只要在應用中定義了 HTML 表單，就一定要在表單中包含隱藏的 CSRF 令牌域，這樣一來 [CSRF 保護](https://laravel.com/docs/{{version}}/csrf) 中間件就能校驗請求。可以使用 Blade 的 `@csrf` 指令生成令牌域：

    <form method="POST" action="/profile">
        @csrf

        ...
    </form>

<a name="method-field"></a>
### Method 域

HTML 表單不能發出 `PUT`、 `PATCH` 及 `DELETE` 請求，需要加入隱藏的 `_method` 域來模仿這些 HTTP 動詞。Blade 的 `@method` 指令能夠幫你創建這個域：

    <form action="/foo/bar" method="POST">
        @method('PUT')

        ...
    </form>

<a name="including-sub-views"></a>
## 引入子視圖

Blade 的 `@include` 指令允許你從其它視圖中引入 Blade 視圖。父視圖中所有可用的變量都將在被引入的視圖中可用：

    <div>
        @include('shared.errors')

        <form>
            <!-- Form Contents -->
        </form>
    </div>

被包含的視圖不僅會繼承父視圖的所有可用數據，還能夠以數組形式向被包含的視圖傳遞額外數據：

    @include('view.name', ['some' => 'data'])

如果傳遞給  `@include` 一個不存在的視圖，Laravel 會拋出錯誤。想要包含一個不能確定存在與否的視圖，需要使用 `@includeIf` 指令：

    @includeIf('view.name', ['some' => 'data'])

想要包含一個依賴於給定布爾條件的視圖，可以使用 `@includeWhen` 指令：

    @includeWhen($boolean, 'view.name', ['some' => 'data'])

要包含給定視圖數組中第一個存在的視圖，可以使用 `includeFirst` 指令：

    @includeFirst(['custom.admin', 'admin'], ['some' => 'data'])

> {note} 應當盡量避免在 Blade 視圖中使用 `__DIR__` 和 `__FILE__` 魔術常量，因為它們將指向緩存中經過編譯的視圖的位置。



#### 給被包含的視圖起別名

如果你的 Blade 被包含視圖們存儲在子目錄中，你可能會希望為它們起個易於訪問的別名。例如，一個帶有如下內容的 Blade 視圖內容被存儲在 `resources/views/includes/input.blade.php` 文件中：

    <input type="{{ $type ?? 'text' }}">

可以使用 `include` 方法為  `includes.input` 起一個叫做 `input` 的別名。通常，這會在 `AppServiceProvider` 的 `boot` 方法中完成：

    use Illuminate\Support\Facades\Blade;

    Blade::include('includes.input', 'input');

一旦被包含的視圖擁有了別名，就可以像 Blade 指令一樣使用別名渲染它：

    @input(['type' => 'email'])

<a name="rendering-views-for-collections"></a>
### 為集合渲染視圖

可以使用 Blade 的 `@each` 指令在一行中整合循環和包含：

    @each('view.name', $jobs, 'job')

第一個參數是渲染數組或集合的每個元素的視圖片段。第二個參數是希望被叠代的數組或集合，第三個參數則是將被分配給視圖中當前叠代的變量名。例如，想要叠代 `jobs` 數組，通常會在視圖片段中使用 `job` 變量訪問每個任務。當前叠代的 key 將作為視圖片段中的 `key` 變量。

也可以向 `@each` 指令傳遞第四個參數。這個參數是當給定數組為空時要渲染的視圖片段。

    @each('view.name', $jobs, 'job', 'view.empty')

> {note} 借助 `@each` 渲染視圖，無法從父視圖中繼承變量。如果子視圖需要這些變量，就必須使用 `@foreach` 和 `@include` 代替它。

<a name="stacks"></a>
## 堆棧

Blade 允許你將視圖壓入堆棧，這些視圖能夠在其它視圖或布局中被渲染。這在子視圖中指定需要的 JavaScript 庫時非常有用：

    @push('scripts')
        <script src="/example.js"></script>
    @endpush

如果需要，可以多次壓入堆棧。通過向  `@stack` 指令傳遞堆棧名稱來完成堆棧內容的渲染：

    <head>
        <!-- 頭部內容 -->

        @stack('scripts')
    </head>

如果想要將內容預置在棧頂，需要使用 `@prepend` 指令：

    @push('scripts')
        This will be second...
    @endpush

    // 然後...

    @prepend('scripts')
        This will be first...
    @endprepend

<a name="service-injection"></a>
## Service 註入

 `@inject` 指令可以用於自 Laravel 的 [服務容器](/docs/{{version}}/container) 中獲取服務。傳遞給 `@inject` 的第一個參數是將要置入的服務變量名，第二個參數是希望被解析的類或接口名：

    @inject('metrics', 'App\Services\MetricsService')

    <div>
        Monthly Revenue: {{ $metrics->monthlyRevenue() }}.
    </div>



<a name="extending-blade"></a>
## 擴展 Blade

Blade 允許你使用 `directive` 方法自定義指令。當 Blade 編譯器遇到自定義指令時，這會調用該指令包含的表達式提供的回調。

下面的例子創建了 `@datetime($var)` 指令，一個格式化給定的 `DateTime` 的實例 `$var`：

    <?php

    namespace App\Providers;

    use Illuminate\Support\Facades\Blade;
    use Illuminate\Support\ServiceProvider;

    class AppServiceProvider extends ServiceProvider
    {
        /**
         * 執行註冊後引導服務.
         *
         * @return void
         */
        public function boot()
        {
            Blade::directive('datetime', function ($expression) {
                return "<?php echo ($expression)->format('m/d/Y H:i'); ?>";
            });
        }

        /**
         * 在容器中註冊綁定.
         *
         * @return void
         */
        public function register()
        {
            //
        }
    }

如你所見，我們將在傳遞給該指令的任意表達式中鏈式調用  `format` 方法。在這個例子中，該指令將生成如下原生 PHP 代碼：

    <?php echo ($var)->format('m/d/Y H:i'); ?>

> {note} 在更新Blade 指令的邏輯之後，需要 Blade 視圖的所有緩存。可以使用  `view:clear` Artisan 命令刪除 Blade 視圖緩存。

<a name="custom-if-statements"></a>
### 自定義 If 語句

在定義簡單的、自定義條件語句時，編寫自定義指令比必須的步驟覆雜。在這種情況下，Blade 提供了 `Blade::if` 方法，它允許你使用閉包快速度定義條件指令。例如，定義一個校驗當前應用環境的自定義指令，可以在  `AppServiceProvider` 的 `boot` 方法中這樣做：

    use Illuminate\Support\Facades\Blade;

    /**
     * 執行註冊後引導服務
     *
     * @return void
     */
    public function boot()
    {
        Blade::if('env', function ($environment) {
            return app()->environment($environment);
        });
    }

一旦定義了自定義條件指令，就可以在模板中輕松的使用：

    @env('local')
        // 應用在本地環境中運行...
    @elseenv('testing')
        // 應用在測試環境中運行...
    @else
        // 應用沒有在本地和測試環境中運行...
    @endenv