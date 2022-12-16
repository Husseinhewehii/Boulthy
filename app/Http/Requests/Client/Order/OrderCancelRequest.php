<?php

namespace App\Http\Requests\Client\Order;

use App\Models\Order;
use App\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

class OrderCancelRequest extends FormRequest
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

        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if(!auth()->user()->orders()->cancellable()->where('id', $this->order->id)->exists()){
                validate_single($validator, "order", "You Cannot Cancel This Order");
            }
        });
    }
}
