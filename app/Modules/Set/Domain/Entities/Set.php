<?php

declare(strict_types=1);

namespace App\Modules\Set\Domain\Entities;

use Illuminate\Support\Carbon;

final class Set
{
    private int $id;
    private int $exerciseId;
    private int $reps;
    private float $weight;

    private int $order;

    private Carbon $date;


    public function __construct(
        int   $exerciseId,
        int   $reps,
        float $weight,
        int   $order,
        Carbon $date,
    ) {
        $this->exerciseId = $exerciseId;
        $this->reps = $reps;
        $this->weight = $weight;
        $this->order = $order;
        $this->date = $date;
    }


    public function id(): int
    {
        return $this->id;
    }

    public function exerciseId(): int
    {
        return $this->exerciseId;
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

    public function date(): Carbon
    {
        return $this->date;
    }
}
