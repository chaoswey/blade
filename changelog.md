## 更新說明 ##

* 4.3.0

  1. composer.json 改成專案

  2. config._components 改成陣列

  3. 加入 filp/whoops 捕捉錯誤

  4. 增加Provider系統
  
  5. 固定功能改成config 注入

  6. 更新PHP版本7.2|8.0以上
  
  7. 移除 cc 指令

* 4.2.0

    asset 使用外部資源
    
    如果 `webpack.mix.js` 有加入
    
    ```javascript
    if (mix.inProduction()) {
        mix.setPublicPath(path.resolve('./'));
        mix.version();
    }
    ```
    
    會自動 找尋 `mix-manifest.json` 內容更新版本號碼

* 4.0.0
    
    1. 重構APP
    
    2. 加入 slashtrace/slashtrace 增加錯誤收集
    
    3. 設定統一在 app/config.php
    
    4. 匯出系統 改成 app setting 功能
    
    5. 移除 jenssegers/blade
    
    6. 修改元件核心, _components 底下都可以轉用 <x-xxx>使用
    
    7. 增加模擬登入頁面

* 3.0.0
    
    1. 移除 CopyWebpackPlugin ImageminPlugin imageminMozjpeg
    
    2. 增加 symfony/http-foundation
    
    3. 重構 核心
    
    4. package.json
        
        1. 增加 autoprefixer
        
        2. 移除 沒在使用的套件
        
        3. fix: sourceMaps 可能沒生成的問題
        
        4. autoprefixer 增加檔案 .browserslistrc，browserslistrc 設定瀏覽器的版本
        
    5. 現在無法直接從網址讀取 _layouts  及 _partials 資料夾
    
    6. php cc b2html
    
        1. 增加功能 詢問是否清空目標 資料夾
        
        2. 增加功能 url and asset 轉換成絕對網址
        
    7. 增加功能 blade 轉 html 的網頁介面 網址是 /_export

* 2.1.0

    移除 沒用 doc
    
    增加 CopyWebpackPlugin ImageminPlugin imageminMozjpeg

* 2.0.0

    移除 假資料、假圖片
    
    增加 cc 指令集

* 1.3.3

    加入 debug、假資料、假圖片

* 1.3.2

    調整

* 1.3.1

    加入 request
    
    調整 url 物件

* 1.3.0

    重構主架構
   
    調整 路由
    
    提高安全性
    
    操作說明分離
    
    無法使用特殊字元的 URI

* 1.2.1

    移除 gulp 加入 laravel-mix

* 1.1.0

    加入 gulp 調整資料夾結構

* 1.0.5

    初版