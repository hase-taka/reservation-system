@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/qr_create.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
 

@endsection

@section('content')
<div class="return-page__btn">
    <a class="return-page__btn-submit" href="{{route('my_page')}}"><</a>
    <!-- url()->previous() -->
</div>
<div class="qr-code__wrap">
    <div class="qr-code__title">
        <p class="qr-code__title-inner">スタッフにこちらのQRコードを見せてください</p>
    </div>
    <div class="qr-code">
        {!! $qrCode !!}
    </div>
</div>
@endsection
