@extends('layouts.app', ['title' => 'Register - Sora Jewelry'])

@section('styles')
<style>
    .auth-container {
        max-width: 500px;
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

    input,
    textarea {
        width: 100%;
        padding: 13px;
        border: 1px solid #ccc;
        background: white;
    }

    textarea {
        min-height: 90px;
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
    }

    .error {
        background: #f8d7da;
        color: #721c24;
        padding: 12px;
        margin-bottom: 20px;
    }

    .google-btn {
    width: 100%;
    height: 52px;
    border: 1px solid #222;
    background: white;
    color: #222;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 18px;
    text-decoration: none;
    font-size: 15px;
}

.divider-text {
    text-align: center;
    color: #777;
    margin: 18px 0;
    font-size: 13px;
}
</style>
@endsection

@section('content')

<div class="auth-container">
    <h1 class="auth-title">Create Account</h1>

    @if ($errors->any())
        <div class="error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('register.submit') }}" method="POST">
        @csrf

        <label>Name</label>
        <input type="text" name="name" value="{{ old('name') }}" required>

        <label>Email</label>
        <input type="email" name="email" value="{{ old('email') }}" required>

        <label>Phone</label>
        <input type="text" name="phone" value="{{ old('phone') }}">

        <label>Address</label>
        <textarea name="address">{{ old('address') }}</textarea>

        <label>Password</label>
        <input type="password" name="password" required>

        <label>Confirm Password</label>
        <input type="password" name="password_confirmation" required>

        <button type="submit" class="btn">Register</button>
    </form>

    <a href="{{ route('google.redirect') }}" class="google-btn">
    Sign up with Google
</a>

<div class="divider-text">or create account with email</div>

    <div class="auth-links">
        Already have an account? <a href="{{ route('login') }}">Login here</a>
    </div>
</div>

@endsection