<?php

declare(strict_types=1);

namespace App\Modules\Calendar\Application\UseCases;

use App\Modules\Calendar\Application\Commands\UpdateSetCommand;
use App\Modules\Set\Domain\Contracts\SetRepositoryInterface;
use Exception;

final readonly class UpdateSetUseCase
{
    public function __construct(private SetRepositoryInterface $setRepository)
    {
    }

    public function handle(UpdateSetCommand $command): void
    {
        $set = $this->setRepository->findByIdAndUserId(id: $command->setId, userId: $command->userId);

        if ($set === null) {
            throw new Exception('Set not found');
        }

        $set->setReps($command->reps);
        $set->setWeight($command->weight);

        $this->setRepository->update($set);
    }
}
