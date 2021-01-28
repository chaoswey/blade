@extends('_layouts.template')
@section('title', 'index')
@section('content')
    @auth
        login
    @endauth
    @guest
        logout
    @endguest
    <img src="{{ imageHelper('images/test/130548394_2183438528456592_8175381885706033601_n.jpg', null, null, 50) }}" alt="">
    <x-alert type="error" message="msg"></x-alert>
@endsection