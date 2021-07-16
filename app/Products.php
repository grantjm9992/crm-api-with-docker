<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Products extends Model
{

    protected $table = "products";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'price',
        'tax_rate',
        'sku',
    ];

    public function tags()
    {
        return $this->hasMany(ProductTags::class);
    }

    public function categories()
    {
        return $this->hasManyThrough(ProductCategories::class, ProductsCategories::class);
    }

    public function images()
    {
        return $this->hasMany(ProductsImages::class);
    }
    
}
