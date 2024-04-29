<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Restaurant;
use App\Models\Reservation;
use App\Models\Area;
use App\Models\Genre;
use Carbon\Carbon;


class UserController extends Controller
{
    public function my_page(){

        // 現在の時刻
        $now = Carbon::now();


        // ログイン中のユーザーを取得
        $user = auth()->user();

        // ユーザーに関連する予約を取得
        $reservations = $user->reservations()->with('restaurant')->get();

        

        // ユーザーに関連するお気に入りのレストランを取得
        $favorites = $user->favorites()->with('restaurant')->get();

        // Mypageビューにログイン中のユーザー、予約、お気に入りのレストランデータを渡す
        // if ($user->role_id === 1) {
        //     return view('my_page_admin', compact('user', 'reservations', 'favorites','now'));
        // } elseif ($user->role_id === 2) {
        //     return view('my_page_representative', compact('user', 'reservations', 'favorites','now'));
        // } else {
        //     return view('my_page', compact('user', 'reservations', 'favorites','now'));
        // }


        return view('my_page', compact('user','reservations','favorites','now'));


        // return view('my_page', [
        //     'user' => $user,
        //     'reservations' => $reservations,
        //     'favorites' => $favorites,
        // ]);
    }
    


    public function users(Request $request)
    {
        
        $users = User::paginate(7);

        $user = auth()->user();
        $role_changer = $request->user();

        if ($role_changer->role_id === 1) {
            return view('users_role_change', compact('users','user'));
        }else {
            // デフォルトのリダイレクト先にリダイレクト
            return redirect()->route('restaurant_list');
        }

        // return view('users_role_change', compact('users'));
    }

    public function role_change(Request $request){
        $user_id = $request->input('id');

        return view('role_change',compact('user_id'));
    }


    public function update_role(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->role_id = $request->role_id;
        $user->save();

        return response()->json(['message' => 'Role updated successfully', 'user_id' => $id, 'new_role' => $user->role->name]);
    }




    public function store_in_charge_list(Request $request){
         // ログイン中のユーザーを取得
        $user = auth()->user();
        $areas = Area::all();
        $genres = Genre::all();

        // $restaurants = $user->representative()->with('restaurant')->get();
        $restaurants = Restaurant::where('representative_id', $user->id)->get();

        if ($user->role_id === 2) {
            return view('store_in_charge', compact('restaurants','areas','genres','user'));
        }else {
            // デフォルトのリダイレクト先にリダイレクト
            return redirect()->route('restaurant_list');
        }
    }


    
}
