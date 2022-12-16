<?php

namespace App\Http\Requests;

use App\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

/**
 * @bodyParam password password required
 * @bodyParam password_confirmation password required must match password
*/
class ChangePassword extends FormRequest
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
            'old_password' => ['required'],
            'password' => ['required', "confirmed", ...constant('valid_password')]
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator){
            if(!Hash::check($this->old_password, auth()->user()->password)){
                validate_single($validator, "old_password", "old password is Incorrect");
            }
            if(Hash::check($this->password, auth()->user()->password)){
                validate_single($validator, "password", "password should not match the old password");
            }
        });
    }
}
