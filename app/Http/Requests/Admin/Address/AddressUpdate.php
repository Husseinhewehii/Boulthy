<?php

namespace App\Http\Requests\Admin\Address;

use App\Models\User;
use App\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

class AddressUpdate extends FormRequest
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
            'user_id' => "in:".valid_inputs(User::client()->pluck('id')->toArray()),
            "title" => "array",
            'address' => constant('valid_description'),
            'active' => constant('valid_boolean'),
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
