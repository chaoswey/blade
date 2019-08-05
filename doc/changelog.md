## 更新說明 ##

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