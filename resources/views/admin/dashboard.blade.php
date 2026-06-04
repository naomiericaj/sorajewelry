{{-- @extends('layouts.app', ['title' => 'Admin Dashboard - Sora Jewelry'])

@section('styles')
<style>
    .admin-dashboard {
        max-width: 1100px;
        margin: 40px auto;
    }

    .admin-title {
        font-size: 30px;
        font-weight: 400;
        margin-bottom: 30px;
    }

    .stat-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 18px;
        margin-bottom: 35px;
    }

    .stat-card {
        background: white;
        padding: 28px;
    }

    .stat-number {
        font-size: 34px;
        margin-bottom: 8px;
    }

    .stat-label {
        color: #555;
    }

    .admin-menu {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 18px;
    }

    .menu-card {
        background: #111;
        color: white;
        padding: 25px;
        display: block;
    }

    .menu-card h3 {
        margin-top: 0;
        font-weight: 400;
    }

    .menu-card p {
        color: #ddd;
        line-height: 1.6;
    }

    @media (max-width: 800px) {
        .stat-grid,
        .admin-menu {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')

<div class="admin-dashboard">
    <h1 class="admin-title">Admin Dashboard</h1>

    <div class="stat-grid">
        <div class="stat-card">
            <div class="stat-number">{{ $totalProducts }}</div>
            <div class="stat-label">Products</div>
        </div>

        <div class="stat-card">
            <div class="stat-number">{{ $totalCustomers }}</div>
            <div class="stat-label">Customers</div>
        </div>

        <div class="stat-card">
            <div class="stat-number">{{ $totalOrders }}</div>
            <div class="stat-label">Orders</div>
        </div>
    </div>

    <div class="admin-menu">
        <a href="{{ route('admin.products.index') }}" class="menu-card">
            <h3>Manage Products</h3>
            <p>Add, view, and manage jewelry products.</p>
        </a>

        <a href="{{ route('admin.products.create') }}" class="menu-card">
            <h3>Add Product</h3>
            <p>Upload new jewelry products with images.</p>
        </a>

        <a href="#" class="menu-card">
            <h3>Orders</h3>
            <p>Order management will be added here.</p>
        </a>
    </div>
</div>

@endsection --}}

@extends('layouts.app', ['title' => 'Admin Dashboard - Sora Jewelry'])

@section('content')

<h1 style="margin-bottom:30px;">Admin Dashboard</h1>

{{-- Statistics --}}
<div style="
display:grid;
grid-template-columns:repeat(4,1fr);
gap:20px;
margin-bottom:50px;
">

    <div style="background:white;padding:25px;">
        <h2>{{ $totalProducts }}</h2>
        <p>Products</p>
    </div>

    <div style="background:white;padding:25px;">
        <h2>{{ $totalCustomers }}</h2>
        <p>Customers</p>
    </div>

    <div style="background:white;padding:25px;">
        <h2>{{ $totalOrders }}</h2>
        <p>Total Orders</p>
    </div>

    <div style="background:white;padding:25px;">
        <h2>{{ $pendingOrders }}</h2>
        <p>Pending Orders</p>
    </div>

</div>
{{-- Admin Menu --}}
<div style="
display:grid;
grid-template-columns:repeat(3,1fr);
gap:30px;
margin-top:20px;
">

    <a href="{{ route('admin.products.index') }}"
    style="
    background:white;
    padding:40px;
    border:1px solid #e5e5e5;
    border-radius:18px;
    color:#222;
    text-decoration:none;
    min-height:300px;
    display:flex;
    flex-direction:column;
    transition:.3s;
    ">

        <div style="font-size:52px;">
            📦
        </div>

        <h2 style="
        margin:20px 0 15px;
        font-size:48px;
        font-weight:500;
        ">
            Products
        </h2>

        <p style="
        font-size:22px;
        line-height:1.6;
        color:#666;
        ">
            View and manage jewelry products.
        </p>

        <div style="
        margin-top:auto;
        padding-top:30px;
        color:#b89b5e;
        font-size:20px;
        font-weight:600;
        ">
            Manage Products →
        </div>

    </a>

    <a href="{{ route('admin.orders.index') }}"
    style="
    background:white;
    padding:40px;
    border:1px solid #e5e5e5;
    border-radius:18px;
    color:#222;
    text-decoration:none;
    min-height:300px;
    display:flex;
    flex-direction:column;
    transition:.3s;
    ">

        <div style="font-size:52px;">
            📋
        </div>

        <h2 style="
        margin:20px 0 15px;
        font-size:48px;
        font-weight:500;
        ">
            Orders
        </h2>

        <p style="
        font-size:22px;
        line-height:1.6;
        color:#666;
        ">
            Track and update customer orders.
        </p>

        <div style="
        margin-top:auto;
        padding-top:30px;
        color:#b89b5e;
        font-size:20px;
        font-weight:600;
        ">
            Manage Orders →
        </div>

    </a>

    <a href="{{ route('admin.events.index') }}"
    style="
    background:white;
    padding:40px;
    border:1px solid #e5e5e5;
    border-radius:18px;
    color:#222;
    text-decoration:none;
    min-height:300px;
    display:flex;
    flex-direction:column;
    transition:.3s;
    ">

        <div style="font-size:52px;">
            📧
        </div>

        <h2 style="
        margin:20px 0 15px;
        font-size:48px;
        font-weight:500;
        ">
            Events
        </h2>

        <p style="
        font-size:22px;
        line-height:1.6;
        color:#666;
        ">
            Create and send promotional campaigns.
        </p>

        <div style="
        margin-top:auto;
        padding-top:30px;
        color:#b89b5e;
        font-size:20px;
        font-weight:600;
        ">
            Manage Events →
        </div>

    </a>

</div>

@endsection