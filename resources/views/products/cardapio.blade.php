@extends('layouts.app')

@section('content')

<h1>Cardápio</h1>
@if (session()->has('cart') && count(session('cart')) > 0)
    <a href="{{ url('/cart') }}" class="ver shake"><i class="bi bi-cart-fill"></i> Ver Carrinho</a>
@endif
<div class="cardapio">
    @foreach ($products as $product)
        <div class="p">
            @if($product->image)
                <img  class="img" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
            @endif
            <h2>{{ $product->name }}</h2>
            <p>{{ $product->description }}</p>
            <div class="cardapio-flex">
                <p class="price">R$ {{ number_format($product->price, 2, ',', '.') }}</p>
                <form class="form" action="{{ url('/cart/add/'.$product->id) }}" method="POST">
                    @csrf
                    <button class="add" type="submit"><i class="bi bi-cart-plus-fill"></i> Adicionar ao Carrinho</button>
                </form>
            </div>
        </div>        
    @endforeach
</div>


@endsection