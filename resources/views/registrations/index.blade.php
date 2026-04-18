@extends('layouts.app')
@section('title', 'Registrations')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="fw-bold mb-0"><i class="bi bi-person-check me-2"></i>{{ auth()->user()->isAdmin() ? 'All Registrations' : 'My Registrations' }}</h5>
        @if(!auth()->user()->isAdmin())
            <a href="{{ route('registrations.create') }}" class="btn btn-primary btn-sm">+ Register</a>
        @endif
    </div>
    <div class="card-body">
        @if(auth()->user()->isAdmin())
            <div class="alert alert-warning">
                <i class="bi bi-shield-check me-2"></i>Admin: You can approve, reject, or delete any registration.
            </div>
        @else
            <div class="alert alert-info">
                <i class="bi bi-info-circle me-2"></i>Admin will review your registration.
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        @if(auth()->user()->isAdmin())<th>User</th>@endif
                        <th>Event</th>
                        <th>Participant</th>
                        <th>Contact</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($registrations as $r)
                    <tr>
                        <td>#{{ $r->id }}</td>
                        @if(auth()->user()->isAdmin())
                            <td><strong>{{ $r->user->username }}</strong></td>
                        @endif
                        <td>
                            <strong>{{ $r->event->event_name }}</strong><br>
                            <small>{{ $r->event->event_date->format('M d, Y') }}</small>
                        </td>
                        <td>{{ $r->participant_name }}</td>
                        <td>{{ $r->contact_number }}</td>
                        <td>{{ $r->created_at->format('M d, Y') }}</td>
                        <td>
                            @if($r->status == 'pending')
                                <span class="badge bg-warning text-dark">Pending</span>
                            @elseif($r->status == 'approved')
                                <span class="badge bg-success">Approved</span>
                            @else
                                <span class="badge bg-danger">Rejected</span>
                            @endif
                        </td>
                        <td>
                            @if(auth()->user()->isAdmin())
                                @if($r->status == 'pending')
                                    <form action="{{ route('registrations.approve', $r) }}" method="POST" class="d-inline">
                                        @csrf @method('PATCH')
                                        <button class="btn btn-sm btn-success">✓ Approve</button>
                                    </form>
                                    <form action="{{ route('registrations.reject', $r) }}" method="POST" class="d-inline">
                                        @csrf @method('PATCH')
                                        <button class="btn btn-sm btn-danger">✗ Reject</button>
                                    </form>
                                @endif
                                <form action="{{ route('registrations.destroy', $r) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this registration?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">🗑 Delete</button>
                                </form>
                            @else
                                @if($r->status == 'pending')
                                    <form action="{{ route('registrations.cancel', $r) }}" method="POST" class="d-inline" onsubmit="return confirm('Cancel your registration?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger">Cancel</button>
                                    </form>
                                @endif
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ auth()->user()->isAdmin() ? 8 : 7 }}" class="text-center py-5">
                            No registrations found
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $registrations->links() }}
    </div>
</div>
@endsection