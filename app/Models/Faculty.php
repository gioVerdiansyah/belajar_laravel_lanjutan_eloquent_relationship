<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Faculty extends Model
{
    use HasFactory;

    public function departement(): HasMany
    {
        return $this->hasMany('App\Models\Departement');
    }

    public function scholar(): HasManyThrough
    {
        return $this->hasManyThrough('App\Models\Scholar', 'App\Models\Departement');
    }
}