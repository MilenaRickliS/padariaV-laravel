<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAdmin
{
    public function handle(Request $request, Closure $next)
    {
        // Verifica se o usuário está autenticado e se é um administrador
        if (Auth::check() && Auth::user()->email === 'admin@example.com') {
            return $next($request);
        }

        // Se não for admin, adiciona uma mensagem de erro na sessão
        return redirect('/products')->with('error', 'Você precisa ser um administrador para acessar esta página.'); // Mensagem de erro
    }
}