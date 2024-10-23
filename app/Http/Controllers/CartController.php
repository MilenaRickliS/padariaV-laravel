<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session as FacadesSession;

class CartController extends Controller
{
    public function index()
    {
        $cart = FacadesSession::get('cart', []);
        return view('cart.index', compact('cart'));
    }

    public function add(Request $request, $id)
    {
        $cart = FacadesSession::get('cart', []);
        $cart[$id] = isset($cart[$id]) ? $cart[$id] + 1 : 1;
        FacadesSession::put('cart', $cart);
        
        // Definir uma variável de sessão para indicar que um item foi adicionado
        FacadesSession::flash('item_added', true);
        
        return redirect()->back()->with('success', 'Item adicionado ao carrinho!');
    }

    public function decrease($id)
    {
        $cart = FacadesSession::get('cart', []);
        
        if (isset($cart[$id])) {
            if ($cart[$id] > 1) {
                $cart[$id]--;
            } else {
                unset($cart[$id]);
            }
            FacadesSession::put('cart', $cart);
            return redirect()->back()->with('success', 'Quantidade reduzida no carrinho.');
        }
        
        return redirect()->back()->with('error', 'Item não encontrado no carrinho.');
    }

    public function remove($id)
    {
        $cart = FacadesSession::get('cart', []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
            FacadesSession::put('cart', $cart);
            return redirect()->back()->with('success', 'Item removido do carrinho.');
        }
        
        return redirect()->back()->with('error', 'Item não encontrado no carrinho.');
    }

    public function checkout()
    {
        // Verifique se o usuário está autenticado
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Você precisa estar logado para finalizar a compra!');
        }
        
        return view('cart.checkout');
    }
}