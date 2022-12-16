<?php

namespace App\Http\Requests\Admin\Discount;

use App\Models\Product;
use App\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @bodyParam name object the value of article name record Example: {"en": "English article name", "ar": "Arabic article name"}
 * @bodyParam product_id integer
 * @bodyParam percentage integer
 * @bodyParam start_date object
 * @bodyParam end_date object
 * @bodyParam active boolean the status of discount record
*/
class DiscountUpdate extends FormRequest
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
            "product_id" => "exists:products,id",
            "name" => ["array"],
            "percentage" => ["numeric", "min:1", "max:100"],
            'start_date' => ["date_format:".constant("valid_date_format"), "after:yesterday"],
            'end_date' => ["date_format:".constant("valid_date_format"), "after:start_date"],
            'active' => [...constant('valid_boolean')],
        ];
    }

    public function withValidator($validator)
    {
        $translatables = ['name', "short_description", "description"];
        $validator->after(function ($validator) use ($translatables) {
            validate_translatables($validator, $translatables);
            validate_tag_ids($validator, $this->tag_ids);
        });
    }
}
