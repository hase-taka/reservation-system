@extends('layouts.app_representative')

@section('css')
<link rel="stylesheet" href="{{ asset('css/store_in_charge.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
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
@endsection

@section('content')
</div>
<div class="store-in-charge__title">
    <p>担当店舗一覧</p>
</div>
<div class="store-charge__btn">
    <a  class="store-charge__btn-submit" href="/restaurant/addition" method="get">店舗追加</a>
</div>

<div class="restaurant-list-card__wrap">
@foreach($restaurants as $restaurant)
    <div class="restaurant-list-card">
        <div class="restaurant-list-card__img">
            @if($restaurant->img_url)
                <img src="{{ $restaurant->img_url }}" alt="店舗画像">
            @elseif($restaurant->file_path)
                <img src="{{ asset($restaurant->file_path) }}" alt="Restaurant Image">
            @else
                <img src="images/no_image.jpeg" alt="No Image">
            @endif
        </div>
        <div class="restaurant-list-card__content">
            <p class="restaurant-list-card__content-name">{{ $restaurant->name }}</p>
        </div>
        <div class="restaurant-list-card__content-tag">
            <p class="restaurant-list-card__content-tag-item">#{{ $restaurant->area->area_name }}</p>
            <p class="restaurant-list-card__content-tag-item">#{{ $restaurant->genre->genre_name }}</p>
        </div>
        <div class="restaurant-list-card__content-btn">
            <a class="restaurant-edit__btn" href="{{ route('restaurant_edit', ['id' => $restaurant->id]) }}">編集</a>
            <a class="reservation-list__btn" href="{{ route('restaurant_reservation_list', ['id' => $restaurant->id]) }}">予約一覧</a>
        </div>
    </div>
@endforeach
</div>

@endsection
