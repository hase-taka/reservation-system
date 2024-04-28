@extends('layouts.app_admin')

@section('css')
<link rel="stylesheet" href="{{ asset('css/users_role_change.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<style>

</style>
@endsection

@section('content')
<div class="role-change__head">
    <h2 class="role-change__title">利用者一覧・管理</h2>
</div>
<div class="mail-create__btn">
    <a class="mail-create__btn-submit" href="/create_email">メール作成</a>
</div>
<div class="user-role__table">
    <table class="user-role__table-inner">
        <div class="user-role__table-item">
            <tr class="role-table__row">
                <th class="role-table__head-id">ID</th>
                <th class="role-table__head">Name</th>
                <th class="role-table__head">Role</th>
                <th class="role-table__head-btn"></th>
            </tr>
            @foreach($users as $user)
            <tr class="role-table__row">
                <td class="role-table__data">{{ $user->id }}</td>
                <td class="role-table__data">{{ $user->name }}</td>
                <td class="role-table__data">{{ $user->role->name }}</td>
                <td><button class="role-change__btn" data-user-id="{{ $user->id }}">変更</button></td>
            </tr>
            @endforeach
        </div>
    </table>
</div>
<div class="pagination">
        {{ $users->links('pagination::default') }}
    </div>


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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
$(document).ready(function() {
    // モーダルウィンドウを表示する関数
    function showModal(userId, roleName) {
        $('#current-role').text(roleName); // 現在の役割を表示
        $('#myModal').fadeIn(); // モーダルウィンドウを表示
        $('#saveRole').data('user-id', userId); // 変更ボタンにユーザーIDを設定
    }

    // モーダルウィンドウを閉じる関数
    function closeModal() {
        $('#myModal').fadeOut(); // モーダルウィンドウを非表示
    }

    // 変更ボタンがクリックされた時の処理
    $('#saveRole').click(function() {
        var userId = $(this).data('user-id'); // 変更ボタンに設定されたユーザーIDを取得
        var newRole = $('#newRole').val(); // 選択された新しい役割を取得
        $.ajax({
            url: '/users/' + userId + '/update_role',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                role_id: newRole
            },
            success: function(response) {
                alert(response.message);
                closeModal(); // 成功時にモーダルウィンドウを閉じる
                $('#userRole_' + userId).text(response.new_role); // 役割を更新
                location.reload(); // ページをリロード
            },
            error: function(xhr) {
                alert('Error: ' + xhr.responseText);
            }
        });
    });

    // 閉じるボタンがクリックされた時の処理
    $('#closeModal').click(function() {
        closeModal(); // モーダルウィンドウを閉じる
    });

    // 変更ボタンがクリックされた時の処理
    $(".role-change__btn").click(function() {
        var userId = $(this).data('user-id');
        var roleName = $(this).closest('tr').find('.role-table__data:eq(2)').text(); // ユーザーの役割を取得
        showModal(userId, roleName); // モーダルウィンドウを表示
    });
});
</script>

@endsection
