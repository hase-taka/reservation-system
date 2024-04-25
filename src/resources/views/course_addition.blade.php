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
    
    <div class="course-addition__title"><p>コース設定</p></div>
    <div class="new-course__form">
        
        <form action="{{ route('course_store') }}" method=post>
        @csrf
            
            <div class="new-course__table">
                <table class="new-course__table-inner">
                    <!-- <tr class="table-row">
                        <th class="table-head">コース設定</th>
                        <td class="table-data">
                            <input class="restaurant-course" type="radio" name="has_menu" value="0" checked >無し
                            <input class="restaurant-course" type="radio" name="has_menu" value="1" >有り
                        </td>
                    </tr> -->
                    
                    <tr class="new-course__row">
                        <th><p>コース名</p></th>
                        <th><p>金額</p></th>
                    </tr>
                    <tbody id="course_fields">
                        <div class="course_field">
                            <tr class="new-course__row">
                                <td><input name="course_name[]" class="course_name" type="text" ></td>
                                <td><input type="text" name="course_price[]" class="course_price"></td>
                            </tr>
                        </div>
                    </tbody>
                </table>
                <input type="hidden" name="restaurantId" value="{{ $restaurantId }}">
                <div class="course-addition__btn-wrap">
                    <button class="course-addition__btn" type="button" id="add_course">コースを追加</button>
                    <button class="new-course__form-submit" type="submit">作成</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- <div id="course_fields">
        <div class="course_field">
            <label for="course_name">コース名</label>
            <input type="text" name="course_name[]" class="course_name">
            <label for="course_price">価格</label>
            <input type="text" name="course_price[]" class="course_price">
        </div>
    </div> -->

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
