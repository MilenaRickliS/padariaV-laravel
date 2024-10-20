<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Panificadora Vitória')</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <header>
        <h1>Panificadora Vitória</h1>
    </header>
    <main>
        @if (Auth::check())
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button class="logout" type="submit">Logout</button>
            </form>        
        @endif
        @yield('content')
    </main>
</body>
</html>