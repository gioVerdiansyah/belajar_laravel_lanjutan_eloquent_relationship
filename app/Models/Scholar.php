<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Scholar extends Model
{
    use HasFactory;

    public function departement(): BelongsToMany
    {
        return $this->belongsToMany('App\Models\Departement');
    }
}