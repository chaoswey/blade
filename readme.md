# weya blade #

    git clone http://gitlab.weya.tw/weya/blade.git

## 快速連結 ##

|介紹|網址|
|:---:|:---|
|laravel-mix webpack 操作說明|[laravel-mix](https://gitea.weya.tw/framework/blade/src/master/doc/mix.md)|
|blade 樣板引擎說明|[laravel-blade](https://gitea.weya.tw/framework/blade/src/master/doc/blade.md)|
|判斷網址|`new` [request](https://gitea.weya.tw/framework/blade/src/master/doc/request.md)|
|假文字|`new` [faker](https://gitea.weya.tw/framework/blade/src/master/doc/image.md)|

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
    robots.txt

特別要注意 app/cache/ 要改權限成 777

![0](/uploads/5784d4052961732f27a2e3312c314c38/0.png)
![1](/uploads/808e137cf41289e9e4f8a51cf702d614/1.PNG)


## 資料結構說明 ##

|資料夾|說明|
|:---:|:---|
|app|自動產生 Html 快取，主程式|
|public|min.js、min.css、img...etc|
|vendor|核心程式|
|resources|<ul><li>- assets: style、js、img 原始碼</li><li>- views: blade.php</li></ul>|


## require package ##

|套件名稱|作用|網址|
|:---:|:---:|:---|
|philo/laravel-blade|laravel blade|https://github.com/PhiloNL/Laravel-Blade|
|fzaninotto/faker|假資料|https://github.com/fzaninotto/Faker|


----

## 如何載入 style、js、img ##
```html
    <link href="{{ asset('styles/bootstrap.min.css') }}" rel="stylesheet">
    <script src="{{ asset('scripts/bootstrap.min.js') }}"></script>
    <img src="{{ asset('images/icon.png') }}" />
```

## 如何使用連結 ##
```html
    <a href="{{ url('/') }}">首頁</a>
```

Ajax

```javascript
    $.get('{{ url('/test') }}', {}, function(data){
        console.log(data);
    });
```