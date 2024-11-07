<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/cart/checkout';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (Auth::attempt($credentials)) {
            // Adicione um log para verificar o e-mail do usuário
            Log::info('Usuário autenticado: ' . Auth::user()->email);

            // Verifica se o usuário é administrador
            if (Auth::user()->email === 'admin@example.com') {
                return redirect()->intended('/products'); // Redireciona para /products se for admin
            }

            // Aqui você deve verificar se o usuário tem itens no carrinho
            $cart = session()->get('cart', []); // Supondo que o carrinho esteja armazenado na sessão

            if (empty($cart)) {
                return redirect('/'); // Redireciona para a página inicial se o carrinho estiver vazio
            }

            return redirect()->intended($this->redirectTo); // Redireciona para /cart/checkout se não for admin e o carrinho não estiver vazio
        }

        return redirect()->back()->withErrors(['email' => 'Email ou senha inválidos']);
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $request->session()->forget('cart');
        Auth::logout();
        return redirect()->route('login');
    }
}
