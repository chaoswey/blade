# cc blade #
    
# 說明

此專案給後端是 **laravel** 前端工程師 or 網頁設計師 使用

不需要 composer install, vendor 打包進專案裡面，預防 前端工程師 or 網頁設計師 不會使用

使用 [語意化版本 2.0](https://semver.org/lang/zh-TW/)

## 使用方式

依照 創建 blade 目錄 生成 route

> 在 resources/views 創建 xxx.blade.php 網址將會是 **http://localhost:8088/xxx**

> 在 resources/views 創建 blog/xxx.blade.php 網址將會是 **http://localhost:8088/blog/xxx**

如果 使用資料夾模式打開

> 網址將會是 **http://localhost/you dir/xxx**, **http://localhost/you dir/blog/xxx**

如果 Apache 沒有設定 .htaccess

> 沒有使用 `php -S localhost:8088`

>> 網址將會是 **http://localhost/index.php/you dir/xxx**, **http://localhost/index.php/you dir/blog/xxx**

> 有使用 `php -S localhost:8088`

>> 或者 **http://localhost:8088/index.php/xxx**, **http://localhost/index.php/blog/xxx**

## 建議使用方式

使用 `php -S localhost:8088`

## 建議設定

Apache 設定 `AllowOverride All`

```
<Directory "you path">
        Options Indexes FollowSymLinks MultiViews ExecCGI
        AllowOverride All
        Order allow,deny
        Allow from all
</Directory>
```

## 快速連結 ##

|介紹|網址|
|:---:|:---|
|laravel-mix webpack 操作說明|[laravel-mix](./framework/blade/src/master/doc/mix.md)|
|blade 樣板引擎說明|[laravel-blade](./framework/blade/src/master/doc/blade.md)|
|判斷網址|[request](./framework/blade/src/master/doc/request.md)|

## 更新說明 ##

[更新說明](./framework/blade/src/master/doc/changelog.md)

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
    robots.txt

特別要注意 app/cache/ 要改權限成 777

## 資料結構說明 ##

|資料夾|說明|
|:---:|:---|
|app|自動產生 Html 快取，主程式|
|public|min.js、min.css、img...etc|
|vendor|核心程式|
|resources|<ul><li>- style、js、img 原始碼</li><li>- views: blade.php</li></ul>|


## require package ##

|套件名稱|作用|網址|
|:---:|:---:|:---|
|philo/laravel-blade|laravel blade|https://github.com/PhiloNL/Laravel-Blade|
|symfony/console|console 套件|https://github.com/symfony/console|


----

## 如何載入 style、js、img ##
```php
    <link href="{{ asset('styles/bootstrap.min.css') }}" rel="stylesheet">
    <script src="{{ asset('scripts/bootstrap.min.js') }}"></script>
    <img src="{{ asset('images/icon.png') }}" />
```

## 如何使用連結 ##
```php
    <a href="{{ url('/') }}">首頁</a>
```

Ajax

```php
    $.get('{{ url('/test') }}', {}, function(data){
        console.log(data);
    });
```

----

## 輸出成 html ##

blade 輸出成 html

執行前 請將 php 加入 global path

打開 command shell (cmd, PowerShell, bash ...etc)

預設會在當前目錄下創建 `html` 目錄

```
php cc b2html
```

指定特定目錄 `--output=path`

```
php cc b2html --output=D:\html
```

以下有幾個要輸入

1. 清除目標資料夾嗎? 輸入 yes or no 預設是 NO
```
Clear Target Dir ? [yes,default: no] no
```

2. 輸入新的網址 列如: http://www.demo.com.tw ， https://www.demo.com.tw 或者 http://www.demo.com.tw/project

```
Enter new URL: http://www.demo.com.tw
```