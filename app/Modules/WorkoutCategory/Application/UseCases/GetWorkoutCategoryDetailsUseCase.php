<?php

declare(strict_types=1);

namespace App\Modules\WorkoutCategory\Application\UseCases;

use App\Modules\WorkoutCategory\Application\Commands\GetWorkoutCategoryDetailsCommand;
use App\Modules\WorkoutCategory\Application\Results\GetWorkoutCategoryDetailsResult;
use App\Modules\WorkoutCategory\Domain\Contracts\WorkoutCategoryRepositoryInterface;

final readonly class GetWorkoutCategoryDetailsUseCase
{
    public function __construct(private WorkoutCategoryRepositoryInterface $repository)
    {
    }

    public function handle(GetWorkoutCategoryDetailsCommand $command): GetWorkoutCategoryDetailsResult
    {
        $workout = $this->repository->findByIdAndUserId($command->workoutId, $command->userId);

        if ( ! $workout) {
            abort(404);
        }

        return new GetWorkoutCategoryDetailsResult(
            id: $workout->id(),
            name: $workout->name(),
        );
    }
}
