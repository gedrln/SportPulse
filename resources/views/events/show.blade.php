@extends('layouts.app')
@section('title', $event->event_name)

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header bg-white">
                <div class="d-flex justify-content-between">
                    <div>
                        <span class="badge bg-{{ $event->status=='upcoming'?'primary':'secondary' }} mb-2">{{ ucfirst($event->status) }}</span>
                        <h2 class="fw-bold">{{ $event->event_name }}</h2>
                        <p class="text-muted">{{ $event->sport_type ?? 'Sports Event' }}</p>
                    </div>
                    @auth
                        @if(auth()->user()->isAdmin())
                            <div>
                                <a href="{{ route('events.edit', $event) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('events.destroy', $event) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this event?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </div>
                        @endif
                    @endauth
                </div>
            </div>
            <div class="card-body">
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <div class="bg-light p-3 rounded">
                            <i class="bi bi-geo-alt text-danger me-2"></i>
                            <strong>Location:</strong><br>{{ $event->location }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="bg-light p-3 rounded">
                            <i class="bi bi-calendar3 text-primary me-2"></i>
                            <strong>Date & Time:</strong><br>{{ $event->event_date->format('F j, Y g:i A') }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="bg-light p-3 rounded">
                            <i class="bi bi-people text-success me-2"></i>
                            <strong>Participants:</strong><br>{{ $event->participants }}/{{ $event->max_participants }}
                            <div class="progress mt-2">
                                <div class="progress-bar bg-success" style="width: {{ $event->max_participants>0?($event->participants/$event->max_participants)*100:0 }}%"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="bg-light p-3 rounded">
                            <i class="bi bi-person text-info me-2"></i>
                            <strong>Organizer:</strong><br>{{ $event->creator->name ?? 'Admin' }}
                        </div>
                    </div>
                </div>

                @if($event->description)
                    <div class="mb-4">
                        <h6><i class="bi bi-file-text me-2"></i>Description</h6>
                        <p>{{ $event->description }}</p>
                    </div>
                @endif

                <div class="border-top pt-4">
                    @guest
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i>
                            <a href="/login">Login</a> or <a href="/register">Register</a> to join this event!
                        </div>
                    @endguest

                    @auth
                        @if(!auth()->user()->isAdmin())
                            @if($alreadyRegistered)
                                <div class="alert alert-success">
                                    <i class="bi bi-check-circle me-2"></i>
                                    You are already registered! <a href="/registrations">View your registrations</a>
                                </div>
                            @elseif($event->isFull())
                                <div class="alert alert-warning">
                                    <i class="bi bi-exclamation-triangle me-2"></i>
                                    Sorry, this event is full!
                                </div>
                            @elseif($event->status == 'upcoming')
                                <a href="{{ route('registrations.create') }}?event_id={{ $event->id }}" class="btn btn-primary w-100 py-2">
                                    <i class="bi bi-person-plus me-2"></i>Register for This Event
                                </a>
                            @else
                                <div class="alert alert-secondary">
                                    Registration is closed (Status: {{ ucfirst($event->status) }}).
                                </div>
                            @endif
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
@endsection