<?php

namespace App\Http\Requests\Admin\Category;

use App\Models\Category;
use App\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

class CategoryStore extends FormRequest
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
            "name" => "required",
            "parent_id" => "exists:categories,id",
            "active" => ['required', ...constant('valid_boolean')]
        ];
    }

    public function withValidator($validator)
    {
        $translatables = ['name'];
        $validator->after(function ($validator) use ($translatables) {
            validate_translatables($validator, $translatables);
        });
    }
}
