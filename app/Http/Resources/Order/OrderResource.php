<?php

namespace App\Http\Resources\Order;

use App\Constants\Order_Statuses;
use App\Http\Resources\OrderItem\OrderItemResource;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "created_at" => $this->created_at,
            "status" => Order_Statuses::getOrderStatus($this->status),
            "total" => $this->total,
            "total_promos" => $this->total_promos,
            "sub_total" => $this->sub_total,
            "final_total" => $this->final_total,
            "address" => $this->address,
            "payment_method" => $this->payment_method,
            "fees" => $this->total_fees(),
            "city_id" => $this->city_id,
            "city_price" => $this->city_price,
            "district_id" => $this->district_id,
            "district_price" => $this->district_price,
            "quantity" => array_sum(array_map(function($item){
                return $item['quantity'];
            },$this->orderItems()->get()->toArray())),
            "items" => OrderItemResource::collection($this->orderItems()->paginate(10))
        ];
    }
}
