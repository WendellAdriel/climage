<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

final class FileNotFoundException extends Exception
{
    public function __construct()
    {
        parent::__construct('The given file does not exist!');
    }
}
