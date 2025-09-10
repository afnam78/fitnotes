<?php

declare(strict_types=1);

namespace App\Modules\WorkoutCategory\Application\UseCases;

use App\Modules\ExerciseCatalog\Application\Commands\GetUserWorkoutsCommand;
use App\Modules\WorkoutCategory\Application\DTOs\WorkoutCategoryDTO;
use App\Modules\WorkoutCategory\Application\Results\GetUserWorkoutCategoriesResult;
use App\Modules\WorkoutCategory\Domain\Contracts\WorkoutCategoryRepositoryInterface;
use App\Modules\WorkoutCategory\Domain\Entities\WorkoutCategory;

final readonly class GetUserWorkoutCategoriesUseCase
{
    public function __construct(private WorkoutCategoryRepositoryInterface $repository)
    {
    }

    public function handle(GetUserWorkoutsCommand $command): GetUserWorkoutCategoriesResult
    {
        $workouts = $this->repository->getWorkoutsByUserId($command->userId);

        $dtos = $workouts
            ->items()
            ->map(fn (WorkoutCategory $workout) => new WorkoutCategoryDTO($workout->id(), $workout->name()))
            ->toArray();

        return new GetUserWorkoutCategoriesResult($dtos);
    }
}
