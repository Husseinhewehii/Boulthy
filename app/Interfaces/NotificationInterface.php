<?php

namespace App\Interfaces;


interface NotificationInterface{
    public function orderInTransit($order);
    public function orderShipped($order);
    public function orderDelivered($order);
    public function orderCancelled($order);
    public function commissionAdded($transaction);
    public function commissionReversed($transaction);
    public function registrationPromo($data);
}
