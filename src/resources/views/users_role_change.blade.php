@extends('layouts.app_admin')

@section('css')
<link rel="stylesheet" href="{{ asset('css/users_role_change.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
</script> -->

<style>
      /* モーダルのスタイル */
  .modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0,0,0,0.4);
  }

  .modal-content {
    border-radius:5px;
    background-color: #fefefe;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 60%;
    /* display: flex;
    justify-content: space-between; */
  }

  .role-change__form {
    display: flex;
    justify-content: space-around;
  }

  .modal-title{
    text-align: center;
  }

  .now-role, .new-role{
    width:25%;
    border-radius: 5px;
    background-color: rgb(63, 102, 242);
    color: #fff;
    text-align: center;
  }
  .now-role{
    margin-left: 8%;
  }
  .new-role{
    margin-right: 8%;
  }

  .arrow-img{
    align-items: center;
    margin-top:2%;
  }

  .now-role__inner-head,.new-role__inner-head{
    font-weight: bold;
  }

  .new-role__inner{
    border:none;
    border-radius: 5px;
    height:25%;
  }

  .role-change__btn-some{
    text-align:right;
    margin: 2% 13% 0 0;
  }

  .role-change__btn-some button{
    border:none;
    border-radius:5px;
    background-color:rgb(22, 70, 243);
    color:#fff;
    margin-left:2.5%;
    width:90px;
    height: 30px;
  }

</style>
@endsection

@section('content')
<div class="role-change__head">
    <h2 class="role-change__title">利用者一覧・管理</h2>
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
    $(".role-change__btn").click(function() {
        var userId = $(this).data('user-id');
        var user = {!! $users->toJson() !!}.find(user => user.id === userId);
        $('#current-role').text(user.role.name);
        $('#myModal').fadeIn();
        
        $('#saveRole').click(function() {
            var newRole = $('#newRole').val();
            $.ajax({
                url: '/users/' + userId + '/update_role',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    role_id: newRole
                },
                success: function(response) {
                    alert(response.message);
                    $('#myModal').fadeOut();
                    $('#userRole_' + userId).text(response.new_role); // 役割を更新
                    location.reload();
                },
                error: function(xhr) {
                    alert('Error: ' + xhr.responseText);
                }
            });
        });

        $('#closeModal').click(function() {
            $('#myModal').fadeOut();
        });
    });
});
</script>


@endsection
