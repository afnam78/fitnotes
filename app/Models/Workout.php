<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class Workout extends Model
{
    protected $guarded = [];

    public function exercises(): HasMany
    {
        return $this->hasMany(Exercise::class);
    }
}
