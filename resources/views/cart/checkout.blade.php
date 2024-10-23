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

    <form action="{{ url('/pedidos') }}" method="POST">
        @csrf
        <div>
            <label for="rua">Rua:</label>
            <input type="text" name="rua" required>
        </div>
        <div>
            <label for="numero">Número:</label>
            <input type="text" name="numero" required>
        </div>
        <div>
            <label for="cep">CEP:</label>
            <input type="text" name="cep" required>
        </div>
        <div>
            <label for="cidade">Cidade:</label>
            <input type="text" name="cidade" required>
        </div>
        <div>
            <label for="complemento">Complemento:</label>
            <input type="text" name="complemento">
        </div>
        <div>
            <label for="forma_pagamento">Forma de Pagamento:</label>
            <select name="forma_pagamento" required>
                <option value="cartao">Cartão de Crédito</option>
                <option value="boleto">Boleto</option>
                <option value="paypal">PayPal</option>
            </select>
        </div>
        <button type="submit">Finalizar Compra</button>
    </form>

    @else
        <p>Carrinho vazio!</p>
    @endif
@else
    <p>Você precisa estar logado para finalizar a compra!</p>
    <a href="{{ url('/login') }}">Login</a>
@endif