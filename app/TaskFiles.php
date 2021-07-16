<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskFiles extends Model
{
    protected $table = 'task_files';
    protected $fillable = [
        'task_id',
        'file_path',
        'visible',
        'creator_id'
    ];

}
