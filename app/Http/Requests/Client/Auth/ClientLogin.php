<?php

namespace App\Http\Requests\Client\Auth;

use App\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @bodyParam email string required client email record Example: andy@dufrense.com
 * @bodyParam password password required must include in uppercase letter , special character, & number
*/

class ClientLogin extends FormRequest
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
            'email' => ['required', ...constant('valid_email')],
            'password' => ['required', ...constant('valid_password')],
        ];
    }
}
