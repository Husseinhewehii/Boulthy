<?php

namespace App\Http\Requests\Client\Order;

use App\Constants\Payment_Methods;
use App\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

 /**
 * @bodyParam full_name string receiver full name Example: andy
 * @bodyParam email string receiver email Example: andy@dufrense.com
 * @bodyParam phone string receiver phone Example: 0123123123
 * @bodyParam address string receiver address Example: 19 street X, sydney
 * @bodyParam city_id integer
 * @bodyParam district_id integer required if city_id exists
 * @bodyParam payment_method integer payment type must be 1 or 2 or 3 which are card_paymebt or cash on delivery or card on delivery respectively
*/
class CheckoutRequest extends FormRequest
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
            "address" => [ ...constant("valid_address")],
            'full_name' => [ ...constant('valid_name')],
            'email' => [ ...constant('valid_email')],
            'phone' => [ ...constant('valid_phone_number')],
            "city_id" => "exists:cities,id",
            "district_id" => "required_with:city_id|exists:districts,id",
            "payment_method" => "numeric|in:".valid_inputs(Payment_Methods::getPaymentMethodsValues()),
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if(!auth()->user()->orders()->pending()->where('id', $this->order->id)->exists()){
                validate_single($validator, "order", "You Cannot Proceed With This Order");
            }

            if(!$this->address && $this->order->address == "no address"){
                validate_single($validator, "order", "Order Must Have An Address");
            }

            if(!$this->city_id && $this->order->city_id == 0){
                validate_single($validator, "order", "Order Must Have A City ID");
            }

            if(!$this->district_id && $this->order->district_id == 0){
                validate_single($validator, "order", "Order Must Have A District ID");
            }
        });
    }
}
