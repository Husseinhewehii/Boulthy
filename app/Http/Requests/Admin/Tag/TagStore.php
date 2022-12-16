<?php

namespace App\Http\Requests\Admin\Tag;

use App\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

class TagStore extends FormRequest
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
            "type" => "string",
            "order_column" => "numeric|integer",
            'active' => ['required', ...constant('valid_boolean')],
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
