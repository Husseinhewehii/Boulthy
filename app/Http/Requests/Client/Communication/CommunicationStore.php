<?php

namespace App\Http\Requests\Client\Communication;

use App\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

class CommunicationStore extends FormRequest
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
            "name" => ["required", ...constant('valid_name')],
            "email" => ["required", ...constant('valid_email')],
            "subject" => ["required"],
            "message" => ["required", ...constant('valid_description')],
        ];
    }
}
