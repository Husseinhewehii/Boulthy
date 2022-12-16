<?php

namespace App\Http\Requests\Admin\Blog;

use App\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

class BlogUpdate extends FormRequest
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
            'tag_ids' => 'array',
            'image' => constant('valid_image'),
            'images' => "array",
        ];
    }

    public function withValidator($validator)
    {
        $translatables = ['title', "short_description", "description"];
        $validator->after(function ($validator) use ($translatables) {
            validate_translatables($validator, $translatables);
            validate_tag_ids($validator, $this->tag_ids);
            validate_images_array($validator, $this->images);
        });
    }
}
