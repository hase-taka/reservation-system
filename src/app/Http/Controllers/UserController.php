<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function my_page(){
        // ログイン中のユーザーを取得
        $user = auth()->user();

        // ユーザーに関連する予約を取得
        $reservations = $user->reservations()->with('restaurant')->get();

        // ユーザーに関連するお気に入りのレストランを取得
        $favorites = $user->favorites()->with('restaurant')->get();

        // Mypageビューにログイン中のユーザー、予約、お気に入りのレストランデータを渡す
        return view('my_page', [
            'user' => $user,
            'reservations' => $reservations,
            'favorites' => $favorites,
        ]);
    }
}
