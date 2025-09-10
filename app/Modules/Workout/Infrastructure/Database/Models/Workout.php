<?php

declare(strict_types=1);

namespace App\Modules\Workout\Infrastructure\Database\Models;

use App\Modules\Exercise\Infrastructure\Database\Models\Exercise;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class Workout extends Model
{
    protected $fillable = [
        'user_id',
        'date',
        'notes'
    ];

    public function exercises(): BelongsTo
    {
        return $this->belongsTo(Exercise::class);
    }
}
