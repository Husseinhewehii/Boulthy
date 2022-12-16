<?php

namespace App\Http\Requests\Admin\District;

use App\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @bodyParam city_id integer required the id of the city record Example: 2
 * @bodyParam name object required the value of District name record Example: {"en": "English article name", "ar": "Arabic article name"}
 * @bodyParam active boolean required the status of article category record
 * @bodyParam price integer required price of District. Example: 500
*/
class StoreDistrict extends FormRequest
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
            "city_id" => "required|exists:cities,id",
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
