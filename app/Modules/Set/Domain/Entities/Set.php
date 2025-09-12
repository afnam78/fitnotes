<?php

declare(strict_types=1);

namespace App\Modules\Set\Domain\Entities;

use App\Modules\Shared\Domain\Exceptions\NegativeNumber;
use Illuminate\Support\Carbon;

final class Set
{
    private int $id;
    private int $exerciseId;
    private int $reps;
    private float $weight;

    private Carbon $date;


    public function __construct(
        int   $id,
        int   $exerciseId,
        int   $reps,
        float $weight,
        Carbon $date,
    ) {
        $this->id = $id;
        $this->exerciseId = $exerciseId;
        $this->reps = $reps;
        $this->weight = $weight;
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

    public function date(): Carbon
    {
        return $this->date;
    }

    public function setDate(Carbon $date): void
    {
        $this->date = $date;
    }


    public function setReps(int $reps): void
    {
        if ($reps < 0) {
            throw new NegativeNumber();
        }

        $this->reps = $reps;
    }

    public function setWeight(float $weight): void
    {
        if ($weight < 0) {
            throw new NegativeNumber();
        }

        $this->weight = $weight;
    }
}
