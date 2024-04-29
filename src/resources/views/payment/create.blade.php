@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css')}}">
<style>
.login-form__error-message{
  color:rgb(22, 70, 243);
}
</style>
@endsection

@section('content')
<div class="content">
    <form id="payment-form" action="{{ asset('charge') }}" method="POST">
        {{ csrf_field() }}

        <!-- 金額入力フォーム -->
        <label for="amount">金額（JPY）:</label>
        <input type="number" id="amount" name="amount" min="1" step="1" value="{{ $number * $price }}" readonly>
        <input type="hidden" name="paid" value="1">
        <input type="hidden" name="id" value="{{$reservation_id}}">

        <!-- Stripe支払いボタン -->
        <script
            src="https://checkout.stripe.com/checkout.js" class="stripe-button"
            data-key="{{ env('STRIPE_KEY') }}"
            data-amount="{{ $number * $price }}"
            data-name="Stripe Demo"
            data-label="決済をする"
            data-description="Online course about integrating Stripe"
            data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
            data-locale="auto"
            data-currency="JPY">
        </script>
    </form>
</div>

<script>
    // // 金額入力フォームの値が変更されたときに、支払いボタンの金額を更新する
    // document.getElementById('amount').addEventListener('input', function() {
    //     var amount = this.value; // 入力された金額を取得
    //     var stripeButton = document.querySelector('.stripe-button');

    //     // 支払いボタンのdata-amount属性に入力された金額をセット
    //     stripeButton.setAttribute('data-amount', 'amount');
    // });

     // 金額入力フォームの値が変更されたときに、支払いボタンの金額を更新する
    document.getElementById('amount').addEventListener('input', function() {
        var amount = this.value; // 入力された金額を取得
        var stripeButton = document.querySelector('.stripe-button');

        // 入力された金額をセント（cent）単位に変換
        var amountInCents = amount;

        // 支払いボタンのdata-amount属性に入力された金額をセット（セント単位で指定）
        stripeButton.setAttribute('data-amount', amountInCents.toString());
    });
</script>


@endsection