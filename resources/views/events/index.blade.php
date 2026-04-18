@extends('layouts.app')
@section('title', 'Events')

@section('content')
<div class="card">
    <div class="card-header bg-white">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <h5 class="fw-bold mb-0"><i class="bi bi-calendar-event text-primary me-2"></i>Sports Events</h5>
            
            <!-- Filter by Sport -->
            <form method="GET" action="{{ route('events.index') }}" class="d-flex gap-2">
                <select name="sport" class="form-select form-select-sm" style="width: 150px;">
                    <option value="">All Sports</option>
                    @foreach($sports as $sport)
                        <option value="{{ $sport }}" {{ request('sport') == $sport ? 'selected' : '' }}>
                            {{ $sport }}
                        </option>
                    @endforeach
                </select>
                
                <select name="status" class="form-select form-select-sm" style="width: 120px;">
                    <option value="upcoming" {{ request('status') == 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                    <option value="ongoing" {{ request('status') == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                </select>
                
                <button type="submit" class="btn btn-sm btn-primary">Filter</button>
                <a href="{{ route('events.index') }}" class="btn btn-sm btn-secondary">Reset</a>
            </form>
            
            @auth
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('events.create') }}" class="btn btn-primary-custom btn-sm">+ Add Event</a>
                @endif
            @endauth
        </div>
    </div>
    
    <div class="card-body">
        @guest
            <div class="alert alert-info">
                <i class="bi bi-info-circle me-2"></i>
                Browse as Guest. <a href="/login">Login</a> or <a href="/register">Register</a> to join events!
            </div>
        @endguest

        @if($events->count() > 0)
            <div class="row g-4">
                @foreach($events as $event)
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <h5 class="fw-bold text-primary">{{ $event->event_name }}</h5>
                                    <span class="badge bg-{{ $event->status == 'upcoming' ? 'primary' : ($event->status == 'ongoing' ? 'warning' : 'secondary') }}">
                                        {{ ucfirst($event->status) }}
                                    </span>
                                </div>
                                
                                <p class="text-muted small mt-2">
                                    <i class="bi bi-trophy"></i> {{ $event->sport_type ?? 'General' }}<br>
                                    <i class="bi bi-geo-alt"></i> {{ $event->location }}<br>
                                    <i class="bi bi-calendar3"></i> {{ $event->event_date->format('M d, Y h:i A') }}
                                </p>
                                
                                <hr>
                                
                                <div class="mb-2">
                                    <div class="d-flex justify-content-between">
                                        <span><i class="bi bi-people"></i> Participants</span>
                                        <span class="fw-bold">{{ $event->participants }}/{{ $event->max_participants }}</span>
                                    </div>
                                    <div class="progress" style="height: 6px;">
                                        <div class="progress-bar bg-success" style="width: {{ $event->max_participants > 0 ? ($event->participants / $event->max_participants) * 100 : 0 }}%"></div>
                                    </div>
                                </div>
                                
                                <div class="d-grid gap-2 mt-3">
                                    <a href="{{ route('events.show', $event) }}" class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-eye"></i> View Details
                                    </a>
                                    
                                    @auth
                                        @if(!auth()->user()->isAdmin())
                                            @php
                                                $isRegistered = $event->registrations()->where('user_name', auth()->user()->username)->exists();
                                            @endphp
                                            @if($isRegistered)
                                                <button class="btn btn-success btn-sm" disabled>
                                                    <i class="bi bi-check-circle"></i> Already Registered
                                                </button>
                                            @elseif($event->isFull())
                                                <button class="btn btn-secondary btn-sm" disabled>
                                                    <i class="bi bi-x-circle"></i> Event Full
                                                </button>
                                            @elseif($event->status == 'upcoming')
                                                <a href="{{ route('registrations.create') }}?event_id={{ $event->id }}" class="btn btn-primary-custom btn-sm">
                                                    <i class="bi bi-person-plus"></i> Register Now
                                                </a>
                                            @endif
                                        @endif
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="mt-4">
                {{ $events->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-calendar-x display-1 text-muted"></i>
                <h4 class="text-muted mt-3">No events found</h4>
                <p class="text-muted">Try a different filter or check back later.</p>
            </div>
        @endif
    </div>
</div>
@endsection