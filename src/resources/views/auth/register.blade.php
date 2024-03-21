@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
<div class="register-form">
    <p class="register-form__head-title">Register</p>
    <div class="register-form__inner">
        <form class="register-form__form" action="/register" method="post">
            @csrf
            <div class="register-form__group">
                <img src="/Users/hasegawatakanori/coachtech/laravel/reservation-system/src/resources/views/auth/img/user.png" alt="user-icon">
                <input class="register-form__input" type="text" name="name" id="name" placeholder="Username" value="{{ old('name') }}">
                <p class="register-form__error-message">
                    @error('name')
                    {{ $message }}
                    @enderror
                </p>
            </div>
            <div class="register-form__group">
                <img src="src/resources/views/auth/img/email.png" alt="email-icon">
                <input class="register-form__input" type="email" name="email" id="email" placeholder="Email" value="{{ old('email') }}">
                <p class="register-form__error-message">
                    @error('email')
                    {{ $message }}
                    @enderror
                </p>
            </div>
            <div class="register-form__group">
                <img src="img/password.png" alt="password-icon">
                <input class="register-form__input" type="password" name="password" id="Password" placeholder="パスワード">
                <p class="register-form__error-message">
                    @error('password')
                    {{ $message }}
                    @enderror
                </p>
            </div>
            <!-- <div class="register-form__group">
                <input class="register-form__input" type="password" name="password-confirm" id="password-confirm" placeholder="確認用パスワード">
                <p class="register-form__error-message">
                    @error('password')
                    {{ $message }}
                    @enderror
                </p>
            </div> -->
            <input class="register-form__btn" type="submit" value="会員登録">
        </form>
        <!-- <div class="login-transition__form">
            <p class="login-nav">アカウントをお持ちの方はこちらから</p>
            <a class="login-transition__btn" href="/login">ログイン</a>
        </div> -->
    </div>
</div>
@endsection