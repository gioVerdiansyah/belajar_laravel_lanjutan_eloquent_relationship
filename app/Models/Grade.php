<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Grade extends Model
{
    use HasFactory;

    public function student(): BelongsTo
    {
        return $this->belongsTo('App\Models\Student');
    }

    public function academicReport(): HasOne
    {
        return $this->hasOne('App\Models\Academic_Report');
    }
}