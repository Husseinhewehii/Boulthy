<?php

namespace App\Http\Controllers\Api\Client;

use App\Constants\Payment_Methods;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    public function getPaymentMethods()
    {
        return ok_response(Payment_Methods::getPaymentMethods());
    }
}
