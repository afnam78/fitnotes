<?php

declare(strict_types=1);

namespace App\Modules\Set\Domain\Contracts;

use App\Modules\Set\Domain\Entities\Set;

interface SetRepositoryInterface
{
    public function create(Set $set): void;
    public function update(Set $set): void;

    public function findByIdAndUserId(int $id, int $userId): ?Set;

    public function delete(Set $set): void;
}
