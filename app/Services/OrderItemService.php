<?php

namespace App\Services;

use App\Models\OrderItem;
use App\Models\Product;

class OrderItemService
{
    protected $orderService;
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function updateCart($request)
    {
        $order = $this->orderService->getOrCreateOrder();
        $orderItem = $this->getOrCreateOrderItem($request, $order);
        $this->updateOrderItem($request, $orderItem);
        $this->orderService->updateOrderTotals($order);
    }

    private function getOrCreateOrderItem($request, $order){
        return $order->orderItems()->where('product_id', $request->product_id)->first() ?? $this->createOrderItem($request, $order);
    }

    private function createOrderItem($request, $order)
    {
        $product = Product::findOrFail($request->product_id);
        $orderItem = new OrderItem();
        $orderItem->product_id = $product->id;
        $orderItem->order_id = $order->id;

        return $orderItem;
    }

    private function updateOrderItem($request, $orderItem){
        $product = $orderItem->product;
        $orderItem->refundProductStock();

        $orderItem->quantity = $request->quantity;
        $orderItem->price = $product->price;
        $orderItem->product_total_discounts = $product->total_discounts;
        $orderItem->total = $product->discounted_price() * $orderItem->quantity;
        $orderItem->save();

        $this->subtractProductStock($orderItem);
    }

    private function subtractProductStock($orderItem){
        $product = $orderItem->product;
        $product->stock -= $orderItem->quantity;
        $product->save();
    }

    public function deleteOrderItem($orderItem){
        $orderItem->refundProductStock();
        $order = $orderItem->order;
        $orderItem->delete();
        $this->orderService->updateOrderTotals($order);
    }

    public function reUpdateCart($cart){
        foreach ($cart as $orderItem) {
            $product = $orderItem->product;
            $orderItem->price = $product->price;
            $orderItem->product_total_discounts = $product->total_discounts;
            $orderItem->total = $product->discounted_price() * $orderItem->quantity;
            $orderItem->save();
            $this->orderService->updateOrderTotalPromos($orderItem->order);
            $this->orderService->updateOrderTotals($orderItem->order);
        }
    }
}
