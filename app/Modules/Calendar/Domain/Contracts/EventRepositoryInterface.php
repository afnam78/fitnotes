<?php

declare(strict_types=1);

namespace App\Modules\Calendar\Domain\Contracts;

interface EventRepositoryInterface
{
    public function getWorkoutEvents(int $userId): array;
}
