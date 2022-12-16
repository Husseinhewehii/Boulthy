<?php

namespace App\Http\Requests\Client\Address;

use App\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

class AddressStore extends FormRequest
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
            'user_id' => "required|in:".auth()->id(),
            "title" => "required|array",
            'address' => ["required", ...constant('valid_description')],
            'active' => ["required", ...constant('valid_boolean')],
        ];
    }

    public function withValidator($validator)
    {
        $translatables = ['title'];
        $validator->after(function ($validator) use ($translatables) {
            validate_translatables($validator, $translatables);
        });
    }
}
