<?php

namespace App\Http\Requests\Client\Auth;

use App\Constants\UserTypes;
use App\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @bodyParam name string required client first name record Example: andy
 * @bodyParam email string required client email must be unique Example: andy@dufrense.com
 * @bodyParam phone string required client phone must be unique Example: 0123123123
 * @bodyParam password password required must include in uppercase letter , special character, & number
 * @bodyParam password_confirmation password required must match password
 * @bodyParam active boolean required the status of user
 * @bodyParam type integer required user type must be 2 which is client
*/

class ClientRegister extends FormRequest
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
            'type' => 'required|integer|in:'.UserTypes::CLIENT,
            'phone' => ['required', "unique:users", ...constant('valid_phone_number')],
            'active' => ['required', ...constant('valid_boolean')],
        ];
    }
}
