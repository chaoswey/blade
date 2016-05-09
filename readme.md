# weya blade #

    git clone https://chaoswey@bitbucket.org/chaoswey/blade.git

## 更新說明 ##

* 1.0.1

修改 readme.md

* 1.0.0

## require package ##

* laravel-blade

> philo/laravel-blade: https://github.com/PhiloNL/Laravel-Blade

## 如何使用 ##

將 xxx.html、xxx.php 改成 xxx.blade.php

放入 views 資料夾裡面

開啟瀏覽器 輸入 localhost/[資料夾名稱]/[html檔名]

## 指令介紹 ##

    @extends(....)

表示要繼承哪個樣板

    @section ... @show

代表一個區段，我們給這個區段一個名稱 sidebar，表示要放側選單的內容。你可以在這個區段中加入 HTML，而在繼承它的子樣板中，可以重新定義(即覆蓋)這個區段的內容。

    @yield(....)

表示一個交由繼承它的子樣板定義的區段，如果子樣板未定義，就不會顯示任何內容。

    @include(....)

目前這個樣板可以包含其他的"片段樣板"，片段樣板不會有完整的 HTML，而是代表某個部份的 HTML 片段。它被包含進這個主樣板中，屬於這個主樣板。

重覆執行

    @for ($i = 0; $i < 10; $i++)
        第 {{ $i }} 圈。
    @endfor

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


## 資料結構說明 ##

cache - 自動產生 Html 快取

error - 404 錯誤

public - style、js、img...

vendor - 程式

views - blade.php

----
更詳細的資料請參考 Laravel 文件: https://laravel.tw/docs/5.2/blade