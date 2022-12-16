<?php

namespace App\Http\Requests\Admin\Setting;

use App\Models\Setting;
use App\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingByKey extends FormRequest
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
            "items" => "required|array",
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator){
            $items = $this->items;
            foreach ($items as $key => $text) {
                $keyIsValid = $key == cleanString($key);

                if(!$keyIsValid){
                    validate_single($validator, "key", "Key ($key) Format Is Invalid, no spaces, uppercase or special characters allowed");
                }

                if(!Setting::where('key', $key)->exists()){
                    validate_single($validator, "key", "Key ($key) Doesn't exist");
                }
            }
        });
    }
}
