<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;



class ReviewController extends Controller
{
    public function create(Request $request){
        $id = $request->input('id');
        $reservation = Reservation::findOrFail($id);

        $user = $request->user();

        return view('restaurant_review', compact('reservation','user'));
    }


    public function store(Request $request){

        // バリデーションルール
    $rules = [
        'rating' => 'required',
    ];

    // エラーメッセージ
    $messages = [
        'rating.required' => '評価を1〜5でお選びください。',
    ];

    // バリデーションの実行
    $request->validate($rules, $messages);



    $userId = Auth::id();
    $restaurantId = $request->input('restaurant_id');

    // ユーザーIDと店舗IDの組み合わせがすでに存在するかどうかを確認
    $existingReview = Review::where('user_id', $userId)
                            ->where('restaurant_id', $restaurantId)
                            ->first();

    // もし組み合わせが存在する場合はエラーメッセージを表示して保存を拒否
    if ($existingReview) {
        return back()->withErrors(['already_posted' => 'すでにレビューを投稿しています。']);
    }

        $nickname = $request->input('nickname');

    // ニックネームが空欄の場合、ユーザーの名前を代わりに送信する
    if (empty($nickname)) {
        $user = $request->user();
        $nickname = $user->name;
    }

    // ログインしているユーザーのIDを取得する
    $userId = Auth::id();

    $review = new Review();
    $review->user_id = $userId;
    $review->restaurant_id = $request->input('restaurant_id');
    $review->nickname = $nickname;
    $review->rating = $request->input('rating');
    $review->comment = $request->input('comment');
    $review->save();

    $reservationId = $request->input('reservation_id');
    Reservation::destroy($reservationId);

    return redirect()->route('my_page')->with('success', 'レビューを投稿し、関連の予約を削除されました。');
    }

}
