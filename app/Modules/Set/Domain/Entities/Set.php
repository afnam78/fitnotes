<?php

declare(strict_types=1);

namespace App\Modules\Set\Domain\Entities;

final class Set
{
    private int $id;
    private int $exerciseCatalogId;
    private int $reps;
    private float $weight;

    private int $order;



    public function __construct(
        int   $id,
        int   $exerciseCatalogId,
        int   $reps,
        float $weight,
        int   $order,
    ) {
        $this->id = $id;
        $this->exerciseCatalogId = $exerciseCatalogId;
        $this->reps = $reps;
        $this->weight = $weight;
        $this->order = $order;
    }


    public function id(): int
    {
        return $this->id;
    }

    public function exerciseCatalogId(): int
    {
        return $this->exerciseCatalogId;
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
