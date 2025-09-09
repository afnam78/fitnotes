<?php

declare(strict_types=1);

namespace App\Modules\Set\Domain\Contracts;

use App\Modules\Exercise\Domain\Entities\Exercise;
use App\Modules\Set\Domain\Entities\Set;
use Illuminate\Support\Carbon;

interface SetRepositoryInterface
{
    public function create(Set $set): void;

    public function getLasOrder(Exercise $exercise, Carbon $date): int;
}
