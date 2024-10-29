@extends('layouts.app')

@section('content')
    <h1>Minhas Compras</h1>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($pedidos->isEmpty())
        <div class="alert alert-info">Nenhum pedido feito<i class="bi bi-emoji-frown-fill"></i></div>
    @else
    <ul class="pedidos">
        @foreach($pedidos as $pedido)
            <li class="pedido">
                <div>
                    <p>Pedido ID:{{$pedido->id }} - Valor: R$ {{$pedido->valor}}</p>
                    <ul class="pedido-produtos">
                        @foreach($pedido->itens as $item)
                            <li class="p-prod">
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
                </div>
                <div>
                    <p class="entregue"><i class="bi bi-bag-check-fill"></i></p>
                </div>
            </li>
        @endforeach
    </ul>
    @endif
@endsection