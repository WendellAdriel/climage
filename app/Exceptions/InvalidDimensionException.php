<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

final class InvalidDimensionException extends Exception
{
    public function __construct(int $max)
    {
        parent::__construct("The value must be between 10 and {$max}");
    }
}
