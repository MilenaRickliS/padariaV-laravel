<?php
namespace App\Http;
use Illuminate\Foundation\Http\Kernel as HttpKernel;
class Kernel extends HttpKernel
{
    protected $routeMiddleware = [
        // outros middlewares
        'auth' => \App\Http\Middleware\CheckLogin::class,
    ];
}