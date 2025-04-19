<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Workout extends Model
{
    public function exercises(): HasMany
    {
        return $this->hasMany(Exercise::class);
    }
}
