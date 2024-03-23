@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/restaurant-list.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#favoriteButton').click(function() {
                $(this).toggleClass('clicked');
            });
        });
    </script>
@endsection

@section('content')
<div class="search-form">
    <form class="search-form__inner" action="" >
        <div class="search-form__area-name">
            <select class="area-name__select" name="area" id="">
                <option class="area-name__select-item" value="">All area</option>
                <option class="area-name__select-item" value="1">東京</option>
                <option class="area-name__select-item" value="2">大阪府</option>
                <option class="area-name__select-item" value="3">福岡県
                </option>
            </select>
        </div>
        <div class="search-form__genre-name">
            <select class="genre-name__select" name="genre" id="">
                <option class="genre-name__select-item" value="">All genre</option>
                <option class="genre-name__select-item" value="1">寿司</option>
                <option class="genre-name__select-item" value="2">焼肉</option>
                <option class="genre-name__select-item" value="3">居酒屋</option>
                <option class="genre-name__select-item" value="4">イタリアン</option>
                <option class="genre-name__select-item" value="5">ラーメン</option>
            </select>
        </div>
        <div class="search-form__restaurant-name">
            <i class="fa-solid fa-magnifying-glass search-icon" width="30px" height=""30px></i>
            <input class="restaurant-name__item" type="text" placeholder="Search...">
        </div>
    </form>
</div>
@foreach($restaurants as $restaurant)
<div class="restaurant-list-card">
    <div class="restaurant-list-card__img">
        <img src="{{ $restaurant->img_url}}" alt="店舗画像">
    </div>
    <div class="restaurant-list-card__content">
        <p class="restaurant-list-card__content-name">{{ $restaurant->name }}</p>
    </div>
    <div class="restaurant-list-card__content-tag">
        <p class="restaurant-list-card__content-tag-item">#{{ $restaurant->area->area_name }}</p>
        <p class="restaurant-list-card__content-tag-item">#{{ $restaurant->genre->genre_name }}</p>
    </div>
    <div class="restaurant-list-card__content-btn">
        <a class="restaurant-detail__btn" href="">詳しくみる</a>
        <i class="fa-solid fa-heart favorite-btn" data-restaurant-id="{{ $restaurant->id }}" id="favoriteButton"></i>
</div>
@endforeach
@endsection
