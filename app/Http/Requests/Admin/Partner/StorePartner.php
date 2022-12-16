<?php

namespace App\Http\Requests\Admin\Partner;

use App\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

class StorePartner extends FormRequest
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
            'image' => ["required", ...constant('valid_image')],
            'active' => ['required', ...constant('valid_boolean')],
        ];
    }
}
