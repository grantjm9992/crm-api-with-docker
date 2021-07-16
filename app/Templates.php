<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Templates extends Model
{
    protected $table = "templates";

    protected $fillable = [
        'name',
        'path'
    ];

}
