<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\EmailController;

use App\Models\Restaurant;
use App\Models\User;
use App\Models\Area;
use App\Models\Genre;
use Illuminate\Http\Request;




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/thanks', [AuthController::class, 'thanks'])->name('thanks');






Route::group(['middleware' => 'auth'], function() {
    // Route::get('/thanks', [AuthController::class, 'thanks'])->name('thanks');

    Route::get('/done', [AuthController::class,'done'])->name('done');

    // Route::get('/',[ReservationController::class,'index'])->name('restaurant_list');
    Route::get('/detail/{id}:shop_id', [ReservationController::class, 'show'])->name('restaurant-detail');
    Route::post('/restaurant/search', [ReservationController::class, 'search'])->name('restaurant-search');

    // Route::post('/favorites/toggle/{restaurant_id}', [ReservationController::class, 'toggle'])->name('favorites.toggle');
    Route::post('/favorites/toggle/{restaurant}', [ReservationController::class, 'toggle'])->name('favorites.toggle');

    Route::post('/reservation', [ReservationController::class, 'store'])->name('reservation.store');
    Route::get('/my_page', [UserController::class, 'my_page'])->name('my_page');

    // 予約の変更（PUTメソッド）
    // Route::put('/reservation/{id}', [ReservationController::class, 'update'])->name('reservation.update');

    Route::get('/reservation/{id}/edit', [ReservationController::class, 'edit'])->name('reservation.edit');
    Route::put('/reservation/{id}', [ReservationController::class, 'update'])->name('reservation.update');

    // Route::put('/reservations/{id}', 'ReservationController@update')->name('reservations.update'); // 予約情報を更新するためのルート

    // 予約のキャンセル（DELETEメソッド）
    Route::delete('/reservation/{id}', [ReservationController::class, 'destroy'])->name('reservation.destroy');

    Route::get('/users', [UserController::class, 'users'])->name('users.list');
    Route::post('/users/{id}/update_role', [UserController::class, 'update_role'])->name('users.update_role');

    Route::get('/store_in_charge', [UserController::class, 'store_in_charge_list'])->name('store_in_charge');

    
    Route::post('/restaurant/addition/store', [RestaurantController::class, 'store'])->name('restaurant_addition_store');
    Route::get('/restaurant/addition', [RestaurantController::class, 'create']);
    Route::get('/restaurant/edit', [RestaurantController::class, 'edit'])->name('restaurant_edit');
    Route::post('/restaurant/edit', [RestaurantController::class, 'update'])->name('restaurant_update');
    Route::get('/restaurant/reservation_list', [RestaurantController::class, 'reservation_list'])->name('reservation_list');

    Route::get('/restaurant/review', [ReviewController::class, 'create'])->name('restaurant_review');
    Route::post('/restaurant/review', [ReviewController::class, 'store'])->name('restaurant_review_store');
    Route::get('/restaurant/reservation_list', [RestaurantController::class, 'reservation_list'])->name('restaurant_reservation_list');



    Route::get('/create', [PaymentController::class, 'create'])->name('payment.create');
    Route::post('/charge', [PaymentController::class, 'charge'])->name('payment.store');
    


    

    Route::get('/create_email', [EmailController::class, 'showCreateForm'])->name('create.email');
    Route::post('/send_email', [EmailController::class, 'sendEmail'])->name('send.email');


    Route::get('/course_edit', [RestaurantController::class, 'course_edit'])->name('course_edit');
    Route::post('/course_update', [RestaurantController::class, 'course_update'])->name('course_update');
    Route::get('/course_addition', [RestaurantController::class, 'course_addition'])->name('course_addition');
    Route::post('/course_addition', [RestaurantController::class, 'course_store'])->name('course_store');
});

Route::middleware(['auth', 'verified'])->get('/', function (Request $request) {
    // ユーザーはメール確認を完了している必要があります
    $restaurants = Restaurant::all();
    $areas = Area::all();
    $genres = Genre::all();

    $user = $request->user();

        return view('restaurant_list', compact('restaurants', 'areas', 'genres','user'));

})->name('restaurant
_list');





    
