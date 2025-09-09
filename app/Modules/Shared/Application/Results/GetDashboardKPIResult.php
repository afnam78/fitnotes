<?php

declare(strict_types=1);

namespace App\Modules\Shared\Application\Results;

final class GetDashboardKPIResult
{
    public function __construct(
        public int   $workoutsToday,
        public int   $currentWeekSets,
        public float $weeklyVolume,
    ) {
    }
}
