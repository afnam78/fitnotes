<?php

declare(strict_types=1);

namespace App\Modules\Calendar\Domain\ValueObjects;

final class Set
{
    public function __construct(
        private int   $id,
        private int   $exerciseId,
        private int   $workoutId,
        private int   $reps,
        private float $weight,
        private int   $order,
    ) {
    }

    public function id(): int
    {
        return $this->id;
    }

    public function exerciseId(): int
    {
        return $this->exerciseId;
    }

    public function workoutId(): int
    {
        return $this->workoutId;
    }

    public function reps(): int
    {
        return $this->reps;
    }

    public function weight(): float
    {
        return $this->weight;
    }

    public function order(): int
    {
        return $this->order;
    }
}
