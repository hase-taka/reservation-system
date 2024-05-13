@extends('layouts.app_representative')

@section('css')
<link rel="stylesheet" href="{{ asset('css/restaurant_edit.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection

@section('content')

<div class="restaurant__detail-reservation">
    <div class="restaurant-detail">
        <div class="detail-left">
            <div class="restaurant-detail__header">
                <div class="return-page__btn">
                    <a class="return-page__btn-submit" href="/store_in_charge"><</a>
                </div>
                <div class="restaurant-detail-name">
                    <h2 class="restaurant-detail-name__inner">{{ $restaurant->name }}</h2>
                </div>
                <div class="representative-name"><p>店舗代表者名：</p></div>
                <div class="representative-name__inner"><p>{{ $representative_name }}</p></div>
            </div>
            <div class="restaurant-detail-img">
                @if($restaurant->img_url)
                    <img src="{{ $restaurant->img_url }}" alt="店舗画像">
                @elseif($restaurant->file_path)
                    <img src="{{ asset($restaurant->file_path) }}" alt="Restaurant Image">
                @else
                    <img src="images/no_image.jpeg" alt="No Image">
                @endif
            </div>
        </div>
        <div class="area-genre-content_wrap">
            <div class="restaurant__tag">
                <p class="restaurant-tag-item">#{{ $restaurant->area->area_name }}</p>
                <p class="restaurant-tag-item">#{{ $restaurant->genre->genre_name }}</p>
            </div>
            <div class="restaurant__content">
                <p class="restaurant__content-inner">{{ $restaurant->content }}</p>
            </div>
        </div>
    </div>
    <div class="restaurant-edit__form">
        <div class="restaurant-edit__title">
            <h2 class="restaurant-edit__title-inner">店舗編集</h2>
        </div>
        <form class="restaurant-edit__form-inner" action="{{ route('restaurant_update', ['id' => $restaurant->id]) }}" method="post" enctype="multipart/form-data">
        @csrf
            <div class="edit-form__table">
                <table class="edit-form__table-inner">
                    <tr class="table-row">
                        <th class="table-head">店舗名</th>
                        <td class="table-data">
                            <input class="restaurant-name" name="name" type="text"  value="{{$restaurant->name}}" placeholder="店舗名">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <p class="restaurant-edit-form__error-message">
                                @error('name')
                                {{ $message }}
                                @enderror
                            </p>
                        </td>
                    </tr>
                    <tr class="table-row">
                        <th class="table-head">店舗代表者名</th>
                        <td class="table-data">
                            <select class="representative_id" name="representative" >
                                <option value="">選択してください</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <p class="restaurant-edit-form__error-message">
                                @error('representative')
                                {{ $message }}
                                @enderror
                            </p>
                        </td>
                    </tr>
                    <tr class="table-row">
                        <th class="table-head">エリア</th>
                        <td class="table-data">
                            <select class="restaurant-area" name="area" id="">
                                <option value="">選択してください</option>
                                <option value="1">東京都</option>
                                <option value="2">大阪府</option>
                                <option value="3">福岡県</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <p class="restaurant-edit-form__error-message">
                                @error('area')
                                {{ $message }}
                                @enderror
                            </p>
                        </td>
                    </tr>
                    <tr class="table-row">
                        <th class="table-head">ジャンル</th>
                        <td class="table-data">
                            <select class="restaurant-genre" name="genre" id="">
                                <option value="">選択してください</option>
                                <option value="1">焼肉</option>
                                <option value="2">寿司</option>
                                <option value="3">居酒屋</option>
                                <option value="4">イタリアン</option>
                                <option value="5">ラーメン</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <p class="restaurant-edit-form__error-message">
                                @error('genre')
                                {{ $message }}
                                @enderror
                            </p>
                        </td>
                    </tr>
                    <tr class="table-row">
                        <th class="table-head__content">説明</th>
                        <td class="table-data__content">
                            <textarea name="content" class="restaurant-content"  id="" cols="30" rows="5" value="{{$restaurant->content}}" placeholder="説明をここに入力してください"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <p class="restaurant-edit-form__error-message">
                                @error('content')
                                {{ $message }}
                                @enderror
                            </p>
                        </td>
                    </tr>
                    <tr class="table-row">
                        <th class="table-head">店舗画像</th>
                        <td class="table-data">
                            <input class="restaurant-image" type="file" name="image" placeholder="画像をアップロード">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <p class="restaurant-edit-form__error-message">
                                @error('image')
                                {{ $message }}
                                @enderror
                            </p>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="restaurant-edit__form-button">
                <a class="restaurant-edit__form-course-button" href="{{ route('course_edit', ['id' =>  $restaurant->id]) }}">コース設定</a>
                <button class="restaurant-edit__form-button-submit" type="submit">変更</button>
            </div>
        </form>
    </div>
@endsection
