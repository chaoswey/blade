@extends('_layouts.template')
@section('title', 'index')
@section('content')
    @auth
        login
    @endauth

    {{ $a }}
    @guest
        logout
    @endguest
    
    <x-alert type="error" message="msg"></x-alert>
@endsection