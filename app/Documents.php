<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Documents extends Model
{
    protected $table = "templates";

    protected $fillable = [
        'name',
        'path',
        'document_type'
    ];

}
