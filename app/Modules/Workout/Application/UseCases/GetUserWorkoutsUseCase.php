<?php

declare(strict_types=1);

namespace App\Modules\Workout\Application\UseCases;

use App\Modules\Exercise\Application\Commands\GetUserWorkoutsCommand;
use App\Modules\Workout\Application\DTOs\WorkoutDTO;
use App\Modules\Workout\Application\Results\GetUserWorkoutsResult;
use App\Modules\Workout\Domain\Contracts\WorkoutRepositoryInterface;
use App\Modules\Workout\Domain\Entities\Workout;

final readonly class GetUserWorkoutsUseCase
{
    public function __construct(private WorkoutRepositoryInterface $repository)
    {
    }

    public function handle(GetUserWorkoutsCommand $command): GetUserWorkoutsResult
    {
        $workouts = $this->repository->getWorkoutsByUserId($command->userId);

        $dtos = $workouts
            ->items()
            ->map(fn (Workout $workout) => new WorkoutDTO($workout->id(), $workout->name(), $workout->description()))
            ->toArray();

        return new GetUserWorkoutsResult($dtos);
    }
}
