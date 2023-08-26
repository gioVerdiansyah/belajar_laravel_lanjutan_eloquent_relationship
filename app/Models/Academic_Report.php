<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Academic_Report extends Model
{
    use HasFactory;

    public function grade(): BelongsTo
    {
        return $this->belongsTo('App\Models\Grade');
    }

    // ! Belongs to Through
    use \Znck\Eloquent\Traits\BelongsToThrough;
    public function student()
    {
        return $this->belongsToThrough('App\Models\Student', 'App\Models\Grade');
    }
}