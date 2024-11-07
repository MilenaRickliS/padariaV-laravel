<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Panificadora Vitória')</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="estilo.css">
    <link rel="stylesheet" href="{{ asset('estilo.css') }}">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
<header>
    <nav class="navbar navbar-expand-lg">
        <a class="navbar-brand" href="{{ route('products.cardapio') }}">Panificadora Vitória</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('products.cardapio') }}">
                        <i class="bi bi-list"></i> Cardápio
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('pedidos.index') }}">
                        <i class="bi bi-bag-check-fill"></i> Minhas Compras
                    </a>
                </li>
                @if (Auth::check())
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button class="btn btn-link nav-link logout" type="submit"><i class="bi bi-escape"></i> Logout</button>
                    </form>
                </li>
                @else
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">
                        <i class="bi bi-person-circle"></i> Login
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">
                        <i class="bi bi-person-plus"></i> Register
                    </a>
                </li>
                @endif
            </ul>
        </div>
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
                <p>CNPJ 73.920.076/0001-09</p>
            </div>
        </div>
    </footer>
</body>
</html>