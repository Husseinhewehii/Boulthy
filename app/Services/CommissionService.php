<?php

namespace App\Services;

use App\Models\Commission;

class CommissionService
{
    public function createCommission($order, $associate)
    {
        $commission = new Commission();
        $commission->order_id = $order->id;
        $commission->user_id = $associate->id;
        $commission->amount = $order->final_total * get_setting("associatecommissionpercentage") / 100;
        $commission->save();
        return $commission;
    }
}
