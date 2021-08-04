<?php

declare(strict_types=1);

namespace App;

class Campaigns extends BaseModel
{
    protected $table = 'campaign';
    protected $fillable = [
        'name',
        'company_id',
        'active'
    ];
}
