<?php

namespace Kolgaev\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Record extends Model
{

    use SoftDeletes;

    /**
     * Аттрибуты для массового назначения
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'phone',
    ];

}