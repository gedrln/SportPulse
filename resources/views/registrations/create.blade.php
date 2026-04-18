@extends('layouts.app')
@section('title', 'Register for Event')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="fw-bold mb-0"><i class="bi bi-person-plus text-primary me-2"></i>Register for an Event</h5>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <i class="bi bi-info-circle me-2"></i>
                    Registering as: <strong>{{ auth()->user()->username }}</strong><br>
                    Your registration will be reviewed by an admin.
                </div>

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $e)
                                <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('registrations.store') }}">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Select Event <span class="text-danger">*</span></label>
                        <select name="event_id" id="event_id" class="form-select" required>
                            <option value="">-- Choose an Event --</option>
                            @foreach($events as $event)
                                <option value="{{ $event->event_id }}" 
                                    {{ old('event_id') == $event->event_id ? 'selected' : '' }}>
                                    {{ $event->event_name }} - {{ $event->sport_type ?? 'General' }} 
                                    ({{ $event->event_date->format('M d, Y') }})
                                    - {{ $event->max_participants - $event->participants }} slots left
                                </option>
                            @endforeach
                        </select>
                        @error('event_id')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Participant Name <span class="text-danger">*</span></label>
                        <input type="text" name="participant_name" class="form-control" 
                               value="{{ old('participant_name', auth()->user()->name) }}" required>
                        @error('participant_name')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Contact Number <span class="text-danger">*</span></label>
                        <input type="text" name="contact_number" class="form-control" 
                               value="{{ old('contact_number') }}" placeholder="09XXXXXXXXX" required>
                        @error('contact_number')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="alert alert-warning small">
                        <i class="bi bi-info-circle me-2"></i>
                        Registration status will be <strong>Pending</strong> until admin approves.
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-send me-1"></i> Submit Registration
                        </button>
                        <a href="{{ route('registrations.index') }}" class="btn btn-secondary">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection