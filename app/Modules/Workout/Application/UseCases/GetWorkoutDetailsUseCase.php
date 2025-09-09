<?php

declare(strict_types=1);

namespace App\Modules\Workout\Application\UseCases;

use App\Modules\Workout\Application\Commands\GetWorkoutDetailsCommand;
use App\Modules\Workout\Application\Results\GetWorkoutDetailsResult;
use App\Modules\Workout\Domain\Contracts\WorkoutRepositoryInterface;

final readonly class GetWorkoutDetailsUseCase
{
    public function __construct(private WorkoutRepositoryInterface $repository)
    {
    }

    public function handle(GetWorkoutDetailsCommand $command): GetWorkoutDetailsResult
    {
        $workout = $this->repository->findByIdAndUserId($command->workoutId, $command->userId);

        if ( ! $workout) {
            abort(404);
        }

        return new GetWorkoutDetailsResult(
            id: $workout->id(),
            name: $workout->name(),
            description: $workout->description(),
        );
    }
}
