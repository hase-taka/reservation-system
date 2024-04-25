<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservationReminderMail;

class SendReservationReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
         // 予約情報のリマインダーメールを送信する処理を実装
    $reservations = Reservation::whereDate('date', now()->toDateString())->get();

    foreach ($reservations as $reservation) {
        // リマインダーメールを送信する処理
        Mail::to($reservation->user->email)->send(new ReservationReminderMail($reservation));
    }
    }
}
