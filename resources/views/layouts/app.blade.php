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
            font-family: "Cormorant Garamond", serif;
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
        overflow: visible;
    }

        .nav-left {
            display: flex;
            gap: 28px;
            align-items: center;
        }

        .nav-left a {
        font-size: 18px;
        color: #333;

        position: relative;

        transition: 0.3s ease;
    }
        .nav-left a:hover {
        color: #b89b5e;

        transform: scale(1.08);
    }
    .nav-right a {
    position: relative;
    font-size: 18px;
    transition: 0.3s ease;
    }

    .nav-right a:hover {
        color: #b89b5e;
        transform: scale(1.08);
    }

    .nav-right a::after {
        content: '';

        position: absolute;
        left: 0;
        bottom: -6px;

        width: 0%;
        height: 1px;

        background: #b89b5e;

        transition: 0.3s ease;
    }

    .nav-right a:hover::after {
        width: 100%;
    }

        .logo {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .logo img {
        height: 110px;
        width: auto;
        object-fit: contain;

        position: relative;
        top: 8px;

        transition: 0.3s ease;
    }

    .logo img:hover {
        transform: scale(1.05);
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
        font-size: 18px;
        padding: 0;

        position: relative;

        transition: 0.3s ease;
    }

    .nav-button:hover {
        color: #b89b5e;
        transform: scale(1.08);
    }

    .nav-button::after {
        content: '';

        position: absolute;
        left: 0;
        bottom: -6px;

        width: 0%;
        height: 1px;

        background: #b89b5e;

        transition: 0.3s ease;
    }

    .nav-button:hover::after {
        width: 100%;
    }

    .icon {
            font-size: 18px;
            position: relative;
        }
        .search-container {
    position: relative;
    display: flex;
    align-items: center;
    }

    .search-toggle {
        background: none;
        border: none;
        font-size: 18px;
        cursor: pointer;

        transition: 0.3s ease;
    }

    .search-toggle:hover {
        color: #b89b5e;
        transform: scale(1.1);
    }

        .search-bar {
        width: 0;
        opacity: 0;

        padding: 8px 12px;

        border: 1px solid #ccc;
        border-radius: 30px;

        outline: none;

        transition: 0.4s ease;

        margin-left: 10px;
    }

    .search-bar.active {
        width: 180px;
        opacity: 1;
    }
    .search-container:hover .search-bar {
        width: 180px;
        opacity: 1;
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
        <a href="{{ route('contact') }}">Contact</a>
    </nav>

    <a href="{{ route('home') }}" class="logo">
    <img src="{{ asset('images/sora-logo (1).png') }}" alt="Sora Logo">
</a>

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

            <div class="search-container">

        <button class="search-toggle" onclick="toggleSearch()">
            ⌕
        </button>

        <input type="text"
            placeholder="Search jewelry..."
            class="search-bar"
            id="searchBar">

    </div>
        @auth
    <a href="{{ route('wishlist.index') }}" class="icon">♡</a>

    <a href="{{ route('cart.index') }}" class="icon">
        🛍
        <span class="cart-count">{{ $cartCount ?? 0 }}</span>
    </a>
@else
    <a href="{{ route('login') }}" class="icon">♡</a>

    <a href="{{ route('login') }}" class="icon">
        🛍
        <span class="cart-count">0</span>
    </a>
@endauth
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

@auth
    <a href="{{ route('wishlist.index') }}">Wishlist</a>
    <a href="{{ route('cart.index') }}">Cart</a>
    <a href="{{ route('customer.orders.index') }}">My Orders</a>

    @if(Auth::user()->role === 'admin')
        <a href="{{ route('admin.dashboard') }}">Admin</a>
    @endif
@endauth