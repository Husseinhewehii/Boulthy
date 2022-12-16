<?php

namespace App\Http\Requests\Admin\Vacancy;

use App\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

class UpdateVacancy extends FormRequest
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
            "title" => "array",
            "description" => "array",
            "short_description" => "array",
            'active' => constant('valid_boolean'),
        ];
    }

    public function withValidator($validator)
    {
        $translatables = ['name', "short_description", "description"];
        $validator->after(function ($validator) use ($translatables) {
            validate_translatables($validator, $translatables);
        });
    }
}
