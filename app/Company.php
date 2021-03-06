<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Company extends BaseModel
{
    protected $table = 'companies';

    protected $fillable = [
        'name',
        'token'
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function (Model $model) {
            $model->setAttribute('token', Uuid::uuid4());
        });
    }
}
