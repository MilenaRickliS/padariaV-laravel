<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session as FacadesSession;
use Session;

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
    
    return redirect()->back();
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
    }
    
    return redirect()->back();
}

    public function remove($id)
    {
        $cart = FacadesSession::get('cart', []);
        unset($cart[$id]);
        FacadesSession::put('cart', $cart);
        return redirect()->back();
    }

    public function checkout()
    {
        return view('cart.checkout');
    }
}
