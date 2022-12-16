<?php

namespace App\Constants;

final class Order_Statuses{
    const PENDING = 1;
    const IN_TRANSIT = 2;
    const SHIPPED = 3;
    const DELIVERED = 4;
    const CANCELLED = 5;

    public static function getOrderStatuses(){
        return [
            Order_Statuses::PENDING => 'Pending',
            Order_Statuses::IN_TRANSIT => 'In Transit',
            Order_Statuses::SHIPPED => 'Shipped',
            Order_Statuses::DELIVERED => 'Delivered',
            Order_Statuses::CANCELLED => 'Cancelled',
        ];
    }

    public static function getOrderStatus($key = ''){
        return !array_key_exists($key, self::getOrderStatuses()) ? " " : self::getOrderStatuses()[$key];
    }
}
