@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/users_role_change.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
   
@endsection

@section('content')

<!-- モーダルウィンドウ -->
<div id="myModal" class="modal" style="display: none;">
    <div class="modal-content">
        <div class="modal-title">
            <h2>役割の変更</h2>
        </div>
        <div class="role-change__form">
            <div class="now-role">
                <p class="now-role__inner-head">現在の役割</p>
                <p class="now-role__inner" id="current-role"></p>
            </div>
            <div class="arrow-img">
                <img src="/images/arrow.png" alt="arrow-icon" width="50px" height="50px">
            </div>
            <div class="new-role">
                <p class="new-role__inner-head">新たな役割</p>
                <select class="new-role__inner" id="newRole">
                    <option value="1">管理者</option>
                    <option value="2">店舗代表者</option>
                    <option value="3">利用者</option>
                </select>
            </div>
        </div>
        <div class="role-change__btn-some">
            <button class="save-btn" id="saveRole">変更</button>
            <button class="close-btn" id="closeModal">閉じる</button>
        </div>
    </div>
</div>


@endsection
