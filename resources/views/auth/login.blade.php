@extends('layouts.guest')
@section('title', 'Login — SportPulse')

@section('content')
<h5 style="font-weight:900;color:#082d4e;text-align:center;margin-bottom:4px;">Welcome Back!</h5>
<p style="text-align:center;color:#64748b;font-size:0.85rem;margin-bottom:1.25rem;">Sign in to your SportPulse account</p>

@if($errors->any())
<div class="alert alert-danger mb-3">
    <i class="bi bi-exclamation-triangle-fill me-2"></i>
    @foreach($errors->all() as $e){{ $e }}<br>@endforeach
</div>
@endif

@if(session('status'))
<div class="alert mb-3" style="background:#dcfce7;color:#166534;border-radius:9px;font-size:0.85rem;">{{ session('status') }}</div>
@endif

<form method="POST" action="{{ route('login') }}">
    @csrf
    <div class="mb-3">
        <label class="form-label"><i class="bi bi-envelope me-1"></i>Email Address</label>
        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
               value="{{ old('email') }}" placeholder="you@example.com" required autofocus>
        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="mb-3">
        <div class="d-flex justify-content-between align-items-center mb-1">
            <label class="form-label mb-0"><i class="bi bi-lock me-1"></i>Password</label>
            @if(Route::has('password.request'))
            <a href="{{ route('password.request') }}" class="auth-link" style="font-size:0.78rem;">Forgot?</a>
            @endif
        </div>
        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
               placeholder="Your password" required>
        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" name="remember" id="remember">
        <label class="form-check-label text-muted" for="remember" style="font-size:0.875rem;">Remember me</label>
    </div>
    <button type="submit" class="btn-auth"><i class="bi bi-box-arrow-in-right me-2"></i>Sign In</button>
</form>
<div class="divider" style="text-align:center;font-size:0.875rem;color:#64748b;margin:1.25rem 0;">or</div>
<p style="text-align:center;font-size:0.875rem;color:#64748b;margin:0;">
    Don't have an account? <a href="{{ route('register') }}" class="auth-link">Sign up here</a>
</p>
@endsection