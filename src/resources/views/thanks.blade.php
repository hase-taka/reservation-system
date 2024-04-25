@extends('layouts.app-2')

@section('css')
<link rel="stylesheet" href="{{ asset('css/thanks.css') }}">
@endsection

@section('content')
<div class="thanks-message__wrap">
    <div class="thanks-message">
        <p class="thanks-message__inner">会員登録ありがとうございます</p>
    </div>
    <div class="mail-send__message">
        <p class="mail-send__message-inner">登録されたメールアドレス宛に確認メールを送信しました。ログインに進む前にメールを確認し、リンクをクリックしてください。</p>
    </div>
    <div class="login-form__transition-btn">
        <a class="login-form__transition-btn-submit" href="/login">ログインする</a>
    </div>
</div>
@endsection