<?php

namespace App\Http\Requests\Client\JobApplication;

use App\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

class StoreJobApplication extends FormRequest
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
            'name' => ['required', ...constant('valid_name')],
            'email' => ['required', ...constant('valid_email')],
            'phone' => ['required', ...constant('valid_phone_number')],
            'note' => constant('valid_note'),
            'vacancy_id' => "required|exists:vacancies,id",
            'cv' => constant('valid_cv'),
        ];
    }
}
