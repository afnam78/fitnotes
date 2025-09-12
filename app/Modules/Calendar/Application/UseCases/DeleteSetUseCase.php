<?php

declare(strict_types=1);

namespace App\Modules\Calendar\Application\UseCases;

use App\Modules\Calendar\Application\Commands\DeleteSetCommand;
use App\Modules\Set\Domain\Contracts\SetRepositoryInterface;
use Exception;

final readonly class DeleteSetUseCase
{
    public function __construct(private SetRepositoryInterface $setRepository)
    {
    }

    public function handle(DeleteSetCommand $command): void
    {
        $set = $this->setRepository->findByIdAndUserId(id: $command->setId, userId: $command->userId);

        if ( ! $set) {
            throw new Exception('Set not found');
        }

        $this->setRepository->delete($set);
    }
}
