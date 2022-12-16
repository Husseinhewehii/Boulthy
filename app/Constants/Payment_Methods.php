<?php

namespace App\Constants;

final class Payment_Methods{
    const CARD_PAYMENT = 1;
    const CASH_ON_DELIVERY = 2;
    const CARD_ON_DELIVERY = 3;

    public static function getPaymentMethods(){
        return [
            Payment_Methods::CARD_PAYMENT => 'Card Payment',
            Payment_Methods::CASH_ON_DELIVERY => 'Cash On Delivery',
            Payment_Methods::CARD_ON_DELIVERY => 'Card On Delivery',
        ];
    }

    public static function getPaymentMethodsValues(){
        return array_keys(self::getPaymentMethods());
    }

    public static function getPaymentMethod($key = ''){
        return !array_key_exists($key, self::getPaymentMethods()) ? " " : self::getPaymentMethods()[$key];
    }
}
