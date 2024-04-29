@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/create_email.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

@endsection

@section('content')
<div class="mail-edit__form">
    <div class="mail-edit__form-title">
        <h2>メール作成</h2>
    </div>
    <form class="mail-edit__form-inner" action="{{ route('send.email') }}" method="POST">
        @csrf

        <div class="edit-form__item-subject">
            <label for="subject">件名:</label>
            <input class="subject-input" type="text" name="subject" id="subject">
        </div>
        <div class="edit-form__item-content">
            <label class="content-label" for="content">内容:</label>
            <textarea class="content-input" name="content" id="content" cols="30" rows="10"></textarea>
        </div>
        <button class="edit-form__button" type="submit">送信</button>
        @if (session('success'))
            <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
    </form>
</div>


@endsection
