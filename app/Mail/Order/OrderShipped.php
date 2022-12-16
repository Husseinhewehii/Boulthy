<?php

namespace App\Mail\Order;

use App\Constants\Payment_Methods;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderShipped extends Mailable
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
        $order = $this->data;
        $data = [
            "email" => $order->email,
            "name" => $order->name,
            "address" => $order->address,
            "phone" => $order->phone,
            "order_id" => $order->id,
            "payment_method" => Payment_Methods::getPaymentMethod($order->payment_method),
            "amount" => $order->final_total,
            "message" => get_static_content("ordershippedemailmessage")
        ];

        return $this->subject(get_static_content("ordershippedemailsubject"))
                    ->view('emails.orders.order_status', ['data' => $data]);
    }
}
