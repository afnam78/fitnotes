<?php

declare(strict_types=1);

namespace App\Modules\Backup\Application\Commands;

final class LoadBackupCommand
{
    public function __construct(
        public string $filePath,
        public int $userId,
    ) {
    }
}
