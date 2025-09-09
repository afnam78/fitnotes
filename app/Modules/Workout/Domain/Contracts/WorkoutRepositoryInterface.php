<?php

declare(strict_types=1);

namespace App\Modules\Workout\Domain\Contracts;

use App\Modules\Workout\Domain\Aggregates\WorkoutList;
use App\Modules\Workout\Domain\Entities\Workout;
use Exception;

interface WorkoutRepositoryInterface
{
    /**
     * Creates a new workout record in the database.
     *
     * @param Workout $workout The workout entity containing the data to be saved.
     *
     * @throws Exception If an error occurs during record creation.
     */
    public function create(Workout $workout);

    public function findByIdAndUserId(int $workoutId, int $userId): ?Workout;

    public function update(Workout $workout);

    public function delete(int $id): void;

    public function getWorkoutsByUserId(int $userId): WorkoutList;
}
