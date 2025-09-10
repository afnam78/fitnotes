<?php

declare(strict_types=1);

namespace App\Modules\WorkoutCategory\Domain\Exceptions;

use Exception;
use Throwable;

final class WorkoutCategoryMustBeUnique extends Exception
{
    public function __construct(string $message = "WorkoutCategory name must be unique", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
