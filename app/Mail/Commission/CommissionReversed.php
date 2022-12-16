<?php

namespace App\Mail\Commission;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CommissionReversed extends Mailable
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
        $transaction = $this->data;
        $data = [
            "name" => $transaction->user->name,
            "amount" => $transaction->amount,
            "order_id" => $transaction->order_id,
            "message" => get_static_content("commissionreversedemailmessage"),
        ];
        return $this->subject(get_static_content("commissionreversedemailsubject"))
                    ->view('emails.commission.commission_transaction', ['data' => $data]);
    }
}
