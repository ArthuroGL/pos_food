<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'admin' => \App\Http\Middleware\AdminMiddleware::class,
        'cocina' => \App\Http\Middleware\CocinaMiddleware::class,
        'mesero' => \App\Http\Middleware\MeseroMiddleware::class,
    ];
}
