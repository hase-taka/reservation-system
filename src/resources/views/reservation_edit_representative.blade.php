@extends('layouts.app_representative')

@section('css')
<link rel="stylesheet" href="{{ asset('css/reservation_edit.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>

</script>
   
@endsection

@section('content')

<div class="reservation__edit-page">
    <div class="old-reservation">
        <div class="reservation-table">
            <table class="reservation-table__inner">
                <tr class="reservation-table__row">
                    <td class="reservation-table__head">Shop</td>
                    <td class="reservation-table__data">{{ $reservation->restaurant->name }}</td>
                </tr>
                <tr class="reservation-table__row">
                    <td class="reservation-table__head">Date</td>
                    <td class="reservation-table__data">{{ $reservation->date }}</td>
                </tr>
                <tr class="reservation-table__row">
                    <td class="reservation-table__head">Time</td>
                    <td class="reservation-table__data">{{ date('H:i', strtotime($reservation->time)) }}</td>
                </tr>
                <tr class="reservation-table__row">
                    <td class="reservation-table__head">Number</td>
                    <td class="reservation-table__data">{{ $reservation->number }}</td>
                </tr>
            </table>
        </div>
    </div>
    <div class="arrow-img">
        <img src="/img/arrow.png" alt="arrow-icon" width="50px" height="50px">
    </div>
    <div class="reservation__edit-form">
        
        <form class="reservation__edit-form__inner" action="{{ route('reservation.update', $reservation->id) }}" method="post">
        @csrf
        @method('PUT')
            <input type="hidden" name="restaurant_id" value="{{ $reservation->restaurant->id }}">
            <div class="reservation__edit-table">
                <table class="reservation__edit-table--inner">
                
                    <tr class="edit-form__row">
                        <td class="edit-form__head">Shop</td>
                        <td class="edit-form__data"><p class="restaurant-name" name="restaurant-name">{{ $reservation->restaurant->name }}</p></td>
                    </tr>
                
                    <tr class="edit-form__row">
                        <td class="edit-form__head">Date</td>
                        <td class="edit-form__data"><input class="edit-form__item-input" type="date" name="date"></td>
                    </tr>
                    @if ($errors->has('date'))
                    <div>
                        <tr>
                            <td class="error-message" colspan="2">
                                {{$errors->first('date')}}
                            </td>
                        </tr>
                    </div>
                    @endif
                    <tr class="edit-form__row">
                        <td class="edit-form__head">Time</td>
                        <td class="edit-form__data"><input class="edit-form__item-input" name="time" type="time" step="600"></td>
                    </tr>
                    @if ($errors->has('time'))
                    <div >
                        <tr>
                            <td class="error-message">
                                {{$errors->first('time')}}
                            </td>
                        </tr>
                    </div>
                    @endif
                    <tr>
                        <td class="error-message" colspan="2">
                        {{session('error')}}
                        </td>
                    </tr>
                    <tr class="edit-form__row">
                        <td class="edit-form__head">Number</td>
                        <td class="edit-form__data"><input class="edit-form__item-input" name="number" type="number" min="1"></td>
                    </tr>
                    @if ($errors->has('number'))
                    <div >
                        <tr>
                            <td class="error-message" colspan="2">
                                {{$errors->first('number')}}
                            </td>
                        </tr>
                    </div>
                    @endif
                </table>
            </div>
            <div class="edit-form__btn">
                <button class="edit-form__btn-submit" type="submit">変更</button>
            </div>
        </form>
    </div>
</div>


@endsection
