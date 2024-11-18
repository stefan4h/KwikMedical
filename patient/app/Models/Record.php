<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<string, string>
     */
    protected $fillable = [
        'patient_id',
        'what',
        'when',
        'where',
        'actions_taken',
        'time_on_call',
    ];

    /**
     * The patient this record belongs to.
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
