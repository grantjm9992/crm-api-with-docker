<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskStatus extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    protected $table = 'task_status';
    protected $fillable = [
        'status',
        'text_colour',
        'background_colour',
        'order',
    ];
}
