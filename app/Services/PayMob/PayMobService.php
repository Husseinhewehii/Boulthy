<?php

namespace App\Services\PayMob;

use App\Events\Paymob\PaymobProcessedSuccessfulEvent;
use App\Interfaces\PaymentInterface;
use App\Jobs\SendOrderJob;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class PayMobService implements PaymentInterface
{
    public function getPaymentLink($order)
    {
        $auth_token = $this->getAuthToken();
        $orderResponse = $this->makeOrder($order, $auth_token);
        $paymobPaymentKey = $this->getPaymobPaymentKey($orderResponse);
        return env("PAY_MOB_IFRAME_1").$paymobPaymentKey;
    }

    public function refund($order)
    {
        return $order;
    }

    public function getAuthToken(){
        $response = Http::withHeaders(["content-type" => "application/json"])->post("https://accept.paymobsolutions.com/api/auth/tokens",["api_key" => env('PAYMOB_API_KEY')]);
        return $response->object()->token;
    }

    public function makeOrder($order, $auth_token)
    {
        $orderPayload = $this->prepareOrderPayLoad($order);
        $orderPayload['auth_token'] = $auth_token;
        $response = Http::withHeaders(["content-type" => "application/json"])->post("https://accept.paymobsolutions.com/api/ecommerce/orders", $orderPayload);

        $orderResponse = $orderPayload;
        $orderResponse['order_id'] = strval($response->object()->id);
        $orderResponse["billing_data"] = $this->prepareBillingData($order);

        return $orderResponse;
    }

    public function prepareOrderPayLoad($order){
        $orderPayload["amount_cents"] = $order->final_total*100;
        $orderPayload["merchant_order_id"] = "$order->id"."extrastrinngg12334";

        $orderPayload["items"] = $order->orderItems->toArray();
        $orderPayload["items"] = array_map(function($item){
            $product = Product::find($item['product_id']);
            $newItem['name'] = $product->name;
            $newItem['description'] = $product->description;
            $newItem['amount_cents'] = $item['total']*100;
            $newItem['quantity'] = $item['quantity'];
            return $newItem;
        },$orderPayload["items"]);

        return $orderPayload;
    }

    public function getPaymobPaymentKey($orderData){
        $paymentKeyPayload = $this->preparePaymentKeyPayLoad($orderData);
        $response = Http::withHeaders(["content-type" => "application/json"])->post("https://accept.paymobsolutions.com/api/acceptance/payment_keys", $paymentKeyPayload);
        return $response->object()->token;
    }

    public function preparePaymentKeyPayLoad($orderData){
        $paymentKeyPayload = $orderData;
        $paymentKeyPayload['integration_id'] = env('PAYMOB_INTEGRATION_ID');
        $paymentKeyPayload['currency'] = env('CURRENCY');
        return $paymentKeyPayload;
    }

    public function prepareBillingData($order){
        $orderFullName = $order->name;
        $orderFullNameExploded = explode(" ", $orderFullName);

        $billingData["first_name"] = array_shift($orderFullNameExploded);
        $billingData["last_name"] = array_pop($orderFullNameExploded);

        $billingData["email"] = $order->email;
        $billingData["phone_number"] = $order->phone;

        $billingData["apartment"] = "NA";
        $billingData["floor"] = "NA";
        $billingData["street"] = "NA";
        $billingData["building"] = "NA";
        $billingData["shipping_method"] = "NA";
        $billingData["postal_code"] = "NA";
        $billingData["city"] = "NA";
        $billingData["country"] = "NA";
        $billingData["state"] = "NA";
        return $billingData;
    }
    
}
