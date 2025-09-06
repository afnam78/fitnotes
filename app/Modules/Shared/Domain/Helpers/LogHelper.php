<?php

declare(strict_types=1);

namespace App\Modules\Shared\Domain\Helpers;

use Exception;

final class LogHelper
{
    public static function body(
        Exception $exception,
        string $class,
        string $method,
        mixed $data,
    ): array {
        return [
            'metadata' => [
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
                'class' => $class,
                'method' => $method,
            ],
            'error' => [
                'message' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString(),
            ],
            'data' => $data,
        ];
    }
}
