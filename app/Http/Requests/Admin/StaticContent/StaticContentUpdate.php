<?php

namespace App\Http\Requests\Admin\StaticContent;

use App\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

class StaticContentUpdate extends FormRequest
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
            "group" => "required|string",
            "key" => "required|string",
            "text" => "required|array",
        ];
    }

    public function withValidator($validator)
    {
        $translatables = ['text'];

        $keyIsValid = $this->key == cleanString($this->key);
        $groupIsValid = $this->group == cleanString($this->group);

        $validator->after(function ($validator) use ($keyIsValid, $groupIsValid, $translatables) {
            validate_translatables($validator, $translatables);

            if(!$groupIsValid){
                validate_single($validator, "group", "Group Format Is Invalid, no spaces, uppercase or special characters allowed");
            }

            if(!$keyIsValid){
                validate_single($validator, "key", "Key Format Is Invalid, no spaces, uppercase or special characters allowed");
            }
        });
    }
}


