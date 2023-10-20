<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Enums\ImageFormat;
use Exception;

final class InvalidFormatException extends Exception
{
    public function __construct()
    {
        parent::__construct('Format must be one of the following: '.implode(', ', ImageFormat::allowedFormats()));
    }
}
