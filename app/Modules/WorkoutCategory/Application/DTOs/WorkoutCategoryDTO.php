<?php

declare(strict_types=1);

namespace App\Modules\WorkoutCategory\Application\DTOs;

final class WorkoutCategoryDTO
{
    public function __construct(
        public int $id,
        public string $name,
    ) {
    }
}
