<?php

declare(strict_types=1);

namespace App\Modules\Calendar\Application\UseCases;

use App\Modules\Calendar\Application\Commands\GetRegistersByDateCommand;
use App\Modules\Calendar\Application\DTOs\RegistersByDate\WorkoutDTO;
use App\Modules\Calendar\Application\Results\GetRegistersByDateResult;
use App\Modules\Calendar\Domain\Contracts\WorkoutCategoryRepositoryInterface;
use App\Modules\Calendar\Domain\ValueObjects\Workout;

final readonly class GetRegistersByDateUseCase
{
    public function __construct(private WorkoutCategoryRepositoryInterface $workoutRepository)
    {
    }

    public function handle(GetRegistersByDateCommand $command): GetRegistersByDateResult
    {
        $workouts = $this->workoutRepository->getRegistersByDate($command->userId, $command->date);

        return new GetRegistersByDateResult(array_map(fn (Workout $workout) => WorkoutDTO::toDTO($workout), $workouts)); // Placeholder return value
    }
}
