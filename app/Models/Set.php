<?php

declare(strict_types=1);

namespace App\Models;

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
