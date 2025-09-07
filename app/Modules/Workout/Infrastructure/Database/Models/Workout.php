<?php

declare(strict_types=1);

namespace App\Modules\Workout\Infrastructure\Database\Models;

use App\Modules\Exercise\Infrastructure\Database\Models\Exercise;
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
