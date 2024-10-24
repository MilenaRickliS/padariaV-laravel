<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Panificadora Vitória')</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="estilo.css">
    <link rel="stylesheet" href="{{ asset('estilo.css') }}">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <div class="menu">
                    <li><a href="{{ route('products.cardapio') }}"><i class="bi bi-list"></i> Cardápio</a></li>
                    <li><a href="{{ route('pedidos.index') }}"><i class="bi bi-bag-check-fill"></i> Minhas Compras</a></li>
                </div>
                <div class="menu">
                    @if (Auth::check())
                    <li>
                        <form action="{{ route('logout') }}" method="POST" >
                            @csrf
                            <button class="logout" type="submit"><i class="bi bi-escape"></i> Logout</button>
                        </form>
                    </li>                    
                    @else
                        <li><a href="{{ route('login') }}"><i class="bi bi-person-circle"></i>  Login</a></li>
                        <li><a href="{{ route('register') }}"><i class="bi bi-person-plus"></i> Register</a></li>
                    @endif
                </div>
            </ul>
        </nav>
    </header>
    <main>
        @yield('content')
    </main>
    <footer>
        <div class="footer-flex">
            <div class="footer-info">
                <p><i class="bi bi-house-fill"></i> Endereço: Rua Bento Munhoz da Rocha Neto, n° 1028</p>
                <p><i class="bi bi-telephone-fill"></i> Telefone: 42 99984134953</p>
                <p><i class="bi bi-bag-check-fill"></i> Diversos tipos de pães! Faça o seu pedido!</p>
            </div>
            <div>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1860954.8724583685!2d-51.68594295014845!3d-24.35772474143706!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94ef4fd942cd30a1%3A0x37922f66db5604a5!2sPanificadora%20Vit%C3%B3ria!5e0!3m2!1spt-BR!2sbr!4v1729787118906!5m2!1spt-BR!2sbr" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
        <div class="footer-flex2">
            <div>
                 <p class="bemvindo">Bem-vindo!</p>
                    
            </div>
            <div>
                <img src="./logo_da_padaria.png" alt="logo-padaria" width="100px" height="auto"/>
            </div>
            <div>
                <p><i class="bi bi-envelope-fill"></i> panificadora_vitoria@hotmail.com</p>
                <p><i class="bi bi-telephone-fill"></i> (42) 98413-4953</p>
            </div>
        </div>
    </footer>
</body>
</html>