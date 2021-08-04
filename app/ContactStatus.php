<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class ContactStatus extends BaseModel
{
    protected $table = "contact_type";

    protected $fillable = [
        'company_id',
        'name',
        'active',
        'colour'
    ];

    protected $keyType = 'string';

    public $incrementing = false;

    public static function boot()
    {
        parent::boot();

        static::creating(function (Model $model) {
            $model->setAttribute($model->getKeyName(), Uuid::uuid4());
        });
    }
}
