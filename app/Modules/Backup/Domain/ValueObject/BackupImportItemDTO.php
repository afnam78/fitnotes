<?php

declare(strict_types=1);

namespace App\Modules\Backup\Domain\ValueObject;

use Illuminate\Support\Carbon;

final class BackupImportItemDTO
{
    private Carbon $date;
    private string $exercise;
    private string $workout;
    private float $weight;
    private int $reps;
    public function __construct(
        Carbon $date,
        string $exercise,
        string $workout,
        float $weight,
        int $reps,
    ) {
        $this->date = $date;
        $this->exercise = $this->normalized($exercise);
        $this->workout = $this->normalized($workout);
        $this->weight = $weight;
        $this->reps = $reps;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            Carbon::createFromFormat('Y-m-d', $data['Date']),
            $data['Exercise'],
            $data['Category'],
            (float) $data['Weight'],
            $data['Reps'],
        );
    }

    public function normalized(string $value): string
    {
        return str($value)
            ->trim()
            ->ascii()
            ->ucfirst()
            ->toString();
    }

    public function date(): Carbon
    {
        return $this->date;
    }

    public function exercise(): string
    {
        return $this->exercise;
    }
    public function workout(): string
    {
        return $this->workout;
    }
    public function weight(): float
    {
        return $this->weight;
    }

    public function reps(): int
    {
        return $this->reps;
    }
}
