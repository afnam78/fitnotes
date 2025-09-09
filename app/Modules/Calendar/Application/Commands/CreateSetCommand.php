<?php

declare(strict_types=1);

namespace App\Modules\Calendar\Application\Commands;

use Illuminate\Support\Carbon;

final readonly class CreateSetCommand
{
    public function __construct(
        public int    $exerciseId,
        public int    $reps,
        public float  $weight,
        public int    $userId,
        public Carbon $date,
    ) {
    }
}
