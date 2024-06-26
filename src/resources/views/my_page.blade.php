@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/my_page.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.favorite-btn').click(function() {
                $(this).toggleClass('clicked');
            });
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function(){
        $('.favorite-btn').click(function(){
            var restaurantId = $(this).data('restaurant-id');
            var button = $(this);
            
            $.ajax({
                url: '/favorites/toggle/' + restaurantId,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                },
                success: function(response){
                    if(response.status == 'added') {
                        button.css('color', 'red');
                    } else if(response.status == 'removed') {
                        button.css('color', 'rgb(216, 216, 216)');
                    }
                }
            });
        });
    });
</script>
<script>
$(document).ready(function() {
    // 予約の変更フォームが送信されたときの処理
    $('#editReservationForm').submit(function(event) {
        event.preventDefault();

        var reservationId = $('#reservationId').val();
        var date = $('#date').val();
        var time = $('#time').val();
        var number = $('#number').val();

        $.ajax({
            url: '/reservation/' + reservationId,
            type: 'PUT',
            data: {
                _token: '{{ csrf_token() }}',
                date: date,
                time: time,
                number: number
            },
            success: function(response) {
                // 予約の変更が成功した場合、モーダルウィンドウを閉じる
                $('#reservationModal').modal('hide');
                // 成功メッセージなどを表示する場合はここに追加
                // Mypageビューの予約状況を更新するためにページを再読み込みするなどの処理を行う
                location.reload();
            },
            error: function(xhr) {
                // エラーメッセージなどを表示する場合はここに追加
                console.log(xhr.responseText);
            }
        });
    });

    // 予約のキャンセルボタンがクリックされたときの処理
    $('.cancel-reservation').click(function() {
        var reservationId = $(this).data('reservation-id');

        if (confirm("本当に予約をキャンセルしますか？")) {
            $.ajax({
                url: '/reservation/' + reservationId,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}',
                },
                success: function(response) {
                    // 予約の削除が成功した場合、Mypageを再読み込みする
                    location.reload();
                },
                error: function(xhr) {
                    // エラーメッセージなどを表示する場合はここに追加
                    console.log(xhr.responseText);
                }
            });
        }
    });
});
</script>

@endsection

@section('content')
<div class="my-page_head">
    <h2 class="my-page_user-name">{{$user->name}}さん</h2>
</div>
<div class="my-page__wrap">
    <div class="my-page__inner-reservation">
        <p class="my-page__reservation-status">予約状況</p>
        <div class="reservation-status__wrap">
        @if ($user->reservations->count() > 0)
        @foreach($user->reservations as $index => $reservation)
            <div class="reservation-status__inner">
                <div class="reservation-table__header">
                    <div class="reservation-number">
                        <img class="clock-img" src="images/clock2.png" alt="clock-icon" width="25px" height="25px">
                        <p class="reservation-number__inner">予約 {{ $index + 1 }}</p>
                    </div>
                    <div class="reservation__cancel-btn">
                        <button class="btn btn-danger cancel-reservation" data-reservation-id="{{ $reservation->id }}"><img src="images/cancel.png" alt="cancel-icon" width="25px" height="25px"></button>
                    </div>
                </div>
                <div class="reservation-table">
                    <table class="reservation-table__inner">
                        <tr class="reservation-table__row">
                            <th class="reservation-table__head">Shop</th>
                            <td class="reservation-table__data">{{ $reservation->restaurant->name }}</td>
                        </tr>
                        <tr class="reservation-table__row">
                            <th class="reservation-table__head">Date</th>
                            <td class="reservation-table__data">{{ $reservation->date }}</td>
                        </tr>
                        <tr class="reservation-table__row">
                            <th class="reservation-table__head">Time</th>
                            <td class="reservation-table__data">{{ date('H:i', strtotime($reservation->time)) }}</td>
                        </tr>
                        <tr class="reservation-table__row">
                            <th class="reservation-table__head">Number</th>
                            <td class="reservation-table__data">{{ $reservation->number }}</td>
                        </tr>
                        @if($reservation->course_name)
                        <tr class="reservation-table__row">
                            <td class="reservation-table__head">Course</td>
                            <td class="reservation-table__data">{{ $reservation->course_name }}</td>
                        </tr>
                        @endif
                        @if($reservation->paid == 1)
                        <tr class="reservation-table__row">
                            <td class="reservation-table__head">Paid</td>
                            <td class="reservation-table__data">カード決済済み</td>
                        </tr>
                        @endif
                    </table>
                </div>
                <div class="reservation__some-btn">
                    <div class="reservation__qr-btn">
                        <a class="reservation__qr-btn-submit" href="{{ route('qr_create', ['reservation_id' => $reservation->id,'date' => $reservation->date,'time' => date('H:i', strtotime($reservation->time)),'restaurant_id' => $reservation->restaurant_id,'user_id' => $user->id,'number' => $reservation->number,'paid' => $reservation->paid,'course' => $reservation->course_name]) }}">QRコード作成</a>
                    </div>
                    @php
                        $reservationDateTime = $reservation->date . ' ' . $reservation->time;
                    @endphp
                    @if($now > $reservationDateTime)
                    <div class="restaurant__review-btn">
                        <a href="{{ route('restaurant_review',[ 'id' => $reservation->id]) }}">レビュー</a>
                    </div>
                    @endif
                    @if($now < $reservationDateTime)
                        @if($reservation->paid == 0)
                        <div class="reservation__modification-btn">
                            <a href="{{ route('reservation.edit', $reservation->id) }}">予約変更</a>
                        </div>
                        @else
                        <div class="reservation__modification-paid"><p class="paid-message">決済済みのためMypageからの予約変更不可</p></div>
                        @endif
                    @endif
                </div>
            </div>
        @endforeach
        @else
                <p>現在、予約がありません。</p>
        @endif
        </div>
    </div>

    <div class="my-page__inner-restaurant">
        <p class="my-page__favorite-restaurants">お気に入り店舗</p>
        @if ($user->favorites->count() > 0)
        <div class="favorite-restaurants">
            <div class="restaurant-list-card__wrap">
            @foreach($user->favorites as $favorite)
                <div class="restaurant-list-card">
                    <div class="restaurant-list-card__img">
                        @if($favorite->restaurant->img_url)
                            <img src="{{ $favorite->restaurant->img_url }}" alt="店舗画像">
                        @elseif($favorite->restaurant->file_path)
                            <img src="{{ asset($favorite->restaurant->file_path) }}" alt="Restaurant Image">
                        @else
                            <img src="images/no_image.jpeg" alt="No Image">
                        @endif
                    </div>
                    <div class="restaurant-list-card__content">
                        <p class="restaurant-list-card__content-name">{{ $favorite->restaurant->name }}</p>
                    </div>
                    <div class="restaurant-list-card__content-tag">
                        <p class="restaurant-list-card__content-tag-item">#{{ $favorite->restaurant->area->area_name }}</p>
                        <p class="restaurant-list-card__content-tag-item">#{{ $favorite->restaurant->genre->genre_name }}</p>
                    </div>
                    <div class="restaurant-list-card__content-btn">
                        <a class="restaurant-detail__btn" href="{{ route('restaurant-detail', ['id' => $favorite->restaurant->id]) }}">詳しくみる</a>
                        <button class="favorite-btn" data-restaurant-id="{{ $favorite->restaurant->id }}" style="color:{{ $favorite->restaurant->isFavorite(auth()->id()) ? 'red' : 'rgb(216, 216, 216)' }}">
                    <i class="fa fa-heart fa-xl "></i>
                </button>
                    </div>
                </div>
            @endforeach
            </div>
        </div>
        @else
        <p>お気に入りのレストランがありません。</p>
        @endif
    </div>
</div>
@endsection
