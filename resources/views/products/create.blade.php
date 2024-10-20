@extends('layouts.app')

@section('content')
    <h1>Criar Produto</h1>
    <form action="{{ route('products.store') }}" method="post" enctype="multipart/form-data" class="formulario">
        @csrf
        <label class="titulos" for="name">Nome:</label>
        <input class="inputs" type="text" name="name" id="name" required>
        <br>
        <label class="titulos"  for="description">Descrição:</label>
        <textarea class="inputs" name="description" id="description"></textarea>
        <br>
        <label class="titulos"  for="price">Preço:</label>
        <input class="inputs" type="number" step="0.01" name="price" id="price" required>
        <br>
        <label class="titulos"  for="image">Imagem:</label>
        <input class="inputs" type="file" name="image" accept="image/*">
        <br>
        <button  class="salvar" type="submit">Salvar</button>
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    </form>
    <a href="{{ route('products.index') }}" class="btn btn-secondary voltar" ><-- Voltar para lista de produtos</a>
@endsection