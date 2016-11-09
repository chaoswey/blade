<!doctype html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <title>@yield('title') - template</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="cache-control" content="max-age=0" />
    <meta http-equiv="cache-control" content="no-cache" />
    <meta http-equiv="pragma" content="no-cache" />
    <link href="{{ asset('styles/bootstrap.min.css') }}" rel="stylesheet">
</head>
<body>
@include('_partials.header')
@section('sidebar')
    這是主要的側邊欄。
@show
@yield('content')
@include('_partials.footer')
@include('_partials.scripts')
@yield('scripts')
</body>
</html>