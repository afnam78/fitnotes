<?php

declare(strict_types=1);

namespace App\Modules\Calendar\Application\Results;

use App\Modules\Calendar\Application\DTOs\RegistersByDate\WorkoutDTO;

final class GetRegistersByDateResult
{
    public function __construct(
        public array $registers,
    ) {
    }

    public function toArray(): array
    {
        return array_map(fn (WorkoutDTO $workout) => $workout->toArray(), $this->registers);
    }
}
