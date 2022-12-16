<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class OrderItem extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;
    protected $fillable = ["order_id", "product_id", "quantity", "price", "product_total_discounts"];

    //relations
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    //booleans
    public function belongsToThis($user)
    {
        return $this->order->user_id == $user->id;
    }

    //functions
    public function refundProductStock(){
        $product = $this->product;
        $product->stock += $this->quantity;
        $product->save();
    }
}
