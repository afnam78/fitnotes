<?php

declare(strict_types=1);

namespace App\Modules\Exercise\Infrastructure\Database\Models;

use App\Models\Set;
use App\Modules\Workout\Infrastructure\Database\Models\Workout;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class Exercise extends Model
{
    protected $guarded = [];
    public function workout(): BelongsTo
    {
        return $this->belongsTo(Workout::class);
    }

    public function sets(): HasMany
    {
        return $this->hasMany(Set::class);
    }
}
