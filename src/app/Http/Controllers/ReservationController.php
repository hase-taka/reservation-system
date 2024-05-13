<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ReservationStoreRequest;
use App\Models\Restaurant;
use App\Models\Area;
use App\Models\Genre;
use App\Models\Favorite;
use App\Models\Reservation;
use App\Models\CourseMenu;
use Carbon\Carbon;


class ReservationController extends Controller
{
    public function index(Request $request){
    
    $restaurants = Restaurant::all();
    $areas = Area::all();
    $genres = Genre::all();

    $user = $request->user();

    

        return view('restaurant_list', compact('restaurants', 'areas', 'genres','user'));

        // if ($user->role_id === 1) {
        //     return view('restaurant_list_admin', compact('restaurants', 'areas', 'genres'));
        // } elseif ($user->role_id === 2) {
        //     return view('restaurant_list_representative', compact('restaurants', 'areas', 'genres'));
        // } else {
        //     return view('restaurant_list', compact('restaurants', 'areas', 'genres'));
        // }
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

    $user = $request->user();

        // if ($user->role_id === 1) {
        //     return view('restaurant_list_admin', compact('restaurants', 'areas', 'genres'));
        // } elseif ($user->role_id === 2) {
        //     return view('restaurant_list_representative', compact('restaurants', 'areas', 'genres'));
        // } else {
        //     return view('restaurant_list', compact('restaurants', 'areas', 'genres'));
        // }



    return view('restaurant_list', compact('restaurants', 'areas', 'genres','user'));
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



    public function show(Request $request,$id)
    {
        // restaurantの詳細を取得
        $restaurant = Restaurant::findOrFail($id);

        // $user = auth()->id();
        $user = $request->user();

        $menus = CourseMenu::where('restaurant_id',$id)->get();
        

        return view('restaurant_detail', compact('restaurant','user','menus'));
    }



    public function store(ReservationStoreRequest $request){
        $user_id = auth()->id();
        $user = $request->user();

        $today = Carbon::now()->format('Y-m-d');
        $now = Carbon::now()->format('H:i');
        $inputDate = $request->date;
        $inputTime = $request->time;
        // dd($today);
        if( $today == $inputDate && $now > $inputTime ){
            return redirect()->back()->with('error','※只今の日時以降の入力を行なってください');
        };
        
        $course_name = CourseMenu::where('restaurant_id',$request->restaurant_id)->where('price',$request->course_price)->value('name');
        
        $course_price = $request->course_price;
        $number = $request->number;

        $reservation = Reservation::create([
            'user_id' => $user_id,
            'restaurant_id' => $request->restaurant_id,
            'date' => $request->date,
            'time' => date('H:i', strtotime($request->time)),
            'number' => $request->number,
            'course_name' => $course_name,
            'course_price' => $request->course_price,
        ]);

        $restaurant_id = $request->restaurant_id;

        return view('done',compact('user','course_price','number','restaurant_id','user_id'));
    }


    public function edit(Request $request,$id)
    {
        $reservation = Reservation::findOrFail($id);
        $user = $request->user();
        $restaurant = Restaurant::where('id',$reservation->restaurant_id)->get();
        $menus = CourseMenu::where('restaurant_id',$reservation->restaurant_id)->get();

        return view('reservation_edit', compact('reservation','user','restaurant','menus'));
    }



    public function update(ReservationStoreRequest $request, $id)
    {
        $reservation = Reservation::findOrFail($id);

        $today = Carbon::now()->format('Y-m-d');
        $now = Carbon::now()->format('H:i');
        $inputDate = $request->date;
        $inputTime = $request->time;

        if( $today == $inputDate && $now > $inputTime ){
            return redirect()->back()->with('error','※只今の日時以降の入力を行なってください');
        };
// $model->update(['属性名' => '更新値', ...]);
        $restaurant = Restaurant::where('id',$reservation->restaurant_id)->first();
        $restaurantId = $restaurant->id;
        $course_name = CourseMenu::where('restaurant_id',$restaurantId)->where('price',$request->course_price)->value('name');

        // 予約を更新する
        $reservation->update([
            'date' => $request->date,
            'time' => $request->time,
            'number' => $request->number,
            'course_name' => $course_name,
            'course_price' => $request->course_price,
        ]);


        $course_price = $request->course_price;
        $number = $request->number;
        $restaurant_id = $restaurantId;
        $user_id = auth()->id();
        $user = $request->user();

        return view('done',compact('user','course_price','number','restaurant_id','user_id'));
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
