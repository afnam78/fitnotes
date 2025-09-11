<?php

declare(strict_types=1);

namespace App\Modules\Shared\Application\UseCases;

use App\Modules\Shared\Application\Commands\GetDashboardKPICommand;
use App\Modules\Shared\Application\Results\GetDashboardKPIResult;
use App\Modules\Shared\Domain\Contracts\DashboardRepositoryInterface;

final readonly class GetDashboardKPIUseCase
{
    public function __construct(private DashboardRepositoryInterface $dashboardRepository)
    {

    }

    public function handle(GetDashboardKPICommand $command): GetDashboardKPIResult
    {
        return new GetDashboardKPIResult(
            workoutsToday: $this->dashboardRepository->getWorkoutsCountToday($command->userId),
            currentWeekSets: $this->dashboardRepository->getCurrentWeekSetsCount($command->userId),
            weeklyVolume: $this->dashboardRepository->getWeeklyVolume($command->userId),
            getWeeklyRecordsExercises: $this->dashboardRepository->getWeeklyRecordsExercises($command->userId)
        );
    }
}
