<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\OrderItem\OrderItemRequest;
use App\Http\Resources\Order\OrderResource;
use App\Http\Resources\OrderItem\OrderItemResource;
use App\Models\OrderItem;

use App\Services\OrderItemService;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    protected $orderItemService;

    public function __construct(OrderItemService $orderItemService) {
        $this->orderItemService = $orderItemService;
    }

    public function index()
    {
        return ok_response($this->all());
    }

    public function show(Request $request, OrderItem $orderItem)
    {
        return ok_response(new OrderItemResource($orderItem));
    }

    public function addToCart(OrderItemRequest $request)
    {
        $this->orderItemService->updateCart($request);
        return ok_response($this->all());
    }

    public function deleteFromCart(Request $request, OrderItem $orderItem)
    {
        if(!$orderItem->belongsToThis(auth()->user())){
            return forbidden_response();
        }

        $this->orderItemService->deleteOrderItem($orderItem);
        return ok_response($this->all());
    }

    private function all(){
        $user = auth()->user();
        $cart = $user->cart;

        if(count($cart)){
            $this->orderItemService->reUpdateCart($cart);
            return new OrderResource($user->orders()->pending()->first());
        }
        return $cart;
    }
}
