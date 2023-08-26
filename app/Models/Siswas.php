<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Siswas extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function jurusans(): BelongsTo
    {
        return $this->belongsTo("App\Models\Jurusans");
    }
}