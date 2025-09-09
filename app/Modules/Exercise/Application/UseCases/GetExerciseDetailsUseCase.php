<?php

declare(strict_types=1);

namespace App\Modules\Exercise\Application\UseCases;

use App\Modules\Exercise\Application\Commands\GetExerciseDetailsCommand;
use App\Modules\Exercise\Application\Results\GetExerciseDetailsResult;
use App\Modules\Exercise\Domain\Contracts\ExerciseRepositoryInterface;
use Exception;

final readonly class GetExerciseDetailsUseCase
{
    public function __construct(private ExerciseRepositoryInterface $repository)
    {
    }

    public function handle(GetExerciseDetailsCommand $command): GetExerciseDetailsResult
    {
        $exercise = $this->repository->findByIdAndUserId($command->exerciseId, $command->userId);

        if (null === $exercise) {
            return throw new Exception("Exercise not found");
        }

        return new GetExerciseDetailsResult(
            id: $exercise->id(),
            name: $exercise->name(),
            description: $exercise->description(),
            workoutId: $exercise->workoutId(),
        );
    }
}
