@extends('layouts.app-2')

@section('css')
<link rel="stylesheet" href="{{ asset('css/thanks.css') }}">
@endsection

@section('content')
<div class="thanks-message__wrap">
    <div class="thanks-message">
        <p class="thanks-message__inner">会員登録ありがとうございます</p>
    </div>
    <div class="login-form__transition-btn">
        <a class="login-form__transition-btn-submit" href="/login">ログインする</a>
    </div>
</div>
@endsection