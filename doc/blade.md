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
