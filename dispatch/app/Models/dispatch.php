<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class dispatch extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'patient',
        'emergency',
        'hospital_id',
    ];

    /**
     * Cast attributes to specific types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'patient' => 'array',
        'emergency' => 'array',
    ];
}
