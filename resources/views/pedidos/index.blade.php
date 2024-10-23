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
            <li>
                Pedido ID:{{$pedido->id }} - Valor: R$ {{$pedido->valor}}
                <ul>
                    @foreach($pedido->itens as $item)
                        <li>
                            Produto: {{$item->product->name}} - Quantidade: {{$item->quantidade}}
                        </li>
                    @endforeach
                </ul>
                <p>Endereço: 
                    @if($pedido->endereco)
                        {{$pedido->endereco->rua}}, {{$pedido->endereco->numero}}, {{$pedido->endereco->cidade}} - {{$pedido->endereco->cep}} ({{$pedido->endereco->complemento}})
                    @else
                        Endereço não disponível
                    @endif
                </p>
                <p>Forma de Pagamento: 
                    @if($pedido->endereco)
                        {{$pedido->endereco->forma_pagamento}}
                    @else
                        Informação de pagamento não disponível
                    @endif
                </p>
            </li>
        @endforeach
    </ul>
@endsection