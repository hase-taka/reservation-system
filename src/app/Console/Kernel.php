<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('reminder:send')->dailyAt('8:00');


    //     $schedule->call(function () {
    //     // 予約情報のリマインダーメールを送信するコマンドを実行
    //     Artisan::call('send:reservation-reminder');
    // })->dailyAt('11:14'); // 予約当日の朝9時に実行するように設定


    //     // 予約リマインダーを送信するタスクを毎日の朝にスケジュールします
    // $schedule->call(function () {
    //     // 当日の予約情報を取得
    //     $reservations = Reservation::whereDate('date', Carbon::today())->get();
        
    //     // 当日の予約情報がある場合にのみリマインダーを送信
    //     foreach ($reservations as $reservation) {
    //         // リマインダーメールを送信する処理を記述
    //         // 以下は例です。実際のメール送信方法に合わせて変更してください。
    //         Mail::to($reservation->user->email)->send(new ReservationReminderMail($reservation));
    //     }
    // })->dailyAt('10:45'); // 朝8時に実行

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
