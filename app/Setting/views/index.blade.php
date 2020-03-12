<!doctype html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>export</title>
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-material-design@4.1.1/dist/css/bootstrap-material-design.min.css" integrity="sha384-wXznGJNEXNG1NFsbm0ugrLFMQPWswR3lds2VeinahP8N0zJw9VWSopbjv2x7WCvX" crossorigin="anonymous">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="javascript:;">Weya</a>
</nav>
<div class="container pt-4">
    <h1>Blade 匯出 Html 介面</h1>
    <form method="post">
        <div class="form-group">
            <label for="dir">匯出資料夾:</label>
            <input type="text" class="form-control" name="dir" id="dir" aria-describedby="dir-help" placeholder="D:\www\ 或者 /var/www/html">
            <small id="dir-help" class="form-text text-muted">要匯出的目標資料夾,如果是空將在此專案下面增加一個`_html`資料夾</small>
        </div>
        <div class="form-group">
            <label for="url">新網址:</label>
            <input type="text" class="form-control" name="url" id="url" aria-describedby="url-help" placeholder="http://www.example.com">
            <small id="url-help" class="form-text text-muted">匯出時會 url , asset 前綴 絕對網址替換</small>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="clear" value="1" id="clear">
            <label class="form-check-label" for="clear">清除目標資料夾</label>
        </div>
        <button type="submit" class="btn btn-raised btn-primary">匯出</button>
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://unpkg.com/popper.js@1.12.6/dist/umd/popper.js" integrity="sha384-fA23ZRQ3G/J53mElWqVJEGJzU0sTs+SvzG8fXVWP+kJQ1lwFAOkcUOysnlKJC33U" crossorigin="anonymous"></script>
<script src="https://unpkg.com/bootstrap-material-design@4.1.1/dist/js/bootstrap-material-design.js" integrity="sha384-CauSuKpEqAFajSpkdjv3z9t8E7RlpJ1UP0lKM/+NdtSarroVKu069AlsRPKkFBz9" crossorigin="anonymous"></script>
<script>
    $(document).ready(function () {
        $('body').bootstrapMaterialDesign();
    });
</script>
</body>
</html>