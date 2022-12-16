<?php

namespace App\Http\Requests\Admin\Product;

use App\Models\Product;
use App\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

class ProductUpdate extends FormRequest
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
            "description" => "array",
            "short_description" => "array",
            "category_id" => "exists:categories,id",
            "price" => "numeric|min:0",
            "stock" => "integer|min:0",
            'active' => constant('valid_boolean'),
            'tag_ids' => 'array',
            'image' => constant('valid_image'),
            'images' => "array",
            "featured" => constant('valid_boolean'),
        ];
    }

    public function withValidator($validator)
    {
        $translatables = ['name', "short_description", "description"];
        $validator->after(function ($validator) use ($translatables) {
            validate_translatables($validator, $translatables);
            validate_tag_ids($validator, $this->tag_ids);
            validate_images_array($validator, $this->images);
            validate_model_property_limit($validator, Product::class, 'featured', $this->featured, constant('max_featured_products'));
        });
    }
}
