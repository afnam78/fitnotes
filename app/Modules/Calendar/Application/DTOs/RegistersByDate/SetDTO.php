<?php

declare(strict_types=1);

namespace App\Modules\Calendar\Application\DTOs\RegistersByDate;

use App\Modules\Calendar\Domain\ValueObjects\Set;

final class SetDTO
{
    public function __construct(
        public int   $reps,
        public float $weight,
        public int   $order,
    ) {
    }

    public static function toDTO(Set $set): SetDTO
    {
        return new SetDTO(
            reps: $set->reps(),
            weight: $set->weight(),
            order: $set->order(),
        );
    }

    public function toArray(): array
    {
        return [
            'reps' => $this->reps,
            'weight' => $this->weight,
            'order' => $this->order,
        ];
    }
}
