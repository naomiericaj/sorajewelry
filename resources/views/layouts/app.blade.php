<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Sora Jewelry' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500&family=Cormorant+Garamond:wght@400;500;600&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">
    
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

        .nav-left a,
        .nav-right a,
        .nav-button {
            font-family: 'Cormorant Garamond', serif;
            font-size: 20px;
            font-weight: 1000;
            letter-spacing: 0.5px;
        }
        
        .account-dropdown {
    position: relative;
    display: inline-flex;
    align-items: center;
}

.account-dropdown-btn {
    background: none;
    border: none;
    cursor: pointer;
    color: #333;
    padding: 0;
    font-family: 'Cormorant Garamond', serif;
    font-size: 20px;
    font-weight: 1000;
    letter-spacing: 0.5px;
    display: flex;
    align-items: center;
    gap: 6px;
    transition: 0.3s ease;
}

.account-dropdown-btn:hover {
    color: #b89b5e;
    transform: scale(1.08);
}

.account-dropdown-menu {
    position: absolute;
    top: 32px;
    right: 0;
    min-width: 180px;
    background: #fff;
    border: 1px solid #e4e4df;
    box-shadow: 0 14px 34px rgba(0, 0, 0, 0.14);
    padding: 8px 0;
    opacity: 0;
    visibility: hidden;
    transform: translateY(8px);
    transition: 0.25s ease;
    z-index: 100000;
}

.account-dropdown:hover .account-dropdown-menu {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

.account-dropdown-menu a,
.account-dropdown-menu button {
    width: 100%;
    display: block;
    padding: 11px 16px;
    border: none;
    background: white;
    color: #111;
    text-align: left;
    font-family: 'Cormorant Garamond', serif;
    font-size: 18px;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    transition: 0.2s ease;
}

.account-dropdown-menu a:hover,
.account-dropdown-menu button:hover {
    background: #f8f8f6;
    color: #b89b5e;
}

.account-dropdown-menu form {
    margin: 0;
}

        .search-bar {
            font-family: 'Cormorant Garamond', serif;
            font-size: 14px;
        }

        .navbar {
        height: 75px;
        display: grid;
        grid-template-columns: 1fr auto 1fr;
        align-items: center;
        padding: 0px 38px;
        background: #edede9;
        position: sticky;
        top: 0;
        z-index: 100;
    }

        .nav-left {
            display: flex;
            gap: 28px;
            align-items: center;
            justify-content: flex-start;
            height: 100%;
        }

        .nav-left a {
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

    .nav-left a::after {
        content: '';

        position: absolute;
        left: 0;
        bottom: -6px;

        width: 0%;
        height: 1px;

        background: #b89b5e;

        transition: 0.3s ease;
    }

    .nav-left a:hover::after {
        width: 100%;
    }

    .logo img {
        height: 220px;
        width: auto;
        object-fit: contain;

        position: relative;
        top: -64px;

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
            height: 100%;
        }

    .nav-button {
        background: none;
        border: none;
        cursor: pointer;
        color: #333;
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
        .cart-count,
.wishlist-count {
    position: absolute;
    top: -10px;
    right: -12px;
    background: black;
    color: white;
    min-width: 21px;
    height: 21px;
    padding: 0 5px;
    border-radius: 999px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    line-height: 1;
}

        .page {
            padding: 24px 38px 60px;
        }

        .footer {
            padding: 40px 38px;
            color: #777;
            font-size: 14px;
        }

        .nav-right a,
        .nav-left a,
        .nav-button,
        .icon,
        .search-toggle {
            display: flex;
            align-items: center;
        }

        .nav-left,
        .nav-right{
            height: 100%;
            display: flex;
            align-items: center;
            position: relative;
            top: -70px;
        }

        .logo {
            height: 100%;
            display: flex;
            align-items: center;
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

        .navbar-search {
    display: flex;
    align-items: center;
    height: 38px;
    border: 1px solid #d8d8d4;
    background: transparent;
    margin-left: 18px;
}

.navbar-search input {
    width: 190px;
    height: 100%;
    border: none;
    outline: none;
    background: transparent;
    padding: 0 12px;
    font-size: 14px;
    color: #111;
}

.navbar-search input::placeholder {
    color: #999;
}

.navbar-search button {
    height: 100%;
    border: none;
    border-left: 1px solid #d8d8d4;
    background: #111;
    color: white;
    padding: 0 14px;
    cursor: pointer;
    font-size: 13px;
}

.navbar-search button:hover {
    background: #333;
}

@media (max-width: 800px) {
    .navbar-search {
        width: 100%;
        margin: 14px 0 0;
    }

    .navbar-search input {
        width: 100%;
    }

    /* Add to cart / wishlist animation */
.floating-toast {
    position: fixed;
    top: 95px;
    right: 28px;
    background: #111;
    color: white;
    padding: 14px 20px;
    font-size: 14px;
    z-index: 99999;
    opacity: 0;
    transform: translateY(-15px);
    pointer-events: none;
    transition: 0.3s ease;
}

.floating-toast.show {
    opacity: 1;
    transform: translateY(0);
}

.cart-bounce,
.wishlist-bounce {
    animation: iconBounce 0.45s ease;
}

@keyframes iconBounce {
    0% {
        transform: scale(1);
    }

    40% {
        transform: scale(1.35);
    }

    100% {
        transform: scale(1);
    }
}

.ajax-loading {
    opacity: 0.6;
    pointer-events: none;
}
}
    </style>

    @yield('styles')
    <div id="floating-toast" class="floating-toast"></div>

<script>
    document.addEventListener('submit', function (event) {
        const form = event.target;

        const isCart = form.classList.contains('ajax-cart-form');
        const isWishlist = form.classList.contains('ajax-wishlist-form');

        if (!isCart && !isWishlist) {
            return;
        }

        event.preventDefault();

        const button = form.querySelector('button[type="submit"]');

        if (!button) {
            return;
        }

        const originalText = button.dataset.originalText || button.innerHTML;

        form.classList.add('ajax-loading');

        fetch(form.action, {
            method: form.method || 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: new FormData(form)
        })
        .then(response => {
            if (response.status === 401 || response.status === 419) {
                window.location.href = "{{ route('login') }}";
                return;
            }

            return response.json();
        })
        .then(data => {
            form.classList.remove('ajax-loading');

            if (!data || !data.success) {
                button.innerHTML = '!';
                setTimeout(() => {
                    button.innerHTML = originalText;
                }, 1200);
                return;
            }

            button.classList.add('added');
            button.innerHTML = '✓';

            setTimeout(() => {
                button.classList.remove('added');
                button.innerHTML = originalText;
            }, 1400);

            if (data.cart_count !== undefined) {
                const cartCount = document.querySelector('.cart-count');

                if (cartCount) {
                    cartCount.textContent = data.cart_count;
                }
            }

            if (data.wishlist_count !== undefined) {
                const wishlistCount = document.querySelector('.wishlist-count');

                if (wishlistCount) {
                    wishlistCount.textContent = data.wishlist_count;
                }
            }
        })
        .catch(error => {
            form.classList.remove('ajax-loading');

            button.innerHTML = '!';
            setTimeout(() => {
                button.innerHTML = originalText;
            }, 1200);

            console.error(error);
        });
    });
</script>

<script>
    document.addEventListener('click', function (event) {
        if (event.target.closest('.product-action-icons')) {
            event.preventDefault();
            event.stopPropagation();
        }
    });
</script>
</head>
<body>

<header class="navbar">
    <nav class="nav-left">
    <a href="{{ route('home') }}">Home</a>
    <a href="{{ route('products.index') }}">Catalogue</a>
    
@auth
    @if(Auth::user()->role !== 'admin')
        <a href="{{ route('customer.orders.index') }}">My Orders</a>
    @endif
@else
    <a href="{{ route('login') }}">My Orders</a>
@endauth

    <a href="{{ route('contact') }}">About</a>
</nav>

    <a href="{{ route('home') }}" class="logo">
        <img src="{{ asset('images/sora-logo (1).png') }}" alt="Sora Logo">
    </a>

    <div class="nav-right">
        @auth
    <div class="account-dropdown">
        <button type="button" class="account-dropdown-btn">
            @if(Auth::user()->role === 'admin')
                Admin
            @else
                Account
            @endif
            <span>⌄</span>
        </button>

        <div class="account-dropdown-menu">
            @if(Auth::user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}">
                    Admin Dashboard
                </a>
            @else
                <a href="{{ route('customer.dashboard') }}">
                    Profile
                </a>

                <!--<a href="{{ route('customer.orders.index') }}">-->
                <!--    My Orders-->
                <!--</a>-->
            @endif

            <form action="{{ route('logout') }}" method="POST">
                @csrf

                <button type="submit">
                    Logout
                </button>
            </form>
        </div>
    </div>
@else
    <a href="{{ route('login') }}">Login</a>
    <a href="{{ route('register') }}">Register</a>
@endauth

      <form action="{{ route('products.index') }}" method="GET" class="navbar-search">
    <input
        type="text"
        name="search"
        placeholder="Search jewelry..."
        value="{{ request('search') }}"
    >

    <button type="submit">
        Search
    </button>
</form>      
       @auth
    <a href="{{ route('wishlist.index') }}" class="icon">
        ♡
        <span class="wishlist-count">
            {{ \App\Models\Wishlist::where('user_id', auth()->id())->count() }}
        </span>
    </a>

    <a href="{{ route('cart.index') }}" class="icon">
        🛍
        <span class="cart-count">{{ $cartCount ?? 0 }}</span>
    </a>
@else
    <a href="{{ route('login') }}" class="icon">
        ♡
        <span class="wishlist-count">0</span>
    </a>

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
    © {{ date('Y') }} Sora Jewelry. All rights reserved.
</footer>

</body>
</html>
