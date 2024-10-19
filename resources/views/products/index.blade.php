@extends('layouts.app')
    <style>
        .produtos{
            display: flex;
            justify-content: center;
            align-items: center;
            width: 80%;
        }
        .prod{
            box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
            margin: 10px;
            padding: 20px;
            border-radius: 15px;
        }
        .editar{
            background-color: #FDFF99;
            color: #000;
            font-weight: 700;
            text-decoration: none;
            padding: 5px;
            margin: 8px 0px;
            border-radius: 15px;
            transition: .2s;
        }
        .editar:hover{
            background-color: #FCFF33;
        }
        .excluir{
            background-color: #C7A8AD;
            color: #000;
            font-weight: 700;
            border: none;
            padding: 5px;
            margin: 8px 0px;
            border-radius: 15px;
            transition: .2s;
        }
        .excluir:hover{
            background-color: #AF838A;
        }
        .criar{
            background-color: #D89D6A;
            color: #000;
            font-weight: 700;
            text-decoration: none;
            padding: 5px;
            margin: 8px 0px;
            border-radius: 15px;
            transition: .2s;
        }
        .criar:hover{
            background-color: #C37632;
        }
    </style>
    @section('content')
    <h1>Lista de Produtos</h1>
    <a class="criar" href="{{ route('products.create') }}">Criar Produto</a>
    <div class="produtos">
    @foreach ($products as $product)
        <div class="prod">
            <h2>{{ $product->name }}</h2>
            <p>{{ $product->description }}</p>
            <p>R$ {{ number_format($product->price, 2, ',', '.') }}</p>
            @if($product->image)
                <img src="{{asset('storage/' . $product->image)}}" alt="{{$product->name}}" style="width: 100px; height:auto;">
            @endif
            <br>
            <br>
            <a class="editar" href="{{ route('products.edit', $product->id) }}">Editar Produto</a>
            <form action="{{ route('products.destroy', $product->id) }}" method="post">
                @csrf
                @method('DELETE')
                <button class="excluir" type="submit">Excluir Produto</button>
            </form>
        </div>

        
    @endforeach
    </div>
   
@endsection