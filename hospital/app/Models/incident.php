<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class incident extends Model
{
    protected $fillable = [
        'patient',
        'emergency',
        'ambulance',
        'hospital_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'patient' => 'array',
        'emergency' => 'array',
        'ambulance' => 'array',
    ];

    /**
     * Get the hospital associated with this incident.
     */
    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }
}
