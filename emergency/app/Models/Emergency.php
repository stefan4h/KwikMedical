<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Emergency extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'caller_name',
        'caller_phone',
        'patient_name',
        'patient_id',
        'nhs_registration_number',
        'location',
        'region',
        'description',
    ];
}
