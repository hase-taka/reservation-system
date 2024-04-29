<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Restaurant;
use App\Models\Reservation;
use App\Models\CourseMenu;
use App\Http\Requests\RestaurantAdditionRequest;
use App\Rules\NotNull;
use Carbon\Carbon;

class RestaurantController extends Controller
{
    public function create()
    {
        // 管理者のみを取得してビューに渡す
        $user = auth()->user();
        $users = User::where('role_id', 2)->get();
        return view('restaurant_addition', compact('user','users'));
    }

    public function store(Request $request)
    {
        $rules = [
        'name' => 'required',
        'representative' => new NotNull,
        'area' => new NotNull,
        'genre' => new NotNull,
        'content' => 'required',
        'image' => 'required|image',
    ];

    $messages = [
        'name.required' => '店舗名は入力してくださいです。',
        'content.required' => '説明を入力してください。',
        'image.required' => '画像をアップロードしてください',
        'image.image' => '画像は画像ファイルを指定してください。',
        
    ];

    $request->validate($rules, $messages);
        // バリデーションなどの処理を行う
// dd($request);
        // 画像の保存などを行う
        // if ($request->hasFile('image')) {
        //     $restaurant->img_storage = $request->image->store('images');
        // }

        // レストランを作成し、代表者IDも設定する

        // ディレクトリ名
        $dir = 'images';
        // アップロードされたファイル名を取得
        $file_name = $request->file('image')->getClientOriginalName();
        // 取得したファイル名で保存
        // storage/app/public/任意のディレクトリ名/
        $request->file('image')->storeAs('public/' . $dir, $file_name);
        


        $restaurant = new Restaurant();
        $restaurant->name = $request->name;
        $restaurant->area_id = $request->area;
        $restaurant->genre_id = $request->genre;
        $restaurant->content = $request->content;
        $restaurant->file_name = $file_name;
        $restaurant->file_path = 'storage/' . $dir . '/' . $file_name;
        // $restaurant->img_storage = $request->image->store('images');
        $restaurant->representative_id = $request->representative;
        $restaurant->has_menu = $request->has_menu;
        $restaurant->save();

        // 作成されたレストランのIDを取得
        $id = $restaurant->id;

        if ($request->input('has_menu') == 1) {
            return redirect()->route('course_addition',['id' => $id]);
        } else {
            return redirect()->route('store_in_charge');
        }

        // リダイレクトなど適切な処理を行う
        // return redirect()->route('store_in_charge');
    }

    public function course_addition(Request $request){
        $restaurantId = $request->input('id');
        $restaurant = Restaurant::findOrFail($restaurantId);
        // $course_menus = CourseMenu::where('restaurant_id',$restaurantId)->get();

        return view('course_addition',compact('restaurantId','restaurant'));

    }


    public function course_store(Request $request){

    $id = $request->restaurantId;
        // 既存の店舗情報を取得する
    $restaurant = Restaurant::findOrFail($id);

    // フォームから送信されたデータを取得
    $courseNames = $request->input('course_name');
    $coursePrices = $request->input('course_price');
    $restaurantId = $request->input('restaurantId');

    // 取得したデータを保存する処理
    foreach ($courseNames as $key => $courseName) {
        // 各コース名と価格をデータベースに保存
        CourseMenu::create([
            'restaurant_id' => $restaurantId,
            'name' => $courseName,
            'price' => $coursePrices[$key]
        ]);
    }
        return redirect()->route('restaurant_edit', ['id' =>  $restaurant->id]);

    }










    public function edit(Request $request){
        

        $user = $request->user();

        if ($user->role_id === 2) {

            $id = $request->input('id');
            $restaurant = Restaurant::findOrFail($id);

            $users = User::where('role_id', 2)->get();

            $user_id = $restaurant->representative_id;
            $representative = User::findOrFail($user_id);
            // dd($representative);
            $representative_name = $representative->name;

            return view('restaurant_edit', compact('restaurant','users','representative_name','user'));
        }

        return view('restaurant_list',compact('user'));
    }



    public function update(Request $request){

        $rules = [
        'name' => 'required',
        'representative' => new NotNull,
        'area' => new NotNull,
        'genre' => new NotNull,
        'content' => 'required',
        'image' => 'required|image',
    ];

    $messages = [
        'name.required' => '店舗名は入力してくださいです。',
        'content.required' => '説明を入力してください。',
        'image.image' => '画像は画像ファイルを指定してください。',
        'image.required' => '画像をアップロードしてください。',
    ];

    $request->validate($rules, $messages);


        $id = $request->input('id');
        
        // 既存の店舗情報を取得する
        $restaurant = Restaurant::findOrFail($id);


        // ディレクトリ名
        $dir = 'images';
        // アップロードされたファイル名を取得
        

        

        // 入力されたデータを更新する
        $restaurant->name = $request->input('name');
        $restaurant->representative_id = $request->input('representative');
        $restaurant->area_id = $request->input('area');
        $restaurant->genre_id = $request->input('genre');
        $restaurant->content = $request->input('content');
        // $restaurant-> has_menu = $request->input('has_menu');

        // 画像がアップロードされている場合は、新しい画像を保存し、既存の画像を削除する
        if ($request->hasFile('image')) {
            // 新しい画像を保存する
            $image = $request->file('image');
            $file_name = $request->file('image')->getClientOriginalName();
            $image->storeAs('public/' . $dir, $file_name);

            $restaurant->file_name = $file_name;
            $restaurant->file_path = 'storage/' . $dir . '/' . $file_name;

            // 既存の画像が存在する場合は削除する
            if ($restaurant->img_url) {
                $restaurant->update(['img_url' => null]);
            }

        }

        // 店舗情報を保存する
        $restaurant->save();

            return redirect()->route('store_in_charge');
    }

    public function reservation_list(Request $request){
        $user = auth()->user();

        $id = $request->input('id');
        $restaurant = Restaurant::findOrFail($id);

        $now = Carbon::now();

        $reservations = Reservation::where('restaurant_id', $id)
                                ->where('date', '>=', Carbon::now()->format('Y-m-d'))
                                ->get()
                                ->filter(function ($reservation) use ($now) {
                                    $reservationDateTime = Carbon::createFromFormat('Y-m-d H:i:s', $reservation->date . ' ' . $reservation->time);
                                    return $reservationDateTime->gt($now);
                                });

        return view('restaurant_reservation_list',compact('restaurant','reservations','now','user'));
    }


    public function course_edit(Request $request){
        $restaurantId = $request->input('id');
        $restaurant = Restaurant::findOrFail($restaurantId);
        $course_menus = CourseMenu::where('restaurant_id',$restaurantId)->get();

        return view('course_edit',compact('course_menus','restaurantId','restaurant'));
    }


    public function course_update(Request $request){

    $id = $request->restaurantId;
        // 既存の店舗情報を取得する
    $restaurant = Restaurant::findOrFail($id);

    if($request->has_menu == 1){
        // 指定された restaurant_id に対応するコースメニューを削除
    CourseMenu::where('restaurant_id', $request->restaurantId)->delete();

    $restaurant->has_menu = $request->input('has_menu');
    $restaurant->save();

    // フォームから送信されたデータを取得
    $courseNames = $request->input('course_name');
    $coursePrices = $request->input('course_price');
    $restaurantId = $request->input('restaurantId');

    // 取得したデータを保存する処理
    foreach ($courseNames as $key => $courseName) {
        // 各コース名と価格をデータベースに保存
        CourseMenu::create([
            'restaurant_id' => $restaurantId,
            'name' => $courseName,
            'price' => $coursePrices[$key]
        ]);
    }
        return redirect()->route('course_edit', ['id' =>  $restaurant->id]);
    }elseif($request->has_menu == 0){

        $restaurant->has_menu = $request->input('has_menu');
        $restaurant->save();
        CourseMenu::where('restaurant_id', $request->restaurantId)->delete();

        return redirect()->route('course_edit', ['id' =>  $restaurant->id]);

    }
    }
}