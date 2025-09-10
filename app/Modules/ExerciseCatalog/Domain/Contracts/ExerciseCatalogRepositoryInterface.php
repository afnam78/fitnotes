<?php

declare(strict_types=1);

namespace App\Modules\ExerciseCatalog\Domain\Contracts;

use App\Modules\ExerciseCatalog\Domain\Entities\ExerciseCatalog;

interface ExerciseCatalogRepositoryInterface
{
    public function create(ExerciseCatalog $exercise): void;

    public function findByIdAndUserId(int $exerciseId, int $userId): ?ExerciseCatalog;

    public function delete(ExerciseCatalog $exercise): void;
}
