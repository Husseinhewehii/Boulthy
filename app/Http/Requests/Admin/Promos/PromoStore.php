<?php

namespace App\Http\Requests\Admin\Promos;

use App\Constants\PromoTypes;
use App\Models\User;
use App\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

class PromoStore extends FormRequest
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
            "name" => "required|array",
            "description" => "required|array",
            "short_description" => "required|array",
            "percentage" => ["required", "numeric", "min:1", "max:100"],
            'start_date' => ['required', "date_format:".constant("valid_date_format"), "after:yesterday"],
            'end_date' => ['required', "date_format:".constant("valid_date_format"), "after:start_date"],
            'code' => ['required', "regex:".constant("valid_promo_regex"), "unique:promos"],
            'active' => ['required', ...constant('valid_boolean')],
            'type' => ['required', "in:".valid_inputs(array_keys(PromoTypes::getPromoTypes()))],
            'user_id' => ["required_if:type,".PromoTypes::EXCLUSIVE.",".PromoTypes::ASSOCIATE, "in:".valid_inputs(User::client()->pluck("id")->toArray())],
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
            "code.regex" => constant("promo_regex_message"),
            "user_id.required_if" => "User ID Is required if Type is Exclusive Or Associate"
        ];
    }
}
