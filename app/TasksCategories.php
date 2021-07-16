<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TasksCategories extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    protected $table = 'task_categories';
    protected $fillable = [
        'name',
        'active'
    ];

}
