<?php

namespace App\Exceptions;

use App\Traits\JsonRespond;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    use JsonRespond;

    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
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
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (AuthenticationException $e, Request $request) {
            if ($request->is('api/*')) {
                return $this->respondUnauthorized('Пользователь не аутентифицирован.');
            }
        });
    }

    public function render($request, Throwable $e)
    {
        if ($request->is('api/*')) {
            $class = get_class($e);

            switch ($class) {
                case AuthorizationException::class:
                    return $this->respondUnauthorized('Недостаточно прав.');
                case ValidationException::class:
                    return $this->respondValidatorFailed($e->validator);
                case ModelNotFoundException::class:
                    return $this->respondNotFound('Запрашиваемый ресурс не найден.');
                default:
                    break;
            }
        }

        return parent::render($request, $e);
    }
}
