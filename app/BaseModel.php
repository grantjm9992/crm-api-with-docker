<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class BaseModel extends Model
{
    protected $keyType = 'string';
    public $incrementing = false;

    public static function boot()
    {
        self::creating(function (Model $model) {
            $model->setAttribute($model->getKeyName(), Uuid::uuid4());
        });
        parent::boot();
    }
}
