<?php

declare(strict_types=1);

namespace App\Modules\WorkoutCategory\Application\UseCases;

use App\Modules\WorkoutCategory\Application\Commands\CreateWorkoutCategoryCommand;
use App\Modules\WorkoutCategory\Domain\Contracts\WorkoutCategoryRepositoryInterface;
use App\Modules\WorkoutCategory\Domain\Entities\WorkoutCategory;
use App\Modules\WorkoutCategory\Domain\Exceptions\WorkoutCategoryMustBeUnique;

final class CreateWorkoutCategoryUseCase
{
    public function __construct(private WorkoutCategoryRepositoryInterface $repository)
    {
    }

    /**
     * @throws WorkoutCategoryMustBeUnique
     */
    public function handle(CreateWorkoutCategoryCommand $command): void
    {
        $workout = $this->makeEntity($command);

        $workoutCategories = $this->repository->getWorkoutsByUserId($command->userId);
        $workoutCategories->validateIsUnique($workout);

        $this->repository->create($workout);
    }

    private function makeEntity(CreateWorkoutCategoryCommand $command): WorkoutCategory
    {
        return new WorkoutCategory(
            id: 0,
            name: $command->name,
            userId: $command->userId,
        );
    }
}
