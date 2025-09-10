<?php

declare(strict_types=1);

namespace App\Modules\Set\Domain\Contracts;

use App\Modules\Set\Domain\Entities\Set;
use Illuminate\Support\Carbon;

interface SetRepositoryInterface
{
    public function add(int $userId, Set $set, Carbon $date): void;
}
