# weya blade #

    git clone http://gitlab.weya.tw/weya/blade.git

## 快速連結 ##

[laravel-mix](/blob/master/doc/mix.md)

[laravel-blade](/blob/master/doc/blade.md)

## 更新說明 ##

[更新說明](/blob/master/doc/changelog.md)

## 資料結構說明 ##

app - 自動產生 Html 快取

public - style、js、img...

vendor - 程式

resources - blade.php

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