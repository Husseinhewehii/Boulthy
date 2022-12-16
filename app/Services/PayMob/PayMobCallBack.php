<?php

namespace App\Services\PayMob;

use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;

class PayMobCallBack
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function processedCallback(Request $request)
    {
        $data = $request->all();
        if($this->validateHMAC($data)){
            if(isset($data['obj']['order']['merchant_order_id'])){
                $order = Order::findOrFail(rtrim($data['obj']['order']['merchant_order_id'], "extrastrinngg12334"));
                $this->orderService->sendOrder($order);
                return ok_response();
            }
        }
        return forbidden_response();

    }

    private function validateHMAC($data)
    {
        $hmac = $data["hmac"];
        $concatenatedString = $this->prepareConcatenatedString($data);
        $secret = env("PAYMOB_HMAC");
        $hashed = hash_hmac("sha512", $concatenatedString, $secret);

        return $hashed == $hmac;
    }

    private function prepareConcatenatedString($data){
        $obj = $data['obj'];
        $items["amount_cents"] = $obj["amount_cents"];
        $items["created_at"] = $obj["created_at"];
        $items["currency"] = $obj["currency"];
        $items["error_occured"] = $obj["error_occured"];
        $items["has_parent_transaction"] = $obj["has_parent_transaction"];
        $items["id"] = $obj["id"];
        $items["integration_id"] = $obj["integration_id"];
        $items["is_3d_secure"] = $obj["is_3d_secure"];
        $items["is_auth"] = $obj["is_auth"];
        $items["is_capture"] = $obj["is_capture"];
        $items["is_refunded"] = $obj["is_refunded"];
        $items["is_standalone_payment"] = $obj["is_standalone_payment"];
        $items["is_voided"] = $obj["is_voided"];
        $items["order.id"] = $obj["order"]['id'];
        $items["owner"] = $obj["owner"];
        $items["pending"] = $obj["pending"];
        $items["source_data.pan"] = $obj["source_data"]['pan'];
        $items["source_data.sub_type"] = $obj["source_data"]['sub_type'];
        $items["source_data.type"] = $obj["source_data"]['type'];
        $items["success"] = $obj["success"];
        return implode("", array_map(function($item){ return is_bool($item) ? var_export($item, true) : $item; }, $items));
    }

}
