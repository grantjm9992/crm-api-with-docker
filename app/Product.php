<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'product_type_id',
        'product_status'
    ];

    public function categories(): HasManyThrough
    {
        return $this->hasManyThrough(ProductCategories::class, 'products_product_categories', 'product_id', 'product_category_id');
    }

}
