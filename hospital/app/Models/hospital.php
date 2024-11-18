<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class hospital extends Model
{
    protected $fillable = [
        'region',
        'specialty',
    ];

    /**
     * Get all incidents related to this hospital.
     */
    public function incidents()
    {
        return $this->hasMany(Incident::class)->orderBy('created_at', 'desc');
    }
}
