@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/reservation_edit.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

@endsection

@section('content')
<div class="mail-edit__form">
    <form class="mail-edit__form-inner" action="{{ route('send.email') }}" method="POST">
        @csrf
        <div class="edit-form__item">
            <label for="subject">件名:</label>
            <input type="text" name="subject" id="subject">
        </div>
        <div class="edit-form__item">
            <label for="content">内容:</label>
            <textarea name="content" id="content" cols="30" rows="10"></textarea>
        </div>
        <button class="edit-form__button" type="submit">送信</button>
    </form>
</div>
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@endsection
