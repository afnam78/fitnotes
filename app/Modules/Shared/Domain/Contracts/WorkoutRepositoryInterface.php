<?php

declare(strict_types=1);

namespace App\Modules\Shared\Domain\Contracts;

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
}
