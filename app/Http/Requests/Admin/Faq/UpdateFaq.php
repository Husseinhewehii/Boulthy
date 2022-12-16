<?php

namespace App\Http\Requests\Admin\Faq;

use App\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

class UpdateFaq extends FormRequest
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
            "question" => "array",
            "answer" => "array",
            "active" => constant('valid_boolean')
        ];
    }

    public function withValidator($validator)
    {
        $translatables = ['question', 'answer'];
        $validator->after(function ($validator) use ($translatables) {
            validate_translatables($validator, $translatables);
        });
    }
}
