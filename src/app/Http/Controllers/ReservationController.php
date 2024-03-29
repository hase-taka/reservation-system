<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurant;
use App\Models\Area;
use App\Models\Genre;
use App\Models\Favorite;

class ReservationController extends Controller
{
    public function index(Request $request){
    
    $restaurants = Restaurant::all();
    $areas = Area::all();
    $genres = Genre::all();

        return view('restaurant-list', compact('restaurants', 'areas', 'genres'));

    }

    public function search(Request $request){

        $selectedArea = $request->input('area');
    $selectedGenre = $request->input('genre');

    // 選択されたエリアとジャンルをセッションに保存
    session()->put('selected_area', $selectedArea);
    session()->put('selected_genre', $selectedGenre);

        $query = Restaurant::query();

    if ($request->filled('area')) {
        $query->where('area_id', $request->area);
    }

    if ($request->filled('genre')) {
        $query->where('genre_id', $request->genre);
    }

    if ($request->filled('restaurant_name')) {
        $query->where('name', 'like', '%' . $request->restaurant_name . '%');
    }

    // if (!$request->filled('area') || !$request->filled('genre')) {
    //     $restaurants = Restaurant::all();
    //     $areas = Area::all();
    //     $genres = Genre::all();
    //     return view('restaurant-list', compact('restaurants', 'areas', 'genres'));
    // }

    $restaurants = $query->get();

    $areas = Area::all();
    $genres = Genre::all();

    return view('restaurant-list', compact('restaurants', 'areas', 'genres'));
    }


    public function show($id)
    {
        // restaurantの詳細を取得
        $restaurant = Restaurant::findOrFail($id);

        // restaurantの詳細ページを表示
        return view('restaurant-detail', compact('restaurant'));
    }

    public function toggle(Request $request, Restaurant $restaurant)
    {
        $userId = auth()->id();
        $status = '';

        // お気に入りが既に登録されているかチェック
        $existingFavorite = Favorite::where('user_id', $userId)
                                     ->where('restaurant_id', $restaurant->id)
                                     ->first();

        if($existingFavorite) {
            // お気に入りがあれば削除
            $existingFavorite->delete();
            $status = 'removed';
        } else {
            // お気に入りがなければ追加
            $favorite = new Favorite();
            $favorite->restaurant_id = $restaurant->id;
            $favorite->user_id = $userId;
            $favorite->save();
            $status = 'added';
        }

        return response()->json(['status' => $status]);
    }
}
