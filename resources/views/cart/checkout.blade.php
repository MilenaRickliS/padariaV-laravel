@extends('layouts.app')

@section('content')

    <h1>Finalizar Compra</h1>

    <div class="finalizar">
    @if (auth()->check())
        <p class="titulo-finalizar">Olá, {{ auth()->user()->name }}!</p>
        <div class="final-flex">
            <p class="titulo-final">Seu carrinho</p>
            <p class="titulo-final">Total: R$ {{ number_format(array_sum(array_map(function($id) {
                $product = App\Models\Product::find($id);
                return $product ? $product->price * Session::get('cart')[$id] : 0; // Verifica se o produto existe
            }, array_keys(Session::get('cart')))), 2, ',', '.') }}</p>
        </div>
        @if (Session::has('cart'))
            <table class="finalizar-carrinho">
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Quantidade</th>
                        <th>Preço</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach (Session::get('cart') as $id => $quantity)
                        @php
                            $product = App\Models\Product::find($id);
                        @endphp
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td>{{ $quantity }}</td>
                            <td>R$ {{ $product->price }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <br><br>
            <p class="titulo-finalizar">Adicionar Endereço e Pagamento</p>
        <form class="form-finalizar" action="{{ url('/pedidos') }}" method="POST">
            @csrf
            <div>
                <label for="rua">Rua:</label>
                <input type="text" name="rua" required placeholder="Avenida">
            </div>
            <div>
                <label for="numero">Número:</label>
                <input type="text" name="numero" required placeholder="123">
            </div>
            <div>
                <label for="cep">CEP:</label>
                <input type="text" name="cep" required placeholder="xxxxxxxx">
            </div>
            <div>
                <label for="cidade">Cidade:</label>
                <input type="text" name="cidade" required placeholder="Cidade">
            </div>
            <div>
                <label for="complemento">Complemento:</label>
                <input type="text" name="complemento" placeholder="Complemento">
            </div>
            <div>
                <label for="forma_pagamento">Forma de Pagamento:</label>
                <select name="forma_pagamento" required>
                    <option value="cartao">Cartão de Crédito</option>
                    <option value="boleto">Boleto</option>
                    <option value="pix">Pix</option>
                    <option value="dinheiro">Dinheiro</option>
                    <option value="voucher">Voucher</option>
                </select>
            </div>
            <button class="button-final" type="submit">Finalizar Compra</button>
        </form>

        @else
        <h1 style="color: red"><i class="bi bi-emoji-frown-fill"></i> Carrinho vazio!</h1>
        @endif
    @else
        <h1>Você precisa estar logado para finalizar a compra!</h1>
        <a href="{{ url('/login') }}">Login</a>
    @endif
    </div>
@endsection