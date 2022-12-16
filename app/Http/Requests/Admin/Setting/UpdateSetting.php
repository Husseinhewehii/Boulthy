<?php

namespace App\Http\Requests\Admin\Setting;

use App\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSetting extends FormRequest
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
            "group" => "nullable|string",
            "key" => "required|string|exists:settings,key",
            "value" => "required|string",
            "active" => constant("valid_boolean")
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $key = $this->key;
            $keyIsValid = $key == cleanString($key);
            if(!$keyIsValid){
                validate_single($validator, "key", "Key Format Is Invalid, no spaces, uppercase or special characters allowed");
            }

            if($this->group){
                $group = $this->group;
                $groupIsValid = $group == cleanString($group);
                if(!$groupIsValid){
                    validate_single($validator, "group", "Group Format Is Invalid, no spaces, uppercase or special characters allowed");
                }
            }

            if(is_numeric_setting_item($key)){
                validate_numeric_item($validator, $key, $this->value);
            }
        });
    }
}
