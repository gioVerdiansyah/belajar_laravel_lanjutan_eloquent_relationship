<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Znck\Eloquent\Relations\BelongsToThrough;

class Student extends Model
{
    use HasFactory;

    public function grade(): HasOne
    {
        return $this->hasOne('App\Models\Grade');
    }

    public function academicReport(): HasOneThrough
    {
        return $this->hasOneThrough('App\Models\Academic_Report', 'App\Models\Grade');
        // Tabel apa yang ingin dituju, dan tabel yang menjadi perantaranya
    }
}