<?php

namespace App\Http\Requests\Admin\Role;

use App\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

class RoleStore extends FormRequest
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
            'guard_name' => 'required|in:api',
            'active' => ['required', ...constant('valid_boolean')],
            'permission_ids' => "array",
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            validate_permission_ids($validator, $this->permission_ids);
        });
    }
}
