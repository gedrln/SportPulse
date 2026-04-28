@extends('layouts.app')
@section('title', '404 — Page Not Found')
@section('content')
<div class="text-center py-5">
    <div style="font-size:5rem">🔍</div>
    <h1 class="fw-bold mt-3">404</h1>
    <h4 class="text-muted">Page Not Found</h4>
    <p class="text-muted">The page you're looking for doesn't exist or has been moved.</p>
    <a href="{{ route('home') }}" class="btn btn-primary mt-2">Go Home</a>
    <a href="{{ route('events.index') }}" class="btn btn-outline-secondary mt-2 ms-2">Browse Events</a>
</div>
@endsection
