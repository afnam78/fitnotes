<?php

declare(strict_types=1);

namespace App\Modules\Exercise\Domain\Exceptions;

use Exception;

final class ExerciseAlreadyExists extends Exception
{
    public function __construct()
    {
        parent::__construct('El ejercicio ya existe');
    }
}
