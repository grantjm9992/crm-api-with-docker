<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskComments extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    protected $table = 'task_comments';
    protected $fillable = [
        'task_id',
        'comment',
        'visible',
        'creator_id'
    ];

}
