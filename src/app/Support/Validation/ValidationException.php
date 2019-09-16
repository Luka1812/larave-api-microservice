<?php

namespace App\Support\Validation;

use Illuminate\Validation\ValidationException as BaseValidationException;
use Symfony\Component\HttpFoundation\Response;

class ValidationException extends BaseValidationException
{
    /**
     * The status code to use for the response.
     *
     * @var int
     */
    public $status = Response::HTTP_BAD_REQUEST;

    /**
     * Get all of the validation error messages.
     *
     * @return array
     */
    public function errors(): array
    {
        return $this->validator->errors();
    }
}
