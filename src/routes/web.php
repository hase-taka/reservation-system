<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReservationController;


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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/thanks', [AuthController::class, 'thanks'])->name('thanks');


Route::group(['middleware' => 'auth'], function() {
    // Route::get('/thanks', [AuthController::class, 'thanks'])->name('thanks');

    Route::get('/done', [AuthController::class,'done']);

    Route::get('/',[ReservationController::class,'index'])->name('restaurant-list');
    Route::get('/detail/{id}:shop_id', [ReservationController::class, 'show'])->name('restaurant-detail');
    Route::post('/restaurant/search', [ReservationController::class, 'search'])->name('restaurant-search');

    // Route::post('/favorites/toggle/{restaurant_id}', [ReservationController::class, 'toggle'])->name('favorites.toggle');
    Route::post('/favorites/toggle/{restaurant}', [ReservationController::class, 'toggle'])->name('favorites.toggle');



});