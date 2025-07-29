<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    public function render($request, Throwable $exception)
    {

        if ($exception instanceof MethodNotAllowedHttpException) {
            abort(404);
        }
        if ($exception instanceof \ErrorException) {
            return redirect()->route('login')->with('error', 'Acceso no autorizado');
        }

        if ($exception instanceof ModelNotFoundException) {
            return redirect()->route('login')->with('error', 'Recurso no encontrado');
        }

        return parent::render($request, $exception);
    }
}
