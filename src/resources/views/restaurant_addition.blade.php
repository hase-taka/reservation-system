@extends('layouts.app_representative')

@section('css')
<link rel="stylesheet" href="{{ asset('css/restaurant_addition.css') }}">


@endsection

@section('content')
<div class="restaurant-addition__title">
    <h2 class="restaurant-addition__title-inner">店舗追加</h2>
</div>
<div class="restaurant-addition__form">
    <form class="restaurant-addition__form-inner" action="/restaurant/addition/store" method="post" enctype="multipart/form-data">
    @csrf
        <div class="addition-form__table">
            <table class="addition-form__table-inner">
                <tr class="table-row">
                    <th class="table-head">店舗代表者名</th>
                    <td class="table-data">
                        <select class="representative_id" name="representative_id">
                            @foreach($users as $user)
                            <!-- @if($user->role_id == 2) -->
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            <!-- @endif -->
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <p class="register-form__error-message">
                            @error('reservation_id')
                            {{ $message }}
                            @enderror
                        </p>
                    </td>
                </tr>
                <tr class="table-row">
                    <th class="table-head">店舗名</th>
                    <td class="table-data">
                        <input class="restaurant-name" name="name" type="text" placeholder="店舗名">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <p class="register-form__error-message">
                            @error('name')
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
                        <p class="register-form__error-message">
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
                        <p class="register-form__error-message">
                            @error('genre')
                            {{ $message }}
                            @enderror
                        </p>
                    </td>
                </tr>
                <tr class="table-row">
                    <th class="table-head__content">説明</th>
                    <td class="table-data__content">
                        <textarea name="content" class="restaurant-content"  id="" cols="30" rows="5" placeholder="説明をここに入力してください"></textarea>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <p class="register-form__error-message">
                            @error('content')
                            {{ $message }}
                            @enderror
                        </p>
                    </td>
                </tr>
                <tr class="table-row">
                    <th class="table-head">画像・画像URL</th>
                    <td class="table-data">
                        <input class="restaurant-image" type="file" name="image" placeholder="画像をアップロード">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <p class="register-form__error-message">
                            @error('restaurant-image')
                            {{ $message }}
                            @enderror
                        </p>
                    </td>
                </tr>
            </table>
        </div>
        <div class="restaurant-addition__form-button">
            <button class="restaurant-addition__form-button-submit" type="submit">追加</button>
        </div>
    </form>
</div>

@endsection