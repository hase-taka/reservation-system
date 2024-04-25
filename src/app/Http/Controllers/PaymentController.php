<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Carbon\Carbon;

use Illuminate\Http\Request;
use App\Http\Requests\StorePaymentRequest;
use Exception;

use Stripe\Stripe;
use Stripe\Customer;
use Stripe\Charge;

class PaymentController extends Controller
{
    public function create(Request $request)
    {
        $user = $request->user();

        $price = $request->input('price');
        $number = $request->input('number');
        $restaurant_id = $request->input('restaurant_id');
        $user_id = $request->input('user_id');

        $reservation = Reservation::where('restaurant_id',$restaurant_id)->where('user_id',$user_id)->latest()
    ->first();
        $reservation_id = $reservation->id;
        // dd($reservation_id);

        return view('payment.create',compact('user','price','number','reservation_id'));
    }


    public function charge(Request $request)
    {
        try {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $customer = Customer::create(array(
            'email' => $request->stripeEmail,
            'source' => $request->stripeToken
        ));

        // フォームから送信された金額を取得（デフォルトは1000円）
        $amount = $request->input('amount');

        $charge = Charge::create(array(
            'customer' => $customer->id,
            'amount' => $amount, // フォームから送信された金額を使用
            'currency' => 'jpy'
        ));

         // 既存の予約情報を取得する
        $reservation = Reservation::findOrFail($request->id);
        $reservation->paid = $request->input('paid');
        $reservation->save();

         // 現在の時刻
        $now = Carbon::now();

        // ログイン中のユーザーを取得
        $user = auth()->user();

        // ユーザーに関連する予約を取得
        $reservations = $user->reservations()->with('restaurant')->get();

        // ユーザーに関連するお気に入りのレストランを取得
        $favorites = $user->favorites()->with('restaurant')->get();

        return view('my_page', compact('user','reservations','favorites','now'));
    } catch (\Exception $ex) {
        return $ex->getMessage();
    }

        // \Stripe\Stripe::setApiKey(config('stripe.stripe_secret_key'));

        // try {
        //     \Stripe\Charge::create([
        //         'source' => $request->stripeToken,
        //         'amount' => 1000,
        //         'currency' => 'jpy',
        //     ]);
        // } catch (Exception $e) {
        //     return back()->with('flash_alert', '決済に失敗しました！('. $e->getMessage() . ')');
        // }
        // return back()->with('status', '決済が完了しました！');
    }
}
