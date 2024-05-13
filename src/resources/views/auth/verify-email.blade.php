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
    </div>
</div>
@endsection
