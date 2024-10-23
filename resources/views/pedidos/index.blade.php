@extends('layouts.app')

@section('content')
    <h1>Minhas Compras</h1>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    <ul>
        @foreach($pedidos as $pedido)
            <li>Pedido ID:{{$pedido->id }} - Valor: R$ {{$pedido->valor}}</li>
        @endforeach
    </ul>
@endsection