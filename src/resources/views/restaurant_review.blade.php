@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/restaurant_review.css') }}">


@endsection

@section('content')
<div class="restaurant-addition__title">
    <h2 class="restaurant-addition__title-inner">レビュー</h2>
</div>
<div class="restaurant-addition__form">
    <form class="restaurant-addition__form-inner" action="/restaurant/review" method="post" >
    @csrf
        <div class="addition-form__table">
            <table class="addition-form__table-inner">
                <tr class="table-row">
                    <th class="table-head">店名</th>
                    <td class="table-data">
                        <p class="restaurant-name">{{ $reservation->restaurant->name }}</p>
                        <input type="hidden" name="restaurant_id" value="{{ $reservation->restaurant_id }}">
                        <input type="hidden" name="reservation_id" value="{{ $reservation->id }}">
                    </td>
                </tr>
                <tr class="table-row">
                    <th class="table-head">名前orニックネーム</th>
                    <td class="table-data">
                        <input  class="nickname" type="text" name="nickname" placeholder="名前またはニックネーム">
                        <!-- <input type="hidden" name="user_id" value="{{ $reservation->user_id }}"> -->
                    </td>
                </tr>
                <tr>
                    <td class="nickname-alert" colspan="2">
                        ※未入力の場合はユーザーネームでの投稿となります。
                    </td>
                </tr>
                
                <tr class="table-row">
                    <th class="table-head">評価</th>
                    <td class="table-data rate-form">
                        <input id="star5" type="radio" name="rating" value="5">
                        <label for="star5">★</label>
                        <input id="star4" type="radio" name="rating" value="4">
                        <label for="star4">★</label>
                        <input id="star3" type="radio" name="rating" value="3">
                        <label for="star3">★</label>
                        <input id="star2" type="radio" name="rating" value="2">
                        <label for="star2">★</label>
                        <input id="star1" type="radio" name="rating" value="1">
                        <label for="star1">★</label>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <p class="register-form__error-message">
                            @error('rating')
                            {{ $message }}
                            @enderror
                        </p>
                    </td>
                </tr>
                <tr class="table-row">
                    <th class="table-head__content">コメント</th>
                    <td class="table-data__content">
                        <textarea name="comment" class="restaurant-comment__inner"  id="" cols="30" rows="5" placeholder="接客・店内・料理などのコメントをお願いします"></textarea>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                    @if ($errors->has('already_posted'))
                        <div class="register-form__error-message">{{ $errors->first('already_posted') }}</div>
                    @endif
                    </td>
                </tr>
                
            </table>
        </div>
        <div class="restaurant-review__form-button">
            <button class="restaurant-review__form-button-submit" type="submit">送信</button>
        </div>
    </form>
</div>

@endsection