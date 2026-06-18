@extends('layouts.app')

@section('content')
<div class="auth-page">
    <div class="auth-card">
        <h1>Reset Password</h1>

        <p style="text-align: center; margin-bottom: 24px; color: #6f665d;">
            Enter your new password below.
        </p>

        @if ($errors->any())
            <div class="error-message">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            <div class="form-group">
                <label>Email Address</label>
                <input
                    type="email"
                    name="email"
                    value="{{ old('email', $email) }}"
                    placeholder="Enter your email"
                    required
                >
            </div>

            <div class="form-group">
                <label>New Password</label>
                <input
                    type="password"
                    name="password"
                    placeholder="Enter new password"
                    required
                >
            </div>

            <div class="form-group">
                <label>Confirm New Password</label>
                <input
                    type="password"
                    name="password_confirmation"
                    placeholder="Confirm new password"
                    required
                >
            </div>

            <button type="submit" class="auth-btn">
                Reset Password
            </button>
        </form>

        <div class="auth-link">
            <a href="{{ route('login') }}">Back to Login</a>
        </div>
    </div>
</div>
@endsection