<h1>Carrinho de Compras</h1>

@if (Session::has('cart'))
    <table>
        <thead>
            <tr>
                <th>Produto</th>
                <th>Quantidade</th>
                <th>Preço</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach (Session::get('cart') as $id => $quantity)
                @php
                    $product = App\Models\Product::find($id);
                @endphp
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $quantity }}</td>
                    <td>R$ {{ number_format($product->price, 2, ',', '.') }}</td>
                    <td>
                        <form action="{{ url('/cart/remove/'.$id) }}" method="GET" style="display:inline;">
                            @csrf
                            <button type="submit">Remover</button>
                        </form>
                        <form action="{{ url('/cart/decrease/'.$id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit">Diminuir</button>
                        </form>
                        <form action="{{ url('/cart/add/'.$id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit">Adicionar mais</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <p>Total: R$ {{ number_format(array_sum(array_map(function($id) {
        $product = App\Models\Product::find($id);
        return $product ? $product->price * Session::get('cart')[$id] : 0; // Verifica se o produto existe
    }, array_keys(Session::get('cart')))), 2, ',', '.') }}</p>
    <a href="{{ url('/cart/checkout') }}">Finalizar Compra</a>
@else
    <p>Carrinho vazio!</p>
@endif