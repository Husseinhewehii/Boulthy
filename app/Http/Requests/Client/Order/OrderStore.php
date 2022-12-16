<?php

namespace App\Http\Requests\Client\Order;

use App\Models\Product;
use App\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

class OrderStore extends FormRequest
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
            'product_id' => "required|exists:products,id",
            'quantity' => 'required|numeric|max:10'
        ];
    }

    public function withValidator($validator)
    {
        $user = auth()->user();
        $validator->after(function ($validator) use ($user) {
            if($user->addresses()->count() < 1){
                validate_single($validator, "address", "An Address is required");
            }
            if(!$user->isClient()){
                validate_single($validator, "type", "Only a Client can create an order");
            }
        });
    }
}
