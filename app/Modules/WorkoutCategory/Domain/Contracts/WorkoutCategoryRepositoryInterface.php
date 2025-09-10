<?php

declare(strict_types=1);

namespace App\Modules\WorkoutCategory\Domain\Contracts;

use App\Modules\WorkoutCategory\Domain\Aggregates\WorkoutCategoryList;
use App\Modules\WorkoutCategory\Domain\Entities\WorkoutCategory;
use Exception;

interface WorkoutCategoryRepositoryInterface
{
    /**
     * Creates a new workout record in the database.
     *
     * @param WorkoutCategory $workout The workout entity containing the data to be saved.
     *
     * @throws Exception If an error occurs during record creation.
     */
    public function create(WorkoutCategory $workout);

    public function findByIdAndUserId(int $workoutId, int $userId): ?WorkoutCategory;

    public function update(WorkoutCategory $workout);

    public function delete(int $id): void;

    public function getWorkoutsByUserId(int $userId): WorkoutCategoryList;
}
