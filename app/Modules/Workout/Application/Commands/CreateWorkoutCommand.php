<?php

declare(strict_types=1);

namespace App\Modules\Workout\Application\Commands;

final readonly class CreateWorkoutCommand
{
    public function __construct(
        public string  $name,
        public int     $userId,
        public ?string $description = null,
    ) {
    }
}
