<?php

namespace App\Http\Requests\Admin\Auth;

use App\Constants\UserTypes;
use App\Models\User;
use App\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @bodyParam email string required admin email record Example: super@admin.com
 * @bodyParam type integer required user type must be 0 or 1 which are super-admin or admin respectively
 * @bodyParam password password required must include in uppercase letter , special character, & number
*/

class AdminLogin extends FormRequest
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
            'type' => 'required|integer|in:'.valid_inputs([UserTypes::SUPER_ADMIN, UserTypes::ADMIN]),
        ];
    }

    public function withValidator($validator)
    {
        $user = User::whereEmail($this->email)->first();

        $validator->after(function ($validator) use ($user){
            if(!$user || (!$user->isAdmin() && !$user->isSuperAdmin())){
                validate_single($validator, "email", "Credentials are Incorrect");
            }
        });
    }
}
