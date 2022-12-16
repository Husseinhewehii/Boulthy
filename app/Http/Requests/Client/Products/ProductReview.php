<?php

namespace App\Http\Requests\Client\Products;

use App\Constants\UserTypes;
use App\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @bodyParam rating string required must be range from 1 to 5 .Example: 1
 * @bodyParam type integer required user type must be 2 which is client
 * @bodyParam review string must be at 5 characters min and 500 max.  Example: very good product
*/
class ProductReview extends FormRequest
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
            "rating" => ["required", ...constant('valid_rating')],
            "review" => [...constant('valid_comment')],
            'type' => 'required|numeric|in:'.UserTypes::CLIENT,
        ];
    }
}
