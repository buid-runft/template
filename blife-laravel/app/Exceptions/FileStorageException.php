<?php

namespace App\Exceptions;

use Exception;

class FileStorageException extends Exception
{
    public function __construct(string $message = "File Storage Error", int $code = 0, ?Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}