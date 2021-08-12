<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Roles extends BaseModel
{

    protected $table = "roles";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];
}
