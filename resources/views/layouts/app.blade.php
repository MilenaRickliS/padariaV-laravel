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
</body>
</html>