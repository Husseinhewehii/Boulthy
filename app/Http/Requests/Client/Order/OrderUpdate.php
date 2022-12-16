<?php

namespace App\Http\Requests\Client\Order;

use App\Constants\Payment_Methods;
use App\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;
 /**
 * @bodyParam full_name string  Example: andy
 * @bodyParam email string client email Example: andy@dufrense.com
 * @bodyParam phone string client phone Example: 0123123123
 * @bodyParam note string Example: deliver quick
 * @bodyParam address string Example: 19 street X, sydney
 * @bodyParam payment_method integer payment type must be 1 or 2 or 3 which are card_paymebt or cash on delivery or card on delivery respectively
 * @bodyParam city_id integer the id of the city record
 * @bodyParam district_id integer required if city_id exists the id of the district record
*/
class OrderUpdate extends FormRequest
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
            "full_name" => constant("valid_name"),
            "phone" => constant("valid_phone_number"),
            "email" => constant("valid_email"),
            "note" => constant("valid_note"),
            "address" => constant("valid_address"),
            "payment_method" => "numeric|in:".valid_inputs(Payment_Methods::getPaymentMethodsValues()),
            "city_id" => "exists:cities,id",
            "district_id" => "required_with:city_id|exists:districts,id",
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if(!auth()->user()->orders()->pending()->where('id', $this->order->id)->exists()){
                validate_single($validator, "order", "You Cannot Proceed With This Order");
            }
        });
    }
}
