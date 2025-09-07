<?php

declare(strict_types=1);

namespace App\Modules\Calendar\Application\Commands;

use Illuminate\Support\Carbon;

final readonly class GetRegistersByDateCommand
{
    public function __construct(
        public int $userId,
        public Carbon $date,
    ) {
    }
}
