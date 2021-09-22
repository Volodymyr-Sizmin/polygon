<?php

namespace App\Exception;

use Exception;
use Symfony\Component\HttpKernel\Exception\HttpException;

class FileUploadException extends HttpException
{
    /**
     * @param string $message
     * @param int $code
     * @param Exception|null $previous
     */
    public function __construct(int $code, string $message, Exception $previous = null)
    {
        parent::__construct($code, $message, $previous);
    }
}