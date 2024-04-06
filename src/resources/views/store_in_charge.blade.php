@extends('layouts.app_representative')

@section('css')
<link rel="stylesheet" href="{{ asset('css/restaurant-list.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- <script>
    $(document).ready(function(){
        $('#search-form select, #restaurant_name').on('change keyup', function(){
            $('#search-form').submit();
        });
    });
</script> -->
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
<style>
.store-in-charge__title {
    text-align:center;
    font-size:24px;
    font-weight:bold;
    margin:0 0 2% 0;
}
.store-charge__btn{
    text-align:right;
    margin:0 7% 2% 0;
}
.store-charge__btn-submit{
    display: inline-block;
    background-color: rgb(22, 70, 243);
    border: none;
    border-radius: 5px;
    color: #fff;
    font-size: 14px;
    cursor: pointer;
    height: 40px;
    width: 80px;
    padding: 9px 10px 0 0;
    text-decoration: none;

}

</style>
@endsection

@section('content')
<!-- <div class="search-form">
    <form class="search-form__inner" action="{{ route('restaurant-search') }}" method="post" id="search-form">
        @csrf
        <div class="search-form__area-name">
            <select class="area-name__select" name="area" id="area_id">
                <option class="area-name__select-item" value="">All area</option>
                @foreach ($areas as $area)
                <option value="{{ $area->id }}"@if(session('selected_area') == $area->id) selected @endif>{{ $area->area_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="search-form__genre-name">
            <select class="genre-name__select" name="genre" id="genre_id">
                <option class="genre-name__select-item" value="">All genre</option>
                @foreach ($genres as $genre)
                <option value="{{ $genre->id }}"@if(session('selected_genre') == $genre->id) selected @endif>{{ $genre->genre_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="search-form__restaurant-name">
            <i class="fa-solid fa-magnifying-glass search-icon" width="30px" height=""30px></i>
            <input class="restaurant-name__item" type="text" name="restaurant_name" id="search_input" placeholder="Search...">
        </div>
    </form> -->
    
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
            <a class="restaurant-detail__btn" href="{{ route('restaurant-detail', ['id' => $restaurant->id]) }}">編集</a>
            <!-- <i class="fa-solid fa-heart fa-xl favorite-btn" data-restaurant-id="{{ $restaurant->id }}" id="favoriteButton"></i> -->
            <button class="favorite-btn" data-restaurant-id="{{ $restaurant->id }}" style="color:{{ $restaurant->isFavorite(auth()->id()) ? 'red' : 'rgb(216, 216, 216)' }}">予約一覧</button>
        </div>
    </div>
@endforeach
</div>

@endsection
