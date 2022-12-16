<?php

namespace App\Http\Requests;

use App\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @bodyParam token string required
 * @bodyParam password password required
 * @bodyParam password_confirmation password required must match password
*/

class ResetPassword extends FormRequest
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
            'token' => ['required', "exists:password_resets,token"],
            'password' => ['required', "confirmed", ...constant('valid_password')]
        ];
    }
}
