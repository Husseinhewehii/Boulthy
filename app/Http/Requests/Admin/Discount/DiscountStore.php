<?php

namespace App\Http\Requests\Admin\Discount;

use App\Models\Product;
use App\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @bodyParam name object required the value of article name record Example: {"en": "English article name", "ar": "Arabic article name"}
 * @bodyParam product_id integer required
 * @bodyParam percentage integer required
 * @bodyParam start_date object required
 * @bodyParam end_date object required
 * @bodyParam active boolean required the status of discount record
*/
class DiscountStore extends FormRequest
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
            "product_id" => "required|exists:products,id",
            "name" => ["required", "array"],
            "percentage" => ["required", "numeric", "min:1", "max:100"],
            'start_date' => ['required', "date_format:".constant("valid_date_format"), "after:yesterday"],
            'end_date' => ['required', "date_format:".constant("valid_date_format"), "after:start_date"],
            'active' => ['required', ...constant('valid_boolean')],
        ];
    }

    public function withValidator($validator)
    {
        $translatables = ['name'];
        $validator->after(function ($validator) use ($translatables) {
            validate_translatables($validator, $translatables);
        });
    }
}
