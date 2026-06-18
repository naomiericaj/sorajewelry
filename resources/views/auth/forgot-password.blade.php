@extends('layouts.app')

@section('content')
<div class="auth-page">
    <div class="auth-card">
        <h1>Forgot Password</h1>

        <p style="text-align: center; margin-bottom: 24px; color: #6f665d;">
            Enter your email and we will send you a password reset link.
        </p>

        @if (session('status'))
            <div class="success-message">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="error-message">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="form-group">
                <label>Email Address</label>
                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="Enter your email"
                    required
                    autofocus
                >
            </div>

            <button type="submit" class="auth-btn">
                Send Reset Link
            </button>
        </form>

        <div class="auth-link">
            <a href="{{ route('login') }}">Back to Login</a>
        </div>
    </div>
</div>
@endsection