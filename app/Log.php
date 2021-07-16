<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $table = "log";

    protected $fillable = [
        "id_user",
        "date",
        "text",
        "detail",
        "created_at",
        "updated_at"
    ];

}
