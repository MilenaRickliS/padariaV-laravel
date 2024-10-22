<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAdmin
{
    public function handle(Request $request, Closure $next)
    {
        // Verifica se o usuário está autenticado e se o e-mail é do admin
        if (Auth::check() && Auth::user()->email === 'admin@example.com') {
            return $next($request);
        }

        // Redireciona usuários normais para a página de finalização de compra
        return redirect('/cart/checkout')->with('error', 'Você não tem permissão para acessar esta página.');
    }
}