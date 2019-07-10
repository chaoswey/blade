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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
@include('_partials.header')

<div class="container-fluid">
    <div class="row">
        <div class="col-2">
            @section('sidebar')
                <ul class="list-group">
                    <li class="list-group-item">Text only</li>
                    <a href="#" class="list-group-item">Link item</a>
                    <button type="button" class="list-group-item">Button item</button>
                    <a href="#" class="list-group-item active">Active link item</a>
                    <a href="#" class="list-group-item disabled">Disabled item</a>
                </ul>
            @show
        </div>
        <div class="col">
            @yield('content')
        </div>
    </div>
</div>
@include('_partials.footer')
@include('_partials.scripts')
@yield('scripts')
</body>
</html>