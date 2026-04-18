@extends('layouts.guest')
@section('title', 'Register')

@section('content')
<h4 class="text-center fw-bold mb-3">Create Account</h4>
<p class="text-center text-muted small mb-4">Join SportPulse today</p>

<form method="POST" action="{{ route('register') }}">
    @csrf
    
    <div class="mb-3">
        <label class="form-label fw-bold">Full Name</label>
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
               value="{{ old('name') }}" required>
        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    
    <div class="mb-3">
        <label class="form-label fw-bold">Username</label>
        <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" 
               value="{{ old('username') }}" placeholder="e.g. johndoe123" required>
        @error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror
        <small class="text-muted">Letters, numbers, and dashes only. No spaces.</small>
    </div>
    
    <div class="mb-3">
        <label class="form-label fw-bold">Email Address</label>
        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
               value="{{ old('email') }}" required>
        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    
    <div class="mb-3">
        <label class="form-label fw-bold">Password</label>
        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    
    <div class="mb-3">
        <label class="form-label fw-bold">Confirm Password</label>
        <input type="password" name="password_confirmation" class="form-control" required>
    </div>
    
    <button type="submit" class="btn-auth">Create Account</button>
</form>

<div class="text-center mt-4">
    <p class="small text-muted">Already have an account? <a href="{{ route('login') }}">Sign in</a></p>
</div>
@endsection