<?php
namespace App\Http;
use Illuminate\Foundation\Http\Kernel as HttpKernel;
class Kernel extends HttpKernel
{
    protected $routeMiddleware = [
        // outros middlewares
        'check.login' => \App\Http\Middleware\CheckLogin::class,
        'check.admin' => \App\Http\Middleware\CheckAdmin::class,
    ];
}