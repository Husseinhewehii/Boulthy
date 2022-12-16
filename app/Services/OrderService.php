<?php

namespace App\Services;

use App\Constants\Order_Statuses;
use App\Interfaces\NotificationInterface;
use App\Interfaces\PaymentInterface;
use App\Models\Order;
use App\Models\Promo;

class OrderService
{
    protected $notificationInterface;
    protected $paymentInterface;
    protected $transactionService;
    protected $walletService;

    public function __construct(
        NotificationInterface $notificationInterface, TransactionService $transactionService,
        PaymentInterface $paymentInterface, WalletService $walletService)
    {
        $this->notificationInterface = $notificationInterface;
        $this->paymentInterface = $paymentInterface;
        $this->transactionService = $transactionService;
        $this->walletService = $walletService;
    }

    public function getOrCreateOrder(){
        return $this->client()->orders()->pending()->first() ?? $this->createOrder();
    }

    private function createOrder()
    {
        $order = new Order();

        $order->status = Order_Statuses::PENDING;
        $order->user_id = $this->client()->id;
        $order->name = $this->client()->name;
        $order->phone = $this->client()->phone;
        $order->email = $this->client()->email;
        $order->address = $this->client()->firstAddress();
        $order->save();

        return $order;
    }

    public function updateOrder($request, $order){
        $order->update($request->validated());

        if(isset($request['city_id']) || isset($request['district_id'])){
            $order->city_price = $order->city->price;
            $order->district_price = $order->district->price;

            $order->fees = $order->city_price + $order->district_price;
            $order->final_total = $order->sub_total + $order->fees;
            $order->save();
        }

        return $order;
    }

    public function addPromoToOrder($request, $order){
        $order = $this->client()->orders()->pending()->findOrFail($order->id);
        $promo = Promo::valid(true)->where("code", $request->code)->first();

        $order->promos()->attach($promo);
        $this->client()->promos()->attach($promo);

        $this->updateOrderTotalPromos($order);
        $this->updateOrderTotals($order);

        return $order;
    }

    public function updateOrderTotals($order){
        $order->total = $order->orderItems()->sum('total');
        $order->sub_total = $order->total - $order->total_discount();
        $order->final_total = $order->sub_total + $order->total_fees();
        $order->save();
    }

    public function updateOrderTotalPromos($order){
        $order->total_promos = $order->validPromos()->sum('percentage');
        $order->save();
    }

    public function cancelOrder($order)
    {
        $this->refundOrderStock($order->orderItems);

        $order->update(['status' => Order_Statuses::CANCELLED]);

        if($order->isCardPayment()){
            $this->refundClient($order);
        }

        $this->notificationInterface->orderCancelled($order);
        $this->walletService->reverseCommissions($order);
    }

    public function sendOrder($order)
    {
        if($order->isCardPayment()){
            $this->transactionService->createSalesTransaction($order);
        }

        $order->update(['status' => Order_Statuses::IN_TRANSIT]);
        $this->notificationInterface->orderInTransit($order);
    }

    public function finalizeOrder($order)
    {
        if($order->isOnDelivery()){
            $this->transactionService->createSalesTransaction($order);
        }

        $order->update(['status' => Order_Statuses::DELIVERED]);

        $this->notificationInterface->orderDelivered($order);
        $this->walletService->addCommissions($order);
    }

    public function shipOrder($order)
    {
        $order->update(['status' => Order_Statuses::SHIPPED]);
        $this->notificationInterface->orderShipped($order);
    }

    public function refundClient($order){
        $order = $this->paymentInterface->refund($order);
        $this->transactionService->createRefundTransaction($order);
    }

    public function refundOrderStock($orderItems){
        foreach ($orderItems as $orderItem) {
            $orderItem->refundProductStock();
        }
    }

    public function getPaymentLink($order){
        $paymentLink = $this->paymentInterface->getPaymentLink($order);
        return $paymentLink;
    }

    private function client(){
        return auth()->user();
    }
}
