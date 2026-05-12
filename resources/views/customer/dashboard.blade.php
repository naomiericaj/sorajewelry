@extends('layouts.app', ['title' => 'My Account - Sora Jewelry'])

@section('styles')
<style>
    .dashboard {
        max-width: 900px;
        margin: 40px auto;
    }

    .dashboard-title {
        font-size: 30px;
        font-weight: 400;
        margin-bottom: 30px;
    }

    .cards {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 18px;
    }

    .card {
        background: white;
        padding: 25px;
        min-height: 130px;
    }

    .card h3 {
        font-weight: 400;
        margin-top: 0;
    }

    .card p {
        color: #555;
        line-height: 1.6;
    }

    @media (max-width: 800px) {
        .cards {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')

<div class="dashboard">
    <h1 class="dashboard-title">My Account</h1>

    <p>Hello, {{ $user->name }}.</p>

    <div class="cards">
        <div class="card">
            <h3>Profile</h3>
            <p>{{ $user->email }}</p>
            <p>{{ $user->phone ?? 'No phone added' }}</p>
        </div>

        <div class="card">
            <h3>Orders</h3>
            <p>Your order history will appear here.</p>
        </div>

        <div class="card">
            <h3>Wishlist</h3>
            <p>Your saved jewelry items will appear here.</p>
        </div>
    </div>
</div>

@endsection