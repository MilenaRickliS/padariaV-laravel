<h1>Finalizar Compra</h1>

@if (auth()->check())
    <p>Olá, {{ auth()->user()->name }}!</p>
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
        <p>Total: R$ {{ Session::get('total', 0) }}</p>
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