@extends('layouts.app')
@section('title', '403 — Forbidden')
@section('content')
<div class="text-center py-5">
    <div style="font-size:5rem">🚫</div>
    <h1 class="fw-bold mt-3">403</h1>
    <h4 class="text-muted">Access Denied</h4>
    <p class="text-muted">You don't have permission to access this page.</p>
    <a href="{{ route('home') }}" class="btn btn-primary mt-2">Go Home</a>
</div>
@endsection