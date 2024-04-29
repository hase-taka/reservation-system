@extends('layouts.app-2')

@section('css')
<link rel="stylesheet" href="{{ asset('css/verify-email.css')}}">
<style>
.login-form__error-message{
  color:rgb(22, 70, 243);
}

.card-body{
    margin: 0 15px;
}

.mail-send__btn-submit{
    display: block;
    margin: 10px 7% 15px auto;
    background-color: rgb(58, 58, 247);
    color: #fff;
    border: none;
    border-radius: 5px;
    padding: 5px 15px;
    cursor: pointer;
}
</style>

<link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

@endsection

@section('content')
<div class="verify-email">
    <p class="login-form__head-title">VerifyEmail</p>
    <div class="login-form__inner">
        <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        @if (session('resent'))
                            <div class="alert alert-success" role="alert">
                                {{ __('あなたのEメールアドレスに新しい認証リンクが送信されました。') }}
                            </div>
                        @endif
                        <div>
                        {{ __('ログインの前にあなたのアドレス宛に送られたメールの認証リンクをクリックしてください。') }}</div>
                        <div>
                        {{ __('メールが届いていない場合は下記ボタンをクッリクしてください。') }}</div>
                        <form class="d-inline" method="POST" action="{{ route('verification.send') }}">
                            @csrf
                            <div class="mail-send__btn">
                                <button type="submit" class="mail-send__btn-submit">{{ __('もう一度確認メールを送る') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- <form class="login-form__form" action="/login" method="post">
    @csrf
        <div class="login-form__group">
            <img src="/images/user.png" alt="user-icon" width="25px" height="25px">
            <input class="login-form__input" type="mail" name="email" id="email" placeholder="メールアドレス" >
            <div class="login-form__error-message">
                @error('email')
                {{ $message }}
                @enderror -->

                <!-- @if ($errors->has('email'))
                <span class="invalid-feedback" role="alert">
                {{ $errors->first('email') }}
                </span>
            @endif -->

            <!-- </div>
        </div>
        <div class="login-form__group">
            <img src="/images/password.png" alt="password-icon" width="25px" height="25px">
            <input class="login-form__input" type="password" name="password" id="password" placeholder="パスワード">
            <div class="login-form__error-message">
                @error('password')
                {{ $message }}
                @enderror -->

                <!-- @if ($errors->has('error'))
                <span class="invalid-feedback" role="alert">
                {{ $errors->first('error') }}
                </span>
            @endif -->

            <!-- </div>
        </div>
        <div  class="login-form__btn">
        <input class="login-form__btn-submit" type="submit" value="ログイン">
        </div>
    </form> -->
    
        <!-- <div class="register-transition__form">
            <p class="register-nav">アカウントをお持ちでない方はこちらから</p>
            <a class="register-transition__btn" href="/register">会員登録</a>
        </div> -->
    </div>
</div>
@endsection





<!-- <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    Fonts
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    Styles
    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Verify Your Email Address') }}</div>

                    <div class="card-body">
                        @if (session('resent'))
                            <div class="alert alert-success" role="alert">
                                {{ __('あなたのEメールアドレスに新しい認証リンクが送信されました。') }}
                            </div>
                        @endif

                        {{ __('ログインの前にメールを認証リンクを確認してください。') }}
                        {{ __('メールが届いていない場合は下記ボタンをクッリクしてください。') }},
                        <form class="d-inline" method="POST" action="{{ route('verification.send') }}">
                            @csrf
                            <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('もう一度確認メールを送る') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html> -->