<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;


use App\Models\Reservation;

class ReservationReminderMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $reservation;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Reservation $reservation)
    {
        $this->reservation = $reservation;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.reservation_reminder')
                    ->subject('Reservation Reminder');

        // return $this->view('view.name');
    }
}
