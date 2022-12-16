<?php

namespace App\Http\Requests\Admin\City;

use App\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @bodyParam name object required the value of city name record Example: {"en": "English article name", "ar": "Arabic article name"}
 * @bodyParam active boolean required the status of article category record
 * @bodyParam price integer required price of city. Example: 500
*/
class StoreCity extends FormRequest
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
            "name" => "required",
            "active" => ["required", "boolean"],
            "price" => ["required" , "integer", "numeric", "min:0"],
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
