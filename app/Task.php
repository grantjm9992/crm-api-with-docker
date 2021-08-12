<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends BaseModel
{
    protected $fillable = [
        'title',
        'description',
        'status',
        'user_id',
        'contact_id',
        'company_id',
        'notes',
        'important',
        'starred',
        'completed',
        'order',
        'type'
    ];


    /**
     * Set the user's first name.
     *
     * @param  string  $value
     * @return void
     */
    public function setStartDateAttribute($value)
    {
        $date_time = new \DateTime($value);
        $this->attributes['start_date'] = $date_time->format('Y-m-d H:i:s');
    }


    /**
     * Set the user's first name.
     *
     * @param  string  $value
     * @return void
     */
    public function setEndDateAttribute($value)
    {
        $date_time = new \DateTime($value);
        $this->attributes['end_date'] = $date_time->format('Y-m-d H:i:s');
    }

    public function comments()
    {
        return $this->hasMany(TaskComment::class);
    }

    public function files()
    {
        return $this->hasMany(TaskFile::class);
    }

    public function tags()
    {
        return $this->hasMany(TaskTag::class);
    }

    public function watchers()
    {
        return $this->hasManyThrough(User::class, TaskWatcher::class);
    }

}
