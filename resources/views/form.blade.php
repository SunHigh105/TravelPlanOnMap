@extends('layout')

@section('content')
<div id="app" v-cloak>
    @if(Auth::user())
    <app-component login_id="{{ Auth::user()->id }}"></app-component>
    @else
    <app-component login_id=""></app-component>
    @endif
</div>
@endsection