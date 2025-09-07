<?php

declare(strict_types=1);

namespace App\Modules\Workout\Application\Results;

final readonly class GetWorkoutDetailsResult
{
    public function __construct(
        public int    $id,
        public string $name,
        public ?string $description = null,
    ) {
    }
}
