<?php

declare(strict_types=1);

namespace App\Modules\Set\Infrastructure\Database\Models;

use App\Modules\Exercise\Infrastructure\Database\Models\Exercise;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class Set extends Model
{
    protected $guarded = [];
    public function exercise(): BelongsTo
    {
        return $this->belongsTo(Exercise::class);
    }
}
