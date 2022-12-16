<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @bodyParam email string required email record Example: andy@dufrense.com
*/

class ResetPasswordLink extends FormRequest
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
            "email" => "required|in:".valid_inputs(User::pluck('email')->toArray())
        ];
    }
}
