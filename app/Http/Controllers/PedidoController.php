<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Pedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session as FacadesSession;

class PedidoController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'valor' => 'required|numeric',
        ]);

        $pedido = new Pedido();
        $pedido->valor = $request->valor;
        $pedido->user_id = Auth::user()->id;
        $pedido->save();

        return redirect()->route('pedidos.index')->with('success', 'Pedido realizado com sucesso!');
    }

    public function index()
    {
        if (Auth::check()) {
            $pedidos = Auth::user()->pedidos;
            return view('pedidos.index', compact('pedidos'));
        } else {
            return redirect()->route('login')->with('error', 'Você precisa estar logado para ver seus pedidos.');
        }
    }

    public function pedidos(Request $request)
    {
        // Validate that the cart is not empty
        $cart = FacadesSession::get('cart', []);
        if (empty($cart)) {
            return redirect()->back()->with('error', 'Carrinho vazio!');
        }

        // Calculate total value of the order
        $totalValue = array_sum(array_map(function($id) {
            $product = \App\Models\Product::find($id);
            return $product ? $product->price * FacadesSession::get('cart')[$id] : 0;
        }, array_keys($cart)));

        // Create the order
        $pedido = new Pedido();
        $pedido->valor = $totalValue;
        $pedido->user_id = Auth::user()->id;
        $pedido->save();

        // Clear the cart after saving the order
        FacadesSession::forget('cart');

        // Redirect to the pedidos index page
        return redirect()->route('pedidos.index')->with('success', 'Pedido realizado com sucesso!');
    }
}