<?php

namespace App\Interfaces;


interface PaymentInterface{
    public function getPaymentLink($order);
    public function refund($order);
}
