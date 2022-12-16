<?php

namespace App\Http\Requests\Admin\Partner;

use App\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePartner extends FormRequest
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
            'image' => constant('valid_image'),
            'active' => constant('valid_boolean'),
        ];
    }
}
