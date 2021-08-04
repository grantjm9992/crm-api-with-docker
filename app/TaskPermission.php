<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskPermission extends Model
{
    protected $table = 'task_permission';
    protected $fillable = [
        'permission'
    ];
}
