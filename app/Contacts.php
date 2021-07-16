<?php

namespace App;

use DateTime;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Contacts extends Model
{
    protected $fillable = [
        'company_id',
        'name',
        'surname',
        'email',
        'phone',
        'mobile',
        'contact_type_id',
        'channel_id',
        'campaign_id',
        'assigned_to_id',
        'contact_status_id',
        'date_attended',
        'date',
        'notes'
    ];
    
    protected $keyType = 'string';

    public $incrementing = false;

    public function tasks()
    {
        return $this->hasMany(Task::class, 'contact_id')->orderBy('order');;
    }

    public function setDateAttribute($value)
    {
        $date = new DateTime($value);
        $this->attributes['date'] = $date->format('Y-m-d H:i:s');
    }
    
    protected static function boot()
    {
        parent::boot();

        static::creating(function (Model $model) {
            $model->setAttribute($model->getKeyName(), Uuid::uuid4());
        });
    }

}
