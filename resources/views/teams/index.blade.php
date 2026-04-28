@extends('layouts.app')
@section('title', 'Manage Teams — ' . $event->event_name)

@section('content')
<div class="mb-3">
    <a href="{{ route('events.show', $event) }}" class="btn btn-sm btn-secondary">
        <i class="bi bi-arrow-left"></i> Back to Event
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="fw-bold mb-0">
            <i class="bi bi-people-fill text-primary me-2"></i>
            Team Manager — {{ $event->event_name }}
        </h5>
        <div class="d-flex gap-2">
            <a href="{{ route('teams.validate', $event) }}" class="btn btn-sm btn-success">
                <i class="bi bi-check-circle"></i> Validate Teams
            </a>
        </div>
    </div>
</div>

<div class="row g-4">

    {{-- Unassigned Players --}}
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-header bg-warning bg-opacity-10">
                <h6 class="fw-bold mb-0">
                    <i class="bi bi-person-fill text-warning me-1"></i>
                    Unassigned Players
                    <span class="badge bg-warning text-dark ms-1">{{ $unassigned->count() }}</span>
                </h6>
            </div>
            <div class="card-body p-0">
                @forelse($unassigned as $r)
                <div class="border-bottom p-3 d-flex justify-content-between align-items-center">
                    <div>
                        <div class="fw-bold small">{{ $r->participant_name }}</div>
                        <div class="text-muted" style="font-size:0.75rem">@{{ $r->user->username }}</div>
                    </div>
                    <form method="POST" action="{{ route('teams.assign', $event) }}">
                        @csrf
                        <input type="hidden" name="registration_id" value="{{ $r->registration_id }}">
                        <select name="team_id" class="form-select form-select-sm me-2 d-inline-block" style="width:110px" required>
                            <option value="">Team...</option>
                            @foreach($event->teams as $team)
                                <option value="{{ $team->team_id }}" {{ $team->isFull() ? 'disabled' : '' }}>
                                    {{ $team->team_name }} ({{ $team->approvedCount() }}/{{ $team->team_size }})
                                </option>
                            @endforeach
                        </select>
                        <button class="btn btn-sm btn-primary">Assign</button>
                    </form>
                </div>
                @empty
                <div class="text-center text-muted py-4">
                    <i class="bi bi-check-all d-block mb-2" style="font-size:1.5rem"></i>
                    All approved players are assigned
                </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Teams --}}
    <div class="col-md-8">
        <div class="row g-3">
            @forelse($event->teams as $team)
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center
                        {{ $team->isFull() ? 'bg-success bg-opacity-10' : 'bg-primary bg-opacity-10' }}">
                        <div>
                            <h6 class="fw-bold mb-0">{{ $team->team_name }}</h6>
                            <small class="text-muted">{{ $team->approvedCount() }} / {{ $team->team_size }} players</small>
                        </div>
                        <div class="d-flex gap-1 align-items-center">
                            @if($team->isFull())
                                <span class="badge bg-success">Full</span>
                            @else
                                <span class="badge bg-secondary">{{ $team->team_size - $team->approvedCount() }} slots left</span>
                            @endif
                            <form method="POST" action="{{ route('teams.destroy', [$event, $team]) }}" class="d-inline" onsubmit="return confirm('Delete this team?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger py-0 px-1">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        @forelse($team->registrations->where('status', 'approved') as $r)
                        <div class="border-bottom px-3 py-2 d-flex justify-content-between align-items-center">
                            <div>
                                <div class="fw-bold small">{{ $r->participant_name }}</div>
                                <div class="text-muted" style="font-size:0.72rem">@{{ $r->user->username }}</div>
                            </div>
                            <form method="POST" action="{{ route('teams.unassign', [$event, $r]) }}">
                                @csrf @method('PATCH')
                                <button class="btn btn-sm btn-outline-secondary py-0 px-2" title="Remove from team">
                                    <i class="bi bi-x"></i>
                                </button>
                            </form>
                        </div>
                        @empty
                        <div class="text-center text-muted py-3" style="font-size:0.8rem">No players yet</div>
                        @endforelse
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="alert alert-info">No teams yet. Create one below.</div>
            </div>
            @endforelse

            {{-- Add Team Form --}}
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h6 class="fw-bold mb-0"><i class="bi bi-plus-circle me-1"></i> Add New Team</h6>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('teams.store', $event) }}" class="row g-2">
                            @csrf
                            <div class="col-md-5">
                                <input type="text" name="team_name" class="form-control form-control-sm"
                                    placeholder="Team name (e.g. Team C)" required>
                            </div>
                            <div class="col-md-4">
                                <input type="number" name="team_size" class="form-control form-control-sm"
                                    placeholder="Max players"
                                    value="{{ \App\Models\Event::defaultTeamSize($event->sport_type) }}"
                                    min="1" max="50" required>
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-primary btn-sm w-100">Create Team</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection