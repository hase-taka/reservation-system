@extends('layouts.app_representative')

@section('css')
<link rel="stylesheet" href="{{ asset('css/course_edit.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection

@section('content')
<div class="restaurant-name">
    <h2>{{ $restaurant->name}}</h2>
</div>
<div class="course-edit__wrap">
    <div class="old-course__table-title"><p>現在のコース設定</p></div>
    <div class="old-corse__table">
        <table class="old-course__table-inner">
            <tr class="old-course__row-head">
                <th class="old-course__head-course"><p>コース名</p></th>
                <th class="old-course__head-price"><p>金額</p></th>
            </tr>
            @if ($course_menus->count() > 0)
            @foreach($course_menus as $course_menu)
            <tr class="old-course__row">
                <td class="course-name"><p>{{$course_menu->name}}</p></td>
                <td class="course-price"><p>{{$course_menu->price}}</p></td>
            </tr>
            @endforeach
            @else
                <tr><td><p>現在、コース設定はありません。</p></td></tr>
            @endif
        </table>
    </div>

    <div class="new-course__table-title"><p>新しいコース設定</p></div>
    <div class="new-course__form">
        <form class="new-course__form-inner" action="{{ route('course_update') }}" method=post>
        @csrf
            <div class="new-course__table">
                <table class="new-course__table-inner">
                    <tr class="table-row">
                        <th class="table-head">コース設定</th>
                        <td class="table-data">
                            <input class="restaurant-course" type="radio" name="has_menu" value="0" checked >無し
                            <input class="restaurant-course" type="radio" name="has_menu" value="1" >有り
                        </td>
                    </tr>
                    <tr class="new-course__row-head">
                        <th><p>コース名</p></th>
                        <th><p>金額</p></th>
                    </tr>
                    <tbody id="course_fields">
                        <div class="course_field">
                            <tr class="new-course__row">
                                <td><input name="course_name[]" class="course-name" type="text" ></td>
                                <td><input type="text" name="course_price[]" class="course-price"></td>
                            </tr>
                        </div>
                    </tbody>
                </table>
                <input type="hidden" name="restaurantId" value="{{ $restaurantId }}">
                <div class="course-edit__btn">
                    <button class="course-addition__btn" type="button" id="add_course">コースを追加</button>
                    <div class="course-edit__btn-sub">
                        <a class="restaurant-edit_transition" href="{{ route('restaurant_edit', ['id' => $restaurant->id]) }}">店舗編集へ戻る</a>
                        <button class="new-course__form-submit" type="submit">更新</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('add_course').addEventListener('click', function() {
        var courseFields = document.getElementById('course_fields');
        var newCourseField = document.createElement('tr'); // tr要素を新しく生成
        newCourseField.classList.add('new-course__row'); // クラスを追加
        newCourseField.innerHTML = `
            <td><input name="course_name[]" class="course_name" type="text" ></td>
            <td><input type="text" name="course_price[]" class="course_price"></td>
        `;
        courseFields.appendChild(newCourseField);
    });
</script>
@endsection
