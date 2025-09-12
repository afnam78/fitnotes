<?php

declare(strict_types=1);

namespace App\Modules\Backup\Infrastructure\Jobs;

use App\Models\User;
use App\Modules\Backup\Domain\ValueObject\BackupImportItemDTO;
use App\Modules\Exercise\Infrastructure\Database\Models\Exercise;
use App\Modules\Set\Infrastructure\Database\Models\Set;
use App\Modules\Workout\Infrastructure\Database\Models\Workout;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

final class LoadBackup implements ShouldQueue
{
    use Queueable;

    public $timeout = 360;

    /**
     * Create a new job instance.
     */
    public function __construct(private array $data, private int $userId)
    {

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $isValidStructure = collect($this->data)->every(fn ($item) => isset($item['Category'], $item['Exercise'], $item['Weight'], $item['Reps'], $item['Date']));

        if ( ! $isValidStructure) {
            Log::debug('Invalid backup structure', [
                'data' => $this->data,
                'userId' => $this->userId,
            ]);

            return;
        }

        User::with('workouts')
            ->findOrFail($this->userId)
            ->workouts()
            ->delete();

        collect($this->data)->each(function (array $item): void {
            $dto = BackupImportItemDTO::fromArray($item);

            $workout = $dto->workout();
            $workout = Workout::firstOrCreate([
                'user_id' => $this->userId,
                'name' => $workout,
            ]);

            $exercise = $dto->exercise();
            $exercise = Exercise::firstOrCreate([
                'name' => $exercise,
                'workout_id' => $workout->id,
            ]);

            Set::create([
                'exercise_id' => $exercise->id,
                'reps' => $dto->reps(),
                'weight' => $dto->weight(),
                'set_date' => $dto->date(),
            ]);
        });
    }
}
