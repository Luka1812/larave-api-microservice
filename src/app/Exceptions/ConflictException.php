<?php

namespace App\Exceptions;

use Throwable;
use Symfony\Component\HttpFoundation\Response;

class ConflictException extends BaseHttpException
{
    /**
     * The custom exception constructor.
     *
     * @param string $message
     * @param string $errorCode
     * @param \Throwable $previous
     * @param int $code
     *
     * @return void
     */
    public function __construct(string $message, string $errorCode, Throwable $previous = null, ?int $code = 0)
    {
        parent::__construct($message, $errorCode, Response::HTTP_CONFLICT, $previous, $code);
    }
}
