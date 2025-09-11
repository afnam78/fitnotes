<?php

declare(strict_types=1);

namespace App\Modules\Exercise\Domain\Contracts;

use App\Modules\Exercise\Domain\Aggregates\ExerciseList;
use App\Modules\Exercise\Domain\Entities\Exercise;

interface ExerciseRepositoryInterface
{
    public function create(Exercise $exercise): void;

    public function findByIdAndUserId(int $exerciseId, int $userId): ?Exercise;
    public function findByName(string $name): ?Exercise;

    public function getAllByUserId(int $userId): ExerciseList;

    public function delete(Exercise $exercise): void;
}
