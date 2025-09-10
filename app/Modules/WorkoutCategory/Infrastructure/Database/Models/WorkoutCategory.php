<?php

declare(strict_types=1);

namespace App\Modules\WorkoutCategory\Infrastructure\Database\Models;

use App\Modules\ExerciseCatalog\Infrastructure\Database\Models\ExerciseCatalog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class WorkoutCategory extends Model
{
    protected $fillable = [
        'name',
        'user_id',
    ];

    public function exerciseCatalogs(): HasMany
    {
        return $this->hasMany(ExerciseCatalog::class);
    }
}
