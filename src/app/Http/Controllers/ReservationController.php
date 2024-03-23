<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurant;

class ReservationController extends Controller
{
    public function index(Request $request){
        $restaurants = Restaurant::all();
        return view('restaurant-list',compact('restaurants'));
    }
}
