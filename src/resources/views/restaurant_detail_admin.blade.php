@extends('layouts.app_admin')

@section('css')
<link rel="stylesheet" href="{{ asset('css/restaurant-detail.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection

@section('content')
<div class="restaurant__detail-reservation">
    <div class="restaurant-detail">
        <div class="restaurant-detail__header">
            <div class="return-page__btn">
                <a class="return-page__btn-submit" href="/"><</a>
            </div>
            <div class="restaurant-detail-name">
                <h2 class="restaurant-detail-name__inner">{{ $restaurant->name }}</h2>
            </div>
        </div>
        <div class="restaurant-detail-img">
            <img src="{{ $restaurant->img_url}}" alt="店舗画像">
        </div>
        <div class="restaurant__tag">
            <p class="restaurant-tag-item">#{{ $restaurant->area->area_name }}</p>
            <p class="restaurant-tag-item">#{{ $restaurant->genre->genre_name }}</p>
        </div>
        <div class="restaurant__content">
            <p class="restaurant__content-inner">{{ $restaurant->content }}</p>
        </div>
    </div>
    <div class="reservation-form">
        <p class="reservation-form__title">予約</p>
        <form class="reservation-form__inner" action="/reservation" method="post" id="reservationForm">
            @csrf
            <div clasS="reservation-form__item">
                <input type="hidden" name="restaurant_id" value="{{ $restaurant->id }}">
                <input class="reservation-form__item-input-date" type="date" id="dateInput"  name="date" placeholder="Enter date" >
                @if ($errors->has('date'))
                <div class="error-message">
                    <tr>
                        <td >
                            {{$errors->first('date')}}
                        </td>
                    </tr>
                </div>
                @endif   
                <input class="reservation-form__item-input"  type="time" id="timeInput" name="time"  placeholder="Enter time" step="600">
                @if ($errors->has('time'))
                <div class="error-message">
                    <tr>
                        <td >
                            {{$errors->first('time')}}
                        </td>
                    </tr>
                </div>
                @endif   
                <input class="reservation-form__item-input"  type="number" id="partySizeInput" name ="number" min="1" placeholder="人数" oninput="displayInput()">
                @if ($errors->has('number'))
                <div class="error-message">
                    <tr class="error-message">
                        <td>
                            {{$errors->first('number')}}
                        </td>
                    </tr>
                </div>
                @endif   
            </div>
            <div class="reservation-confirm">
                <div class="reservation-confirm__inner" id="displayArea"></div>
            </div>
            <div class="reservation-btn">
            <button class="reservation-btn__submit" type="submit">予約する</button>
        </div>
        </form>
            <script>
        // ページ読み込み時に確認情報を表示する関数
        $(document).ready(function() {
            // 各入力フィールドの初期値を取得
            var date = $('#dateInput').val();
            var time = $('#timeInput').val();
            var partySize = $('#partySizeInput').val();

            // 取得した初期情報を表示する
            var 
            confirmationHTML = '<div class="confirm-container"><p class="confirm-h">Shop</p>   <p class="confirm-d"> {{ $restaurant->name }}</p></div>';
            confirmationHTML += '<div class="confirm-container"><p class="confirm-h">Date</p><p class="confirm-d">'    + date + '</p></div>';
            confirmationHTML += '<div class="confirm-container"><p class="confirm-h">Time</p><p class="confirm-d">'    + time + '</p></div>';
            confirmationHTML += '<div class="confirm-container"><p class="confirm-h">Number</p><p class="confirm-d-n">'  + partySize + '</p></div>';

            $('#displayArea').html(confirmationHTML);
        });
        </script>
            <script>
            // 入力データを表示する関数
            function displayInput() {
                var dateValue = $('#dateInput').val();
                var timeValue = $('#timeInput').val();
                var partySizeValue = $('#partySizeInput').val();

                var displayText = '<div class="confirm-container"><p class="confirm-h">Shop</p>   <p class="confirm-d"> {{ $restaurant->name }}</p></div>';
                displayText += '<div class="confirm-container"><p class="confirm-h">Date</p><p class="confirm-d">'    + dateValue + '</p></div>';
                displayText += '<div class="confirm-container"><p class="confirm-h">Time</p><p class="confirm-d">'    + timeValue + '</p></div>';
                displayText += '<div class="confirm-container"><p class="confirm-h">Number</p><p class="confirm-d-n">'  + partySizeValue + '</p></div>';

                $('#displayArea').html(displayText);
            }

            // 各入力フィールドの input イベントで displayInput 関数を呼び出す
            $(document).ready(function(){
                $('#dateInput, #timeInput, #partySizeInput').on('input', displayInput);
            });
        </script>
    </div>
</div>
@endsection
