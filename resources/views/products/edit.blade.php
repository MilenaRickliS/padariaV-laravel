@extends('layouts.app')

@section('content')
    <h1>Editar Produto</h1>
    @if(isset($product) && $product->id)
    <form action="{{ route('products.update', ['id' => $product->id]) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <label for="name">Nome:</label>
        <input type="text" name="name" id="name" value="{{$product->name}}" required>
        <br>
        <label for="description">Descrição:</label>
        <textarea name="description" id="description">{{$product->description}}</textarea>
        <br>
        <label for="price">Preço:</label>
        <input type="number" step="0.01" name="price" id="price" value="{{$product->price}}" required>
        <br>
        <label for="image">Imagem:</label>
        @if($product->image)
            <div>
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width: 100px; height: auto;">
                <p>Imagem atual</p>
            </div>
        @endif
        <input type="file" name="image" accept="image/*">
        <br>
        <button type="submit">Salvar</button>
    </form>
    @else
        <p>Product not found.</p>
    @endif
@endsection