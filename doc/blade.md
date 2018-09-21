# Laravel 的 Blade 模板引擎

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
- [引入子視圖](#including-sub-views)
    - [為集合渲染視圖](#rendering-views-for-collections)
- [堆棧](#stacks)

<a name="introduction"></a>
## 簡介

Blade 是 Laravel 提供的一個簡單而又強大的模板引擎。和其他流行的 PHP 模板引擎不同，Blade 並不限制你在視圖中使用原生 PHP 代碼。所有 Blade 視圖文件都將被編譯成原生的 PHP 代碼並緩存起來，除非它被修改，否則不會重新編譯，這就意味著 Blade 基本上不會給你的應用增加任何負擔。Blade 視圖文件使用 `.blade.php` 作為文件擴展名，被存放在 `resources/views` 目錄。

<a name="template-inheritance"></a>
## 模板繼承

<a name="defining-a-layout"></a>
### 定義布局

Blade 的兩個主要優點是 _模板繼承_ 和 _區塊_ 。為方便開始，讓我們先通過一個簡單的例子來上手。首先，我們來研究一個「主」頁面布局。因為大多數 web 應用會在不同的頁面中使用相同的布局方式，因此可以很方便地定義單個 Blade 布局視圖：

    <!-- 文件保存於 resources/views/layouts/app.blade.php -->

    <html>
        <head>
            <title>應用程序名稱 - @yield('title')</title>
        </head>
        <body>
            @section('sidebar')
                這是主布局的側邊欄。
            @show

            <div class="container">
                @yield('content')
            </div>
        </body>
    </html>

如你所見，該文件包含了典型的 HTML 語法。不過，請註意 `@section` 和 `@yield` 命令。顧名思義，`@section` 命令定義了視圖的一部分內容，而  `@yield` 指令是用來顯示指定部分的內容。

現在，我們已經定義好了這個應用程序的布局，接下來，我們定義一個繼承此布局的子頁面。

<a name="extending-a-layout"></a>
### 繼承布局

當定義子視圖時，你可以使用 Blade 提供的 `@extends` 命令來為子視圖指定應該 「繼承」 的布局。 繼承 Blade 布局的視圖可使用 `@section` 命令將內容註入於布局的 `@section` 中。而「主」布局中使用 `@yield` 的地方會顯示這些子視圖中的  `@section` 間的內容：

````
<!-- 文件保存於 resources/views/layouts/child.blade.php -->

@extends('layouts.app')

@section('title', 'Page Title')

@section('sidebar')
    @parent

    <p>這將追加到主布局的側邊欄。</p>
@endsection

@section('content')
    <p>這是主體內容。</p>
@endsection
````

在上面的例子裏，`@section` 中的 `sidebar` 使用 `@@parent` 命令在「主」布局的 `@section('sidebar')` 中增加內容（不是覆蓋）。渲染視圖時，`@@parent` 指令會被替換為「主」布局中 `@section('sidebar')` 間的內容。

> {tip} 與上一個示例相反，此側邊欄部分以 `@endsection` 而不是 `@show` 結尾。 `@endsection` 指令只定義一個區塊，而 `@show` 則是定義並立即生成該區塊。

你也可以通過在路由中使用全局輔助函數 `view` 來返回 Blade 視圖：

    Route::get('blade', function () {
        return view('child');
    });

<a name="components-and-slots"></a>
## Components & Slots

Components 和 slots 類似於布局中的 `@section`，但其使用方式更容易使人理解。首先，假設我們有一個能在整個應用程序中被重覆使用的「警告」組件:

    <!-- /resources/views/alert.blade.php -->

    <div class="alert alert-danger">
        {{ $slot }}
    </div>

`{{ $slot }}` 變量將包含我們希望註入到組件的內容。然後，我們可以使用 Blade 命令 `@component` 來構建這個組件：

    @component('alert')
        <strong>Whoops!</strong> Something went wrong!
    @endcomponent

有時為組件定義多個 slots 是很有幫助的。現在我們要對「警報」組件進行修改，讓它可以註入「標題」。通過簡單地 「打印」匹配其名稱的變量來顯示被命名的 `@slot` 之間的內容：


    <!-- /resources/views/alert.blade.php -->

    <div class="alert alert-danger">
        <div class="alert-title">{{ $title }}</div>

        {{ $slot }}
    </div>

現在，我們可以使用 `@slot` 指令註入內容到已命名的 slot 中，任何沒有被 `@slot` 指令包裹住的內容將傳遞給組件中的 `$slot` 變量:

    @component('alert')
        @slot('title')
            Forbidden
        @endslot

        你沒有權限訪問這個資源！
    @endcomponent

#### 傳遞額外的數據給組件

有時候你可能需要傳遞額外的數據給組件。你可以傳遞一個數組作為第二個參數傳遞給 `@component` 指令。所有的數據都將以變量的形式傳遞給組件模版:

    @component('alert', ['foo' => 'bar'])
        ...
    @endcomponent

<a name="displaying-data"></a>

## 顯示數據

你可以使用 「中括號」 包住變量將數據傳遞給 Blade 視圖。如下面的路由設置：

    Route::get('greeting', function () {
        return view('welcome', ['name' => 'Samantha']);
    });

你可以像這樣顯示 `name` 變量的內容：

    Hello, {{ $name }}.
當然，不僅僅只能用傳遞數據的方式讓視圖來顯示變量內容。你也可以打印 PHP 函數的結果。其實，你可以在 Blade 打印語法中放置任何 PHP 代碼：

    The current UNIX timestamp is {{ time() }}.

> {note} Blade 的 `{{ }}` 語法會自動調用 PHP `htmlspecialchars` 函數來避免 XSS 攻擊。

#### 顯示未轉義的數據

默認情況下，Blade 的 `{{ }}` 語法將會自動調用 PHP `htmlspecialchars` 函數來避免 XSS 攻擊。如果你不想你的數據被轉義，你可以使用下面的語法：

    Hello, {!! $name !!}.

> {note} 處理用戶輸入的數據時要非常小心。在顯示用戶提供的數據時，你應該始終使用轉義的 `{{  }}` 語法來防止 XSS 攻擊。

<a name="blade-and-javascript-frameworks"></a>

#### 渲染 JSON

當你將數組傳遞給視圖時，會將數組轉化成  JSON 數據，以此來初始化 JavaScript 變量。例如：

```
<script>
    var app = <?php json_encode($array); ?>;
</script>
```

你可以使用 Blade 指令 `@json` 來代替手動調用 `json_encode`：

```
<script>
    var app = @json($array)
</script>
```

### Blade & JavaScript 框架

由於很多 JavaScript 框架都使用花括號來表示給定的表達式應該在瀏覽器中顯示，你可以使用 `@` 符號來告知 Blade 渲染引擎你需要保留這個表達式原始形態，例如：

    <h1>Laravel</h1>

    Hello, @{{ name }}.

在這個例子裏，`@` 符號最終會被 Blade 引擎刪除，達到不受 Blade 模板引擎影響的目的，最終 `{{ name }}` 表達式會保持不變使得  JavaScript 框架可以使用它。

#### `@verbatim` 指令

如果你需要在頁面中大部分內容中展示 JavaScript 變量，你可以使用 `@verbatim` 指令來包裹 HTML 內容，這樣你就不必在每個Blade 打印語句前加上 `@` 符號：


    @verbatim
        <div class="container">
            Hello, {{ name }}.
        </div>
    @endverbatim

<a name="control-structures"></a>

## 流程控制

除了模板繼承與數據顯示的功能以外，Blade 還提供了常見的 PHP 流程控制語句，比如條件表達式和循環語句。這些語句與 PHP 語句的相似，與其一樣清晰簡明。

<a name="if-statements"></a>

### If 語句

你可以使用 `@if`、`@elseif`、`@else` 及  `@endif` 指令來構建 `if` 表達式。這些命令的功能等同於 PHP 中的語法：

    @if (count($records) === 1)
        我有一條記錄！
    @elseif (count($records) > 1)
        我有多條記錄！
    @else
        我沒有任何記錄！
    @endif

為了方便，Blade 還提供了一個 `@unless` 命令：

    @unless (Auth::check())
        你尚未登錄。
    @endunless

除了以上的條件指令之外，`@isset` 和 `@empty` 指令也可以視為與 PHP 函數有相同的功能：

    @isset($records)
        // $records 被定義並且不為空...
    @endisset

    @empty($records)
        // $records 是「空」的...
    @endempty
    
### Switch 語句

可以使用 `@switch`、`@case`、`@break`、`@default` 和 `@endswitch` 指令來構建 Switch 語句：

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

除了條件表達式外，Blade 也支持 PHP 的循環結構。同樣，以下這些指令中的每一個都與其 PHP 對應的函數相同：

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
        <p>死循環了。</p>
    @endwhile

> {tip} 循環時，你可以使用 [循環變量](#the-loop-variable) 來獲取循環的信息，例如是否在循環中進行第一次或最後一次叠代。

當使用循環時，你也可以結束循環或跳過當前叠代：

    @foreach ($users as $user)
        @if ($user->type == 1)
            @continue
        @endif

        <li>{{ $user->name }}</li>

        @if ($user->number == 5)
            @break
        @endif
    @endforeach

你還可以使用一行代碼包含指令聲明的條件：

    @foreach ($users as $user)
        @continue($user->type == 1)

        <li>{{ $user->name }}</li>

        @break($user->number == 5)
    @endforeach

<a name="the-loop-variable"></a>

### 循環變量

循環時，可以在循環內使用 `$loop` 變量。這個變量可以提供一些有用的信息，比如當前循環的索引，當前循環是不是首次叠代，又或者當前循環是不是最後一次叠代：

    @foreach ($users as $user)
        @if ($loop->first)
            這是第一個叠代。
        @endif

        @if ($loop->last)
            這是最後一個叠代。
        @endif

        <p>This is user {{ $user->id }}</p>
    @endforeach

在一個嵌套的循環中，可以通過使用 `$loop` 變量的 `parent` 屬性來獲取父循環中的 `$loop` 變量：

    @foreach ($users as $user)
        @foreach ($user->posts as $post)
            @if ($loop->parent->first)
                This is first iteration of the parent loop.
            @endif
        @endforeach
    @endforeach

`$loop` 變量也包含了其它各種有用的屬性：

| 屬性 | 描述 |
| ------- | ------ |
| `$loop->index`     | 當前循環叠代的索引（從0開始）。   |
| `$loop->iteration` | 當前循環叠代 （從1開始）。     |
| `$loop->remaining` | 循環中剩余叠代數量。         |
| `$loop->count`     | 叠代中的數組項目總數。        |
| `$loop->first`     | 當前叠代是否是循環中的首次叠代。   |
| `$loop->last`      | 當前叠代是否是循環中的最後一次叠代。 |
| `$loop->depth`     | 當前循環的嵌套級別。         |
| `$loop->parent`    | 在嵌套循環中，父循環的變量。     |

<a name="comments"></a>

### 註釋

Blade 也能在視圖中定義註釋。然而，跟 HTML 的註釋不同的，Blade 註釋不會被包含在應用程序返回的 HTML 內：

    {{-- 此註釋將不會出現在渲染後的 HTML --}}

<a name="php"></a>
### PHP

在某些情況下，將 PHP 代碼嵌入到視圖中很有用。你可以使用 Blade 的 `@php` 指令在模板中執行一段純 PHP 代碼：

    @php
        //
    @endphp

> {tip} 雖然 Blade 提供了這個功能，但頻繁地使用意味著你的模版被嵌入了太多的邏輯。

<a name="including-sub-views"></a>

## 引入子視圖

你可以使用 Blade 的 `@include` 命令來引入一個已存在的視圖，所有在父視圖的可用變量在被引入的視圖中都是可用的。

使用 Blade 的 `@include` 指令可以在 Blade 視圖中引入另一個視圖。父視圖可用的所有變量將提供給引入的視圖：

    <div>
        @include('shared.errors')

        <form>
            <!-- Form Contents -->
        </form>
    </div>

被引入的視圖會繼承父視圖中的所有數據，同時也可以向引入的視圖傳遞額外的數組數據：

    @include('view.name', ['some' => 'data'])

當然，如果嘗試使用 `@include` 去引入一個不存在的視圖，Laravel 會拋出錯誤。如果想引入一個可能存在或可能不存在的視圖，就使用 `@includeIf` 指令:

    @includeIf('view.name', ['some' => 'data'])

如果要根據給定的布爾條件 `@include` 視圖，可以使用 `@includeWhen` 指令：

    @includeWhen($boolean, 'view.name', ['some' => 'data'])

> {note} 請避免在 Blade 視圖中使用 `__DIR__` 及 `__FILE__` 常量，因為它們會引用編譯視圖時緩存的位置。

<a name="rendering-views-for-collections"></a>

### 為集合渲染視圖

你可以使用 Blade 的 `@each` 命令將循環及引入寫成一行代碼：

    @each('view.name', $jobs, 'job')
第一個參數是對數組或集合中的每個元素進行渲染的部分視圖。第二個參數是要叠代的數組或集合，而第三個參數是將被分配給視圖中當前叠代的變量名稱。舉個例子，如果你要叠代一個 `jobs` 數組，通常會使用子視圖中的變量 `job` 來獲取每個 job。當前叠代的 `key` 將作為子視圖中的 `key` 變量。

你也可以傳遞第四個參數到 `@each` 命令。當需要叠代的數組為空時，將會使用這個參數提供的視圖來渲染。

    @each('view.name', $jobs, 'job', 'view.empty')

> {note} 通過 `@each` 渲染的視圖不會從父視圖繼承變量。 如果子視圖需要這些變量，則應該使用 `@foreach` 和 `@include`。

<a name="stacks"></a>

## 堆棧

Blade 可以被推送到在其他視圖或布局中的其他位置渲染的命名堆棧。這在子視圖中指定所需的 JavaScript 庫時非常有用：

    @push('scripts')
        <script src="/example.js"></script>
    @endpush

你可以根據需要多次壓入堆棧，通過 `@stack` 命令中傳遞堆棧的名稱來渲染完整的堆棧內容：

    <head>
        <!-- Head Contents -->

        @stack('scripts')
    </head>

<a name="service-injection"></a>