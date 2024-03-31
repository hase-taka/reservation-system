<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurant;
use App\Models\Area;
use App\Models\Genre;
use App\Models\Favorite;
use App\Models\Reservation;


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

    public function store(Request $request){
         
        $user_id = auth()->id();

        $reservation = Reservation::create([
            'user_id' => $user_id,
            'restaurant_id' => $request->restaurant_id,
            'date' => $request->date,
            'time' => date('H:i', strtotime($request->time)),
            'number' => $request->partySize,
        ]);
        // フォームから送信されたデータで予約を作成する
    // $reservation = new Reservation();
    // $reservation->user_id = auth()->id(); // ユーザーIDを設定
    // $reservation->restaurant_id = $request->input('restaurant_id'); // レストランIDを設定
    // $reservation->date = $request->input('date');
    // $reservation->time = $request->input('time');
    // $reservation->number = $request->input('number');
    // $reservation->save();
        return view('done');
    }


    // public function update(Request $request, $id)
    // {
    //     // バリデーションなどの適切な処理を行う
    //     $validatedData = $request->validate([
    //         'date' => 'required|date',
    //         'time' => 'required',
    //         'number' => 'required|integer|min:1',
    //     ]);

    //     // 予約を更新する
    //     $reservation = Reservation::findOrFail($id);
    //     $reservation->date = $request->date;
    //     $reservation->time = $request->time;
    //     $reservation->number = $request->number;
    //     $reservation->save();

    //     // リダイレクトなど適切なレスポンスを返す
    //     return response()->json(['message' => '予約が更新されました']);
    // }

    public function edit($id)
    {
        $reservation = Reservation::findOrFail($id);
        return view('reservation_edit', compact('reservation'));
    }

    public function update(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);
        // バリデーションなどの適切な処理を行う
        $validatedData = $request->validate([
            'date' => 'required|date',
            'time' => 'required',
            'number' => 'required|integer|min:1',
        ]);

        // 予約を更新する
        $reservation->update($validatedData);

        // 更新後に適切な処理を行う（リダイレクトなど）
        return redirect()->route('mypage')->with('success', '予約が更新されました');
    }

    public function destroy($id)
    {
        // 予約を削除する
        $reservation = Reservation::findOrFail($id);
        $reservation->delete();

        // リダイレクトなど適切なレスポンスを返す
        return response()->json(['message' => '予約がキャンセルされました']);
    }

}
