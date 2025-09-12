<?php

declare(strict_types=1);

namespace App\Modules\Backup\Application\UseCases;

use App\Modules\Backup\Application\Commands\LoadBackupCommand;
use App\Modules\Backup\Infrastructure\Jobs\LoadBackup;

final class LoadBackupUseCase
{
    public function __construct()
    {
    }

    public function handle(LoadBackupCommand $command): void
    {
        $json = file_get_contents($command->filePath);
        $data = json_decode($json, true);

        LoadBackup::dispatch($data, $command->userId);
    }
}
