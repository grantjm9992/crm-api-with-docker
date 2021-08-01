<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    public static function boot()
    {
        self::creating(function (Model $model) {
            dd($model->attributesToArray());
        });
        parent::boot();
    }
}
