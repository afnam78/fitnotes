<?php

declare(strict_types=1);

namespace App\Modules\Workout\Domain\Exceptions;

use Exception;

final class WorkoutAlreadyExists extends Exception
{
    public function __construct()
    {
        parent::__construct('El entrenamiento ya existe');
    }
}
