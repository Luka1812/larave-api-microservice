<?php

namespace App\Exceptions;

use Exception;
use Throwable;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\JsonResponse;

abstract class BaseHttpException extends Exception implements BaseHttpExceptionInterface
{
    /**
 * The error code
 *
 * @var string
 */
    private $errorCode;

    /**
     * The status code
     *
     * @var int
     */
    private $statusCode;

    /**
     * The custom exception constructor.
     *
     * @param string $message
     * @param string $errorCode
     * @param int $statusCode
     * @param \Throwable $previous
     * @param int $code
     *
     * @return void
     */
    public function __construct(string $message, string $errorCode, int $statusCode, Throwable $previous = null, ?int $code = 0)
    {
        parent::__construct($message, $code, $previous);

        $this->errorCode = $errorCode;
        $this->statusCode = $statusCode;
    }

    /**
     * @return string
     */
    public function getErrorCode(): string
    {
        return $this->errorCode;
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * Render an exception into a response.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function render($request)
    {
        if (true === Config::get('app.debug')) {
            return new JsonResponse([
                'errors' => [
                    'message'   => $this->getMessage(),
                    'code'      => $this->getErrorCode(),
                    'exception' => get_class($this),
                    'file'      => $this->getFile(),
                    'line'      => $this->getLine(),
                    'trace'     => $this->getTrace(),
                ]
            ], $this->getStatusCode());
        } else {
            return new JsonResponse([
                'errors' => [
                    'message' => $this->getMessage(),
                    'code'    => $this->getErrorCode(),
                ]
            ], $this->getStatusCode());
        }
    }
}
