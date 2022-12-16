<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Translatable\HasTranslations;

class Category extends Model
{
    use HasFactory, HasTranslations, SoftDeletes, LogsActivity;

    protected $fillable = ["name", "active", "parent_id"];
    public $translatable = ["name"];

    //relations
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function all_products($all_products = [])
    {
        $all_products = array_merge($this->products()->pluck('id')->toArray(), $all_products);
        if($this->hasChildren()){
            foreach ($this->children as $child) {
                $all_products = $child->all_products($all_products);
            }
        }
        return $all_products;
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, "parent_id");
    }

    public function children()
    {
        return $this->hasMany(Category::class, "parent_id", "id");
    }

    //scopes
    public function scopeRoot($query, $root)
    {
        return $query->where("parent_id", null);
    }

    //boolean
    public function hasChildren()
    {
        return $this->children()->count();
    }

    public static function boot() {
        parent::boot();

        static::deleting(function($category) {
             $category->products()->delete();
        });
    }

}
