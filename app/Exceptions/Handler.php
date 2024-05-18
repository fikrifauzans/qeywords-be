<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof ValidationException) {
            return response()->json(['error' => $exception->getMessage()], 422);
        }

        if ($exception instanceof ErrorResponse) {
            return response()->json($exception->getError(), $exception->getErrorStatus());
        }

        if ($exception instanceof RouteNotFoundException) {

            return response()->json(['error' => "Route Not Found"], 404);
        }
        return parent::render($request, $exception);
    }
}
