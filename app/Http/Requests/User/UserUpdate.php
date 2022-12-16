<?php

namespace App\Http\Requests\User;

use App\Constants\UserTypes;
use App\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdate extends FormRequest
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
            'name' => [...constant('valid_name')],
            'email' => [Rule::unique('users')->ignore($this->user->id, 'id'), ...constant('valid_email')],
            'type' => "integer|in:".valid_inputs(array_keys(UserTypes::getUserTypes())),
            'password' => [...constant('valid_password'), "confirmed"],
            'phone' => [Rule::unique('users')->ignore($this->user->id, 'id'), ...constant('valid_phone_number')],
            'active' => [...constant('valid_boolean')],
            'role_ids' => "array",
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            validate_role_ids($validator, $this->role_ids);
        });
    }
}
