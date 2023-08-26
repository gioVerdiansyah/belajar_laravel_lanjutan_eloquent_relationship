<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Nilai extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo('App\Models\Mahasiswa');
    }
}