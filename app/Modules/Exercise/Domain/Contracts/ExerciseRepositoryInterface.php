<?php

declare(strict_types=1);

namespace App\Modules\Exercise\Domain\Contracts;

use App\Modules\Exercise\Domain\Entities\Exercise;

interface ExerciseRepositoryInterface
{
    public function create(Exercise $exercise): void;

    public function findByIdAndUserId(int $exerciseId, int $userId): ?Exercise;
}
