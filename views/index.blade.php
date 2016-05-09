@extends('_layouts.template')
@section('title', 'index')
@section('sidebar')
    @parent

    <p>這邊會附加在主要的側邊欄。</p>
@endsection
@section('content')
    <div class="container-fluid">
        <h3>Index</h3>
        <div class="row">
            <div class="col-md-8">.col-md-8</div>
            <div class="col-md-4">.col-md-4</div>
        </div>
        <h3>ajax</h3>
        <div class="row">
            <a href="javascript:;" id="ajax">click</a>
            <div class="col-md-12" id="show"></div>
        </div>
        <ul>
            @for($i = 0; $i <= 10; $i++)
                <li>第 {{ $i }} 個</li>
            @endfor

            {!! '<h1>hello</h1>' !!}
        </ul>
    </div>
@endsection

@section('scripts')
    <script>
        $('#ajax').click(function(){
            $.get('{{ url('/ajax') }}', {}, function(data){
                $('#show').append(data);
            });
        });
    </script>
@endsection