<?php

namespace App\Http\Requests\Admin\Promos;

use App\Constants\PromoTypes;
use App\Models\User;
use App\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PromoUpdate extends FormRequest
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
            "name" => "array",
            "name" => "required|array",
            "description" => "required|array",
            "short_description" => "required|array",
            "percentage" => [ "numeric", "min:1", "max:100"],
            'start_date' => ["date_format:".constant("valid_date_format")],
            'end_date' => ["date_format:".constant("valid_date_format"), "after:start_date"],
            'code' => ['required', "regex:".constant("valid_promo_regex"), Rule::unique('promos')->ignore($this->promo->id, 'id')],
            'active' => constant('valid_boolean'),
            'type' => "in:".valid_inputs(array_keys(PromoTypes::getPromoTypes())),
            'user_id' => "in:".valid_inputs(User::client()->pluck("id")->toArray()),
        ];
    }

    public function withValidator($validator)
    {
        $translatables = ['name', "short_description", "description"];
        $validator->after(function ($validator) use ($translatables) {
            validate_translatables($validator, $translatables);
        });
    }

    public function messages()
    {
        return [
            "code.regex" => constant("promo_regex_message")
        ];
    }
}
