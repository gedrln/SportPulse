@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="card bg-primary text-white mb-4">
    <div class="card-body">
        <h3>Welcome, {{ auth()->user()->username }}!</h3>
        <p>Role: <span class="badge bg-warning text-dark">{{ ucfirst(auth()->user()->role) }}</span></p>
    </div>
</div>

@if($isAdmin)
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h2 class="text-primary">{{ $totalEvents }}</h2>
                <p class="mb-0">Total Events</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h2 class="text-success">{{ $upcomingEvents }}</h2>
                <p class="mb-0">Upcoming Events</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h2 class="text-warning">{{ $pendingRegistrations }}</h2>
                <p class="mb-0">Pending Registrations</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h2 class="text-info">{{ $totalUsers }}</h2>
                <p class="mb-0">Total Users</p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">📅 Upcoming Events</div>
            <div class="card-body">
                @forelse($recentEvents as $e)
                    <div class="border-bottom py-2">
                        <strong>{{ $e->event_name }}</strong><br>
                        <small>{{ $e->event_date->format('M d, Y') }} • {{ $e->location }}</small>
                    </div>
                @empty
                    <p class="text-muted">No upcoming events</p>
                @endforelse
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">⏳ Pending Registrations</div>
            <div class="card-body">
                @forelse($latestRegistrations->where('status','pending') as $r)
                    <div class="border-bottom py-2 d-flex justify-content-between align-items-center">
                        <div>
                            <strong>{{ $r->participant_name }}</strong><br>
                            <small>{{ $r->event->event_name }}</small>
                        </div>
                        <div>
                            <form action="{{ route('registrations.approve', $r) }}" method="POST" class="d-inline">
                                @csrf @method('PATCH')
                                <button class="btn btn-sm btn-success">✓ Approve</button>
                            </form>
                            <form action="{{ route('registrations.reject', $r) }}" method="POST" class="d-inline">
                                @csrf @method('PATCH')
                                <button class="btn btn-sm btn-danger">✗ Reject</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-muted">No pending registrations</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">📊 Registrations This Year</div>
            <div class="card-body">
                <canvas id="registrationsChart" height="100"></canvas>
            </div>
        </div>
    </div>
</div>

@else
{{-- USER DASHBOARD --}}
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body">
                <h2 class="text-primary">{{ $totalEvents }}</h2>
                <p class="mb-0">Events Available</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body">
                <h2 class="text-success">{{ $myApproved }}</h2>
                <p class="mb-0">My Approved Events</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body">
                <h2 class="text-warning">{{ $myPending }}</h2>
                <p class="mb-0">My Pending Registrations</p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">📋 My Registrations</div>
            <div class="card-body">
                @forelse($myRegistrations as $r)
                    <div class="border-bottom py-2">
                        <strong>{{ $r->event->event_name }}</strong><br>
                        <small>Status: 
                            @if($r->status == 'pending')
                                <span class="badge bg-warning text-dark">Pending</span>
                            @elseif($r->status == 'approved')
                                <span class="badge bg-success">Approved</span>
                            @else
                                <span class="badge bg-danger">Rejected</span>
                            @endif
                        </small>
                    </div>
                @empty
                    <p class="text-muted">No registrations yet. <a href="{{ route('registrations.create') }}">Register now</a></p>
                @endforelse
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">🔥 Upcoming Events</div>
            <div class="card-body">
                @forelse($recentEvents as $e)
                    <div class="border-bottom py-2 d-flex justify-content-between align-items-center">
                        <div>
                            <strong>{{ $e->event_name }}</strong><br>
                            <small>{{ $e->event_date->format('M d, Y') }}</small>
                        </div>
                        <a href="{{ route('registrations.create') }}?event_id={{ $e->id }}" class="btn btn-sm btn-primary">Register</a>
                    </div>
                @empty
                    <p class="text-muted">No upcoming events</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endif

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    @if($isAdmin)
    const ctx = document.getElementById('registrationsChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Registrations',
                data: {{ json_encode($monthlyRegistrations) }},
                backgroundColor: '#f97316',
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true
        }
    });
    @endif
</script>
@endsection