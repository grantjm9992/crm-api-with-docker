<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Str;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class User extends Authenticatable
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasApiTokens, Notifiable;

    protected $table = "users";
    protected $keyType = 'string';

    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();

        static::creating(function (Model $model) {
            $model->setAttribute($model->getKeyName(), Uuid::uuid4());
            $model->setAttribute('api_token', Uuid::uuid4());
            if ($model->getAttribute('password') !== null) {
                $model->setAttribute('password', md5($model->getAttribute('password')));
            }
        });

        static::updating(function (Model $model) {
            if ($model->getAttribute('password') !== null) {
                $model->setAttribute('password', md5($model->getAttribute('password')));
            }
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'surname',
        'surname2',
        'phone',
        'mobile',
        'role_id',
        'company_id',
        'api_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function generateToken()
    {
        $this->api_token = Str::random(60);
        $this->save();

        return $this->api_token;
    }

    public function role()
    {
        return $this->hasOne(\App\Role::class);
    }

    public function company()
    {
        return $this->belongsTo(\App\Company::class);
    }
}
