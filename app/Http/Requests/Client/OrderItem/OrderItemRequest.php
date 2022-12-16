<?php

namespace App\Http\Requests\Client\OrderItem;

use App\Models\Product;
use App\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class OrderItemRequest extends FormRequest
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
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|numeric|min:1|max:'.DB::table('products')->where('id', $this->product_id)->value('stock')
        ];
    }

    public function withValidator($validator)
    {
        $user = auth()->user();
        $validator->after(function ($validator) use ($user) {
            if(!$user->isClient()){
                validate_single($validator, "type", "Only a Client Can Add To Cart");
            }
        });
    }
}
