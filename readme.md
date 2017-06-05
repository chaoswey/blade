# weya blade #

    git clone http://gitlab.weya.tw/weya/blade.git

## 快速連結 ##

[laravel-mix](http://gitlab.weya.tw/weya/blade/blob/master/doc/mix.md)

[laravel-blade](http://gitlab.weya.tw/weya/blade/blob/master/doc/blade.md)

`new` [request](http://gitlab.weya.tw/weya/blade/blob/master/doc/request.md)

## 更新說明 ##

[更新說明](http://gitlab.weya.tw/weya/blade/blob/master/doc/changelog.md)

## clone 注意事項

請刪除以下檔案

    .git
    doc/
    composer.json
    composer.lock
    readme.md

## 發布檔案前注意事項

只要上傳以下檔案

    app/
    public/
    resources/views/
           ../.htaccess
           ../index.html
    vendor/
    index.php
    .htaccess

特別要注意 app/cache/ 要改權限成 777

![0](/uploads/5784d4052961732f27a2e3312c314c38/0.png)
![1](/uploads/808e137cf41289e9e4f8a51cf702d614/1.PNG)


## 資料結構說明 ##

app - 自動產生 Html 快取，主程式

public - style、js、img...

vendor - 核心程式

|resources||
| :---: |:---:|
| - assets|style、js、img 原始碼|
| - views|blade.php|

## require package ##

* laravel-blade

> philo/laravel-blade: https://github.com/PhiloNL/Laravel-Blade


----

## 如何載入 style、js、img ##


    <link href="{{ asset('styles/bootstrap.min.css') }}" rel="stylesheet">

    <script src="{{ asset('scripts/bootstrap.min.js') }}"></script>

    <img src="{{ asset('images/icon.png') }}" />

## 如何使用連結 ##

    <a href="{{ url('/') }}">首頁</a>

Ajax

    $.get('{{ url('/test') }}', {}, function(data){
        console.log(data);
    });