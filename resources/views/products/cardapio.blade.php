@extends('layouts.app')

@section('content')
<h1>Lista de Produtos</h1>

<div class="produtos">
    @foreach ($products as $product)
        <div class="prod">
            <h2>{{ $product->name }}</h2>
            <p>{{ $product->description }}</p>
            <p>R$ {{ number_format($product->price, 2, ',', '.') }}</p>
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width: 100px; height:auto;">
            @endif
            <form action="{{ url('/cart/add/'.$product->id) }}" method="POST">
                @csrf
                <button type="submit">Adicionar ao Carrinho</button>
            </form>
        </div>        
    @endforeach
</div>

@if (session('item_added'))
    <a href="{{ url('/cart') }}" class="btn btn-primary">Ver Carrinho</a>
@endif
@endsection