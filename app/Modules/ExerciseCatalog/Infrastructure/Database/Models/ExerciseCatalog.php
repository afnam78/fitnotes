<?php

declare(strict_types=1);

namespace App\Modules\ExerciseCatalog\Infrastructure\Database\Models;

use App\Modules\Set\Infrastructure\Database\Models\Set;
use App\Modules\WorkoutCategory\Infrastructure\Database\Models\WorkoutCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class ExerciseCatalog extends Model
{
    protected $guarded = [];
    public function workoutCategory(): BelongsTo
    {
        return $this->belongsTo(WorkoutCategory::class);
    }

    public function sets(): HasMany
    {
        return $this->hasMany(Set::class);
    }
}
