@extends('layouts.app-2')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css')}}">
<style>
.login-form__error-message{
  color:rgb(22, 70, 243);
}
</style>
@endsection

@section('content')
<div class="login-form">
    <p class="login-form__head-title">Login</p>
    <div class="login-form__inner">
        <form class="login-form__form" action="/login" method="post">
        @csrf
            <div class="login-form__group">
                <img src="images/user.png" alt="user-icon" width="25px" height="25px">
                <input class="login-form__input" type="mail" name="email" id="email" placeholder="メールアドレス" >
                <div class="login-form__error-message">
                    @error('email')
                    {{ $message }}
                    @enderror
                </div>
            </div>
            <div class="login-form__group">
                <img src="images/password.png" alt="password-icon" width="25px" height="25px">
                <input class="login-form__input" type="password" name="password" id="password" placeholder="パスワード">
                <div class="login-form__error-message">
                    @error('password')
                    {{ $message }}
                    @enderror
                </div>
            </div>
            <div  class="login-form__btn">
            <input class="login-form__btn-submit" type="submit" value="ログイン">
            </div>
        </form>
    </div>
</div>

@endsection