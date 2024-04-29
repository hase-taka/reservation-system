<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrController extends Controller
{
    public function qr_create(Request $request){
        $user = $request->user();

        $reservation_id  = $request->input('reservation_id');
        $user_id  = $request->input('user_id');
        $restaurant_id  = $request->input('restaurant_id');
        $date  = $request->input('date');
        $time  = $request->input('time');
        $number  = $request->input('number');
        $paid  = $request->input('paid');
        $course  = $request->input('course');

        $data = mb_convert_encoding("Reservation ID: $reservation_id, User ID: $user_id, Restaurant ID: $restaurant_id, Date: $date, Time: $time, Number: $number, Paid: $paid, Course: $course", 'ISO-8859-1', 'UTF-8');

        // QRコードを生成
        $qrCode = QrCode::size(200)->generate($data);

        return view('qr_create', compact('user','qrCode'));
    }
}
