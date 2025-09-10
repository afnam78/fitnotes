<?php

declare(strict_types=1);

namespace App\Modules\WorkoutCategory\Application\Commands;

final readonly class CreateWorkoutCategoryCommand
{
    public function __construct(
        public string  $name,
        public int     $userId,
    ) {
    }
}
