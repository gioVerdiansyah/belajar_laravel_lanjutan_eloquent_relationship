<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Departement extends Model
{
    use HasFactory;

    public function scholar(): HasMany
    {
        return $this->hasMany('App\Models\Scholar');
    }

    public function faculty(): BelongsToMany
    {
        return $this->belongsToMany('App\Models\Faculty');
    }
}