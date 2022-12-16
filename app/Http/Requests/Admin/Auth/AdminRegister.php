<?php

namespace App\Http\Requests\Admin\Auth;

use App\Constants\UserTypes;
use App\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

class AdminRegister extends FormRequest
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
            'name' => ['required', ...constant('valid_name')],
            'email' => ['required', "unique:users", ...constant('valid_email')],
            'password' => ['required', ...constant('valid_password'), "confirmed"],
            'type' => 'required|integer|in:'.UserTypes::ADMIN,
            'phone' => ['required', "unique:users", ...constant('valid_phone_number')],
            'active' => ['required', ...constant('valid_boolean')],
        ];
    }
}
