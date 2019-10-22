@extends('layout')
@section('content')
<div id="app">
    <div class="grid-container">
        <h3>Mypage</h3>
        <div class="grid-x grid-margin-x">
            <div class="cell medium-3">
                <ul class="vertical tabs" data-tabs id="example-tabs">
                    <li class="tabs-title is-active"><a href="#panel1v" aria-selected="true">登録済みプラン</a></li>
                    <li class="tabs-title"><a href="#panel2v">アカウント設定</a></li>
                </ul>
            </div>
            <div class="cell medium-9">
                <div class="tabs-content" data-tabs-content="example-tabs">
                    <div class="tabs-panel is-active" id="panel1v">
                        @if(Auth::user())
                        <registerdplans-component login_id="{{ Auth::user()->id }}"></registerdplans-component>
                        @endif
                    </div>
                    <div class="tabs-panel" id="panel2v">
                        @if(Auth::user())
                        <setting-component login_id="{{ Auth::user()->id }}"></setting-component>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection