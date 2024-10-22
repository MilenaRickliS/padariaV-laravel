<h1>Finalizar Compra</h1>

@if (auth()->check())
    <p>Olá, {{ auth()->user()->name }}!</p>

    @if (auth()->user()->email === 'admin@example.com')
        <p><a href="{{ url('/products') }}">Ir para Produtos</a></p>
    @endif
    <p>Seu carrinho:</p>
    @if (Session::has('cart'))
        <table>
            <thead>
                <tr>
                    <th>Produto</th>
                    <th>Quantidade</th>
                    <th>Preço</th>
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
                        <td>R$ {{ $product->price }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <p>Total: R$ {{ number_format(array_sum(array_map(function($id) {
        $product = App\Models\Product::find($id);
        return $product ? $product->price * Session::get('cart')[$id] : 0; // Verifica se o produto existe
    }, array_keys(Session::get('cart')))), 2, ',', '.') }}</p>
        <form action="{{ url('/order') }}" method="POST">
            @csrf
            <button type="submit">Finalizar Compra</button>
        </form>
    @else
        <p>Carrinho vazio!</p>
    @endif
@else
    <p>Você precisa estar logado para finalizar a compra!</p>
    <a href="{{ url('/login') }}">Login</a>
@endif