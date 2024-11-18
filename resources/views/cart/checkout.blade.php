@extends('layouts.app')

@section('content')

    <h1>Finalizar Compra</h1>

    <div class="finalizar">
    @if (auth()->check())
        <p class="titulo-finalizar">Olá, {{ auth()->user()->name }}!</p>
        <div class="final-flex">
            <p class="titulo-final">Seu carrinho</p>
            <p class="titulo-final">Total: R$ {{ number_format(array_sum(array_map(function($id) {
                $product = App\Models\Product::find($id);
                return $product ? $product->price * Session::get('cart')[$id] : 0; // Verifica se o produto existe
            }, array_keys(Session::get('cart')))), 2, ',', '.') }}</p>
        </div>
        @if (Session::has('cart'))
            <table class="finalizar-carrinho">
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
                            <td>R$ {{ number_format($product->price, 2, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <br><br>
            <p class="titulo-finalizar">Adicionar Endereço e Pagamento</p>
            
        <form class="form-finalizar" action="{{ url('/pedidos') }}" method="POST">
            @csrf
            <div>
                <label for="cep">CEP:</label>
                <input type="text" id="cep" name="cep" required placeholder="00000-000" onblur="buscarEndereco()">
                <br>
                @error('cep')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="cidade">Cidade:</label>
                <input type="text" id="cidade" name="cidade" required placeholder="Cidade">
                <br>
                @error('cidade')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="estado">Estado:</label>
                <input type="text" id="estado" name="estado" required placeholder="Estado" >
                <br>
                @error('estado')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="rua">Rua:</label>
                <input type="text" id="rua" name="rua" required placeholder="Avenida/Rua">
                <br>
                @error('rua')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="numero">Número:</label>
                <input type="text" name="numero" required placeholder="123">
                <br>
                @error('numero')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="complemento">Complemento (Opcional):</label>
                <input type="text" name="complemento" placeholder="Complemento">
                <br>
                @error('complemento')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="forma_pagamento">Forma de Pagamento:</label>
                <select name="forma_pagamento" required>
                    <option value="cartao">Cartão de Crédito</option>
                    <option value="boleto">Boleto</option>
                    <option value="pix">Pix</option>
                    <option value="dinheiro">Dinheiro</option>
                    <option value="voucher">Voucher</option>
                </select>
                <br>
                @error('forma_pagamento')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <button class="button-final" type="submit">Finalizar Compra</button>
        </form>

        @else
        <h1 style="color: red"><i class="bi bi-emoji-frown-fill"></i> Carrinho vazio!</h1>
        @endif
    @else
        <h1>Você precisa estar logado para finalizar a compra!</h1>
        <a href="{{ url('/login') }}">Login</a>
    @endif
    </div>

    <script>
        function buscarEndereco() {
            var cep = document.getElementById('cep').value.replace(/\D/g, '');

            if (cep.length === 8) {
                var url = 'https://viacep.com.br/ws/' + cep + '/json/';

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    if (!data.erro) {
                        // Preencher os campos com os dados retornados pela API
                        document.getElementById('rua').value = data.logradouro;
                        document.getElementById('cidade').value = data.localidade;
                        document.getElementById('estado').value = data.uf;
                        
                    
                    } else {
                        alert('CEP não encontrado.');
                        document.getElementById('rua').value = '';
                        document.getElementById('cidade').value = '';
                    }
                })
                .catch(error => {
                    console.error('Erro ao buscar o CEP:', error);
                    alert('Erro ao buscar o CEP. Tente novamente mais tarde.');
                });
            } else {
                alert('CEP inválido. Deve conter 8 dígitos.');
            }
}
</script>
@endsection