<?php

namespace App\Services;

use App\Interfaces\EmailInterface;
use App\Interfaces\NotificationInterface;
use App\Mail\Commission\CommissionReversed;
use App\Mail\CommissionAdded;
use App\Mail\Order\OrderCancelled;
use App\Mail\Order\OrderDelivered;
use App\Mail\Order\OrderInTransit;
use App\Mail\Order\OrderShipped;
use App\Mail\RegistrationPromo;

class NotificationService implements NotificationInterface
{
    protected $emailInterface;

    public function __construct(EmailInterface $emailInterface) {
        $this->emailInterface = $emailInterface;
    }

    public function orderInTransit($order)
    {
        $this->emailInterface->sendEmail($order->user->email, OrderInTransit::class, $order);
    }

    public function orderShipped($order)
    {
        $this->emailInterface->sendEmail($order->user->email, OrderShipped::class, $order);
    }

    public function orderDelivered($order)
    {
        $this->emailInterface->sendEmail($order->user->email, OrderDelivered::class, $order);
    }

    public function orderCancelled($order)
    {
        $this->emailInterface->sendEmail($order->user->email, OrderCancelled::class, $order);
    }

    public function commissionAdded($transaction)
    {
        $this->emailInterface->sendEmail($transaction->user->email, CommissionAdded::class, $transaction);
    }

    public function commissionReversed($transaction)
    {
        $this->emailInterface->sendEmail($transaction->user->email, CommissionReversed::class, $transaction);
    }

    public function registrationPromo($data)
    {
        $user = $data['user'];
        $this->emailInterface->sendEmail($user->email, RegistrationPromo::class, $data);
    }
}
