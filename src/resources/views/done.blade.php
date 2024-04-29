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
        @if($course_price)
        <a class="payment-btn-submit" href="{{ route('payment.create', ['price' => $course_price,'number' => $number,'user_id' => $user_id,'restaurant_id' => $restaurant_id]) }}">カード決済</a>
        @endif
    </div>
</div>
@endsection