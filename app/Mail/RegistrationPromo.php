<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegistrationPromo extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = [
            "name" => $this->data["user"]->name,
            "promo_code" => $this->data["promo"]->code,
            "promo_percentage" => $this->data["promo"]->percentage,
            "promo_end_date" => date_format($this->data["promo"]->end_date, "Y-m-d H:i:s"),
        ];

        return $this->subject("Registration Promo Code")
                    ->view('emails.registration_promo', ['data' => $data]);
    }
}
