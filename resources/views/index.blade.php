@extends('_layouts.template')
@section('title', 'index')
@section('content')
    @auth
    hello
    @endauth

    <x-alert type="error" message="msg"></x-alert>
@endsection