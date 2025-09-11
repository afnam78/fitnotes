<?php

declare(strict_types=1);

namespace App\Modules\Shared\Domain\Exceptions;

use Exception;

final class NegativeNumber extends Exception
{
    public function __construct()
    {
        parent::__construct('Negative numbers are not allowed');
    }
}
