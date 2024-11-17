<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Pedido;
use App\Models\Endereco;
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
            $pedidos = Pedido::with('itens.product', 'endereco')->where('user_id', Auth::user()->id)->get();
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

        // Validate address data
        $validatedData = $request->validate([
            'rua' => 'required|string|regex:/^[a-zA-Z\sçáàãâéêíóôú´`~]+$/', // Apenas letras, espaços e acentos
            'numero' => 'required|integer', // Apenas números
            'cep' => 'required|string|regex:/^\d{5}-\d{3}$/', // Formato de CEP com traço (ex: 12345-678)
            'estado' => 'required|string|regex:/^[a-zA-Z\s]+$/', // Apenas letras e espaços
            'cidade' => 'required|string|regex:/^[a-zA-Z\sçáàãâéêíóôú´`~]+$/', // Apenas letras e espaços
            'complemento' => 'nullable|string|regex:/^[a-zA-Z0-9\s.,-]*$/', // Letras, números, espaços e pontuações, opcional
            'forma_pagamento' => 'required|string', // Forma de pagamento
        ], [
            'rua.required' => 'O campo Rua é obrigatório.',
            'rua.regex' => 'A Rua deve conter apenas letras e espaços.',
            'numero.required' => 'O campo Número é obrigatório.',
            'numero.integer' => 'O Número deve ser um valor numérico.',
            'cep.required' => 'O campo CEP é obrigatório.',
            'cep.regex' => 'O CEP deve estar no formato 00000-000 (valor numérico).',
            'estado.required' => 'O campo Estado é obrigatório.',
            'estado.regex' => 'O Estado deve conter apenas letras e espaços.',
            'cidade.required' => 'O campo Cidade é obrigatório.',
            'cidade.regex' => 'A Cidade deve conter apenas letras e espaços.',
            'complemento.regex' => 'O Complemento deve conter apenas letras, números, espaços e pontuações permitidas.',
            'forma_pagamento.required' => 'A Forma de Pagamento é obrigatória.',
        ]);

        
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
        
        // Save items in the order
        foreach ($cart as $id => $quantity) {
            $pedido->itens()->create([
                'product_id' => $id,
                'quantidade' => $quantity
            ]);
        }
        
        // Save address information
        $endereco = new Endereco();
        $endereco->pedido_id = $pedido->id;
        $endereco->rua = $request->rua;
        $endereco->numero = $request->numero;
        $endereco->cep = $request->cep;
        $endereco->cidade = $request->cidade;
        $endereco->estado = $request->estado;
        $endereco->complemento = $request->complemento;
        $endereco->forma_pagamento = $request->forma_pagamento;
        $endereco->save();
        
        // Clear the cart after saving the order
        FacadesSession::forget('cart');
        
        // Redirect to the pedidos index page
        return redirect()->route('pedidos.index')->with('success', 'Pedido realizado com sucesso!');
    }
}