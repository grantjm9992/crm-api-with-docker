<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(string $string, $company_id)
 * @method static create(array $input)
 * @method static find(int $id)
 */
class Channel extends Model
{
    protected $table = 'channel';

    protected $fillable = [
        'companyId',
        'name',
        'active'
    ];
}
