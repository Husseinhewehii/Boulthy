<?php

namespace App\Http\Requests\Admin\PageHeader;

use App\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @bodyParam photo file The image of the page header. Maximum size is 5MB and allowed types are JPG, JPEG, PNG.
*/
class UpdatePageHeader extends FormRequest
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

    public function rules()
    {
        return [
            'photo' => constant('valid_image'),
        ];
    }
}
