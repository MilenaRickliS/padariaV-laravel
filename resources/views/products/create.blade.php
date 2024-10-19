@extends('layouts.app')

@section('content')
    <h1>Criar Produto</h1>
    <form action="{{ route('products.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <label for="name">Nome:</label>
        <input type="text" name="name" id="name" required>
        <br>
        <label for="description">Descrição:</label>
        <textarea name="description" id="description"></textarea>
        <br>
        <label for="price">Preço:</label>
        <input type="number" step="0.01" name="price" id="price" required>
        <br>
        <label for="image">Imagem:</label>
        <input type="file" name="image" accept="image/*">
        <br>
        <button type="submit">Salvar</button>
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
@endsection