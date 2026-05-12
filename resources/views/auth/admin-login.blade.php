@extends('layouts.app', ['title' => 'Admin Login - Sora Jewelry'])

@section('styles')
<style>
    .auth-container {
        max-width: 420px;
        margin: 60px auto;
        background: white;
        padding: 35px;
    }

    .auth-title {
        font-size: 28px;
        font-weight: 400;
        margin-bottom: 25px;
    }

    label {
        display: block;
        margin-top: 16px;
        margin-bottom: 6px;
    }

    input {
        width: 100%;
        padding: 13px;
        border: 1px solid #ccc;
        background: white;
    }

    .btn {
        width: 100%;
        margin-top: 25px;
        padding: 14px;
        border: none;
        background: #111;
        color: white;
        cursor: pointer;
    }

    .auth-links {
        margin-top: 20px;
        color: #555;
        line-height: 1.8;
    }

    .error {
        background: #f8d7da;
        color: #721c24;
        padding: 12px;
        margin-bottom: 20px;
    }
</style>
@endsection

@section('content')

<div class="auth-container">
    <h1 class="auth-title">Admin Login</h1>

    @if ($errors->any())
        <div class="error">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('admin.login.submit') }}" method="POST">
        @csrf

        <label>Email</label>
        <input type="email" name="email" value="{{ old('email') }}" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <button type="submit" class="btn">Login as Admin</button>
    </form>

    <div class="auth-links">
        <div>Customer? <a href="{{ route('login') }}">Customer login</a></div>
    </div>
</div>

@endsection