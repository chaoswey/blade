<!doctype html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <title>@yield('title') - template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="cache-control" content="max-age=0" />
    <meta http-equiv="cache-control" content="no-cache" />
    <meta http-equiv="pragma" content="no-cache" />
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
@include('_partials.header')
@yield('content')
@include('_partials.footer')
@include('_partials.scripts')
@yield('scripts')
</body>
</html>