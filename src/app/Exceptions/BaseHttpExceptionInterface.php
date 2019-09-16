<?php

namespace App\Exceptions;

interface BaseHttpExceptionInterface
{
    /**
     * Get error code
     *
     * @return string
     */
    public function getErrorCode() : string;

    /**
     * Get status code
     *
     * @return int
     */
    public function getStatusCode() : int;
}
