<?php

namespace App\Modules\Workout\Application\Results;

readonly class GetWorkoutDetailsResult
{
    public function __construct(
        public int    $id,
        public string $name,
        public string $description,
    ) {
    }
}
