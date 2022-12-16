<?php

namespace App\Http\Requests\Admin\Product;

use App\Models\Product;
use App\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

class ProductStore extends FormRequest
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
            "category_id" => "required|exists:categories,id",
            "name" => "required|array",
            "description" => "required|array",
            "short_description" => "required|array",
            "price" => "required|numeric|min:0",
            "stock" => "required|integer|min:0",
            "featured" => ['required', ...constant('valid_boolean')],
            'active' => ['required', ...constant('valid_boolean')],
            'tag_ids' => 'array',
            'image' => ["required", ...constant('valid_image')],
            'images' => "array",
        ];
    }

    public function withValidator($validator)
    {
        $translatables = ['name', "short_description", "description"];
        $validator->after(function ($validator) use ($translatables) {
            validate_translatables($validator, $translatables);
            validate_tag_ids($validator, $this->tag_ids);
            validate_images_array($validator, $this->images);
            // validate_model_property_limit($validator, Product::class, 'featured', $this->featured, constant('max_featured_products'));
        });
    }
}
