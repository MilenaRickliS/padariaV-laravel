<style>
.logout{
    border-radius: 20px;
    border: none;
    margin-top: 20px;
    margin-bottom: 20px;
    padding: 10px;
    background-color: #000;
    color: #797979;
    font-weight: 400;
    transition: .2s;
}

.logout:hover{
    cursor: pointer;
    background-color: #2c2c2c;
    color: #fff;
}
.formulario{
    box-shadow: rgba(0, 0, 0, 0.25) 0px 54px 55px, rgba(0, 0, 0, 0.12) 0px -12px 30px, rgba(0, 0, 0, 0.12) 0px 4px 6px, rgba(0, 0, 0, 0.17) 0px 12px 13px, rgba(0, 0, 0, 0.09) 0px -3px 5px;
    margin: 10px;
    padding: 20px;
    border-radius: 15px;
    width: 90%;
    }
.inputs{
    margin: 5px;
    padding: 5px;
    border-radius: 15px;
    width: 85%;
    max-width: 670px;
    }
.titulos{
    font-weight: 700;
    text-align: center;
}
.salvar{
    background-color: #499F68;
    color: #000;
    font-weight: 700;
    text-decoration: none;
    padding: 5px;
    margin: 8px 0px;
    border-radius: 15px;
    transition: .2s;
    width: 100px;
    cursor: pointer;
    border: none;
}
.salvar:hover{
    background-color: #9DD2B1;
}
.voltar{
    background-color: #aec200;
}
.voltar:hover{
    background-color: #6e8117;
}

</style>

@extends('layouts.app')

@section('content')

    <h1>Editar Produto</h1>
    @if(isset($product) && $product->id)
    <form action="{{ route('products.update', ['id' => $product->id]) }}" method="post" enctype="multipart/form-data" class="formulario">
        @csrf
        @method('PUT')
        <label class="titulos" for="name">Nome:</label>
        <input class="inputs" type="text" name="name" id="name" value="{{$product->name}}" required>
        <br>
        <label class="titulos" for="description">Descrição:</label>
        <textarea class="inputs" name="description" id="description">{{$product->description}}</textarea>
        <br>
        <label class="titulos" for="price">Preço:</label>
        <input  class="inputs" type="number" step="0.01" name="price" id="price" value="{{$product->price}}" required>
        <br>
        <label class="titulos" for="image">Imagem:</label>
        @if($product->image)
            <div>
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width: 100px; height: auto;">
                <p>Imagem atual</p>
            </div>
        @endif
        <input class="inputs" type="file" name="image" accept="image/*">
        <br>
        <button class="salvar" type="submit">Salvar</button>
    </form>

    @else
        <p>Product not found.</p>
    @endif
    <a href="{{ route('products.index') }}" class="btn btn-secondary voltar"><-- Voltar para lista de produtos</a>
@endsection