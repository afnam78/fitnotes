<?php

declare(strict_types=1);

namespace App\Modules\WorkoutCategory\Application\UseCases;

use App\Modules\WorkoutCategory\Application\Commands\DeleteWorkoutCategoryCommand;
use App\Modules\WorkoutCategory\Domain\Contracts\WorkoutCategoryRepositoryInterface;
use InvalidArgumentException;

final readonly class DeleteWorkoutCategoryUseCase
{
    public function __construct(private WorkoutCategoryRepositoryInterface $repository)
    {
    }

    public function handle(DeleteWorkoutCategoryCommand $command): void
    {
        $workout = $this->repository->findByIdAndUserId($command->workoutId, $command->userId);

        if ( ! $workout) {
            throw new InvalidArgumentException('WorkoutCategory not found.');
        }

        $this->repository->delete($command->workoutId);
    }
}
