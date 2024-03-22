@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/done.css') }}">
@endsection

@section('content')
<div class="done-message__wrap">
    <div class="done-message">
        <p class="done-message__inner">ご予約ありがとうございます</p>
    </div>
    <div class="home__transition-btn">
        <a class="home__transition-btn-submit" href="/login">戻る</a>
    </div>
</div>
@endsection