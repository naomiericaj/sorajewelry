<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Sora Jewelry' }}</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: #f8f8f6;
            color: #222;
            font-size: 15px;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        button {
            font-family: inherit;
        }

        .navbar {
            height: 70px;
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            align-items: center;
            padding: 0 38px;
            background: #f8f8f6;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .nav-left {
            display: flex;
            gap: 28px;
            align-items: center;
        }

        .nav-left a {
            font-size: 15px;
            color: #333;
        }

        .logo {
            font-family: Georgia, serif;
            font-style: italic;
            font-size: 34px;
            letter-spacing: 2px;
            font-weight: 400;
        }

        .nav-right {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 18px;
        }

        .nav-button {
            background: none;
            border: none;
            cursor: pointer;
            color: #333;
            font-size: 15px;
            padding: 0;
        }

        .icon {
            font-size: 18px;
            position: relative;
        }

        .cart-count {
            position: absolute;
            top: -10px;
            right: -12px;
            background: black;
            color: white;
            width: 21px;
            height: 21px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
        }

        .page {
            padding: 24px 38px 60px;
        }

        .footer {
            padding: 40px 38px;
            color: #777;
            font-size: 14px;
        }

        @media (max-width: 768px) {
            .navbar {
                grid-template-columns: 1fr;
                height: auto;
                gap: 15px;
                padding: 20px;
            }

            .nav-left,
            .nav-right {
                justify-content: center;
                flex-wrap: wrap;
            }

            .logo {
                text-align: center;
                font-size: 30px;
            }

            .page {
                padding: 20px;
            }
        }
    </style>

    @yield('styles')
</head>
<body>

<header class="navbar">
    <nav class="nav-left">
        <a href="{{ route('home') }}">Home</a>
        <a href="{{ route('products.index') }}">Catalogue</a>
        <a href="#">Collections</a>
        <a href="#">Contact</a>
    </nav>

    <a href="{{ route('home') }}" class="logo">Sora</a>

    <div class="nav-right">
        @auth
            @if(Auth::user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}">Admin</a>
            @else
                <a href="{{ route('customer.dashboard') }}">Account</a>
            @endif

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="nav-button">Logout</button>
            </form>
        @else
            <a href="{{ route('login') }}">Login</a>
            <a href="{{ route('register') }}">Register</a>
        @endauth

        <a href="#" class="icon">⌕</a>
        <a href="#" class="icon">♡</a>
        <a href="#" class="icon">
            🛍
            <span class="cart-count">0</span>
        </a>
    </div>
</header>

<main class="page">
    @yield('content')
</main>

<footer class="footer">
    © {{ date('Y') }} Sora Jewelry
</footer>

</body>
</html>