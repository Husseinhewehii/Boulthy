<?php

namespace App\Http\Requests\Admin\Partition;

use App\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @bodyParam title object the value of partition title record Example: {"en": "English partition title", "ar": "Arabic partition title"}
 * @bodyParam active boolean the status of partition record
 * @bodyParam photo file The image of the article. Maximum size is 5MB and allowed types are JPG, JPEG, PNG.
*/
class UpdatePartition extends FormRequest
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
            "title" => "array",
            "group" => constant("valid_name"),
            'photo' => constant('valid_image'),
            "active" => "boolean",
        ];
    }

    public function withValidator($validator)
    {
        $translatables = ['title'];

        $validator->after(function ($validator) use ($translatables) {
            validate_translatables($validator, $translatables);
        });
    }
}
