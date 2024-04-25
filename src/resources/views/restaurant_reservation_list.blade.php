@extends('layouts.app_representative')

@section('css')
<link rel="stylesheet" href="{{ asset('css/restaurant_reservation_list.css') }}">
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
    <h2 class="my-page_user-name">{{$restaurant->name}}</h2>
</div>

        
        <p class="my-page__reservation-status">予約一覧</p>
        <div class="reservation-list">
        @if ($reservations->count() > 0)
        @foreach($reservations as $index => $reservation)
        
            <div class="reservation-status__inner">
                <div class="reservation-table__header">
                    <div class="reservation-number">
                        <img class="clock-img" src="/images/clock2.png" alt="clock-icon" width="25px" height="25px">
                        <p class="reservation-number__inner">予約 {{ $loop->iteration }}</p>
                    </div>
                    <div class="reservation__cancel-btn">
                        <button class="btn btn-danger cancel-reservation" data-reservation-id="{{ $reservation->id }}"><img src="/images/cancel.png" alt="cancel-icon" width="25px" height="25px"></button>
                        <!-- <button class="reservation__cancel-btn__submit"><img src="img/cancel.png" alt="cancel-icon" width="25px" height="25px"></button> -->
                    </div>
                </div>
                <div class="reservation-table">
                    <table class="reservation-table__inner">
                        <tr class="reservation-table__row">
                            <th class="reservation-table__head">Name</th>
                            <td class="reservation-table__data">{{ $reservation->user->name }}</td>
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
                    </table>
                </div>
                
            </div>
            
        @endforeach
        </div>
        @else
                <p>現在、予約がありません。</p>
        @endif
    
@endsection
