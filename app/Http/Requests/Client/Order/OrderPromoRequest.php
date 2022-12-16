<?php

namespace App\Http\Requests\Client\Order;

use App\Models\Order;
use App\Models\Promo;
use App\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

class OrderPromoRequest extends FormRequest
{
    use ValidationTrait;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "code" => ["required", "in:".valid_inputs(Promo::valid(true)->pluck('code')->toArray())]
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator){
            $user = auth()->user();
            $promo = Promo::valid(true)->where("code", $this->code)->first();
            $order = Order::pending()->owner(auth()->id())->find($this->order->id);

            if(!$order){
                validate_single($validator, "order", "Order Is Invalid");
            }

            if($order && $promo){
                if($order->promos->contains($promo) || $user->promos->contains($promo)){
                    validate_single($validator, "code", "This Promo Has Already Been Used");
                }

                if($promo->user_id && !$promo->belongsToThis($user) && $promo->isExclusive()){
                    validate_single($validator, "code", "This Promo Is Not Available For You");
                }
            }
        });
    }
}
