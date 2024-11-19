<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ambulance extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'region',
        'name',
        'gps_location',
        'on_call',
    ];

    protected $casts = [
        'on_call' => 'boolean',
    ];
}
