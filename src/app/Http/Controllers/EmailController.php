<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\CustomEmail;
use App\Models\User;

class EmailController extends Controller
{
    public function showCreateForm(Request $request){

        $user = $request->user();

        if ($user->role_id === 1) {
        return view('emails.create_email',compact('user'));
        }
    }

    public function sendEmail(Request $request)
    {
        $subject = $request->input('subject');
        $content = $request->input('content');
        
        // 一斉送信処理
        $users = User::where('role_id', 3)->get(); // roleが3のユーザーを取得
        foreach ($users as $user) {
            Mail::to($user->email)->send(new CustomEmail($subject, $content));
        }

        return redirect()->back()->with('success', 'メールを送信しました');
    }
}
