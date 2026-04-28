@extends('layouts.app')
@section('title', '500 — Server Error')
@section('content')
<div class="text-center py-5">
    <div style="font-size:5rem">⚠️</div>
    <h1 class="fw-bold mt-3">500</h1>
    <h4 class="text-muted">Something Went Wrong</h4>
    <p class="text-muted">We're having trouble processing your request. Please try again later.</p>
    <a href="{{ route('home') }}" class="btn btn-primary mt-2">Go Home</a>
</div>
@endsection