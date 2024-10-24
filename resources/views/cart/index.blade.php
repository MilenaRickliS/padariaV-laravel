@extends('layouts.app')

@section('content')
    <h1>Carrinho de Compras</h1>

    @if (Session::has('cart') && count(Session::get('cart')) > 0)
        <table class="carrinho">
            <thead>
                <tr>
                    <th>Produto</th>
                    <th>Quantidade</th>
                    <th>Preço</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach (Session::get('cart') as $id => $quantity)
                    @php
                        $product = App\Models\Product::find($id);
                    @endphp
                    <tr>
                        <td>{{ $product->name }}</td>
                                              
                        <td>
                            <form action="{{ url('/cart/decrease/'.$id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button class="menos" type="submit">-</button>
                            </form>
                            {{ $quantity }}
                            <form action="{{ url('/cart/add/'.$id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button class="mais" type="submit">+</button>
                            </form>
                        </td>
                        <td>R$ {{ number_format($product->price, 2, ',', '.') }}</td>
                        <td>
                            <form action="{{ url('/cart/remove/'.$id) }}" method="GET" style="display:inline;">
                                @csrf
                                <button class="remover" type="submit"><i class="bi bi-trash3-fill"></i>Remover</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="final-carrinho">
            <p class="total">Total: R$ {{ number_format(array_sum(array_map(function($id) {
                $product = App\Models\Product::find($id);
                return $product ? $product->price * Session::get('cart')[$id] : 0; // Verifica se o produto existe
                }, array_keys(Session::get('cart')))), 2, ',', '.') }}</p>
            <a href="{{ url('/cart/checkout') }}">Finalizar Compra</a>
        </div>
    @else
        <h1 style="color: red"><i class="bi bi-emoji-frown-fill"></i> Carrinho vazio!</h1>
    @endif
    @endsection