@extends('layouts.app')
@section('title', 'Edit Event')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="fw-bold mb-0"><i class="bi bi-pencil-square text-warning me-2"></i>Edit Event</h5>
            </div>
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $e)
                                <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('events.update', $event) }}">
                    @csrf @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Event Name</label>
                        <input type="text" name="event_name" class="form-control" value="{{ old('event_name', $event->event_name) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Location</label>
                        <input type="text" name="location" class="form-control" value="{{ old('location', $event->location) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Event Start Date & Time</label>
                        <input type="datetime-local" name="event_date" class="form-control"
                            value="{{ old('event_date', $event->event_date->format('Y-m-d\TH:i')) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Event End Date & Time</label>
                        <input type="datetime-local" name="event_end_date" class="form-control"
                            value="{{ old('event_end_date', $event->event_end_date?->format('Y-m-d\TH:i')) }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Max Participants</label>
                        <input type="number" name="max_participants" class="form-control" value="{{ old('max_participants', $event->max_participants) }}" min="1" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Sport Type</label>
                        <select name="sport_type" class="form-select">
                            <option value="">-- Select Sport --</option>
                            <option value="Basketball" {{ old('sport_type', $event->sport_type) == 'Basketball' ? 'selected' : '' }}>Basketball</option>
                            <option value="Football" {{ old('sport_type', $event->sport_type) == 'Football' ? 'selected' : '' }}>Football</option>
                            <option value="Volleyball" {{ old('sport_type', $event->sport_type) == 'Volleyball' ? 'selected' : '' }}>Volleyball</option>
                            <option value="Swimming" {{ old('sport_type', $event->sport_type) == 'Swimming' ? 'selected' : '' }}>Swimming</option>
                            <option value="Running" {{ old('sport_type', $event->sport_type) == 'Running' ? 'selected' : '' }}>Running</option>
                            <option value="Badminton" {{ old('sport_type', $event->sport_type) == 'Badminton' ? 'selected' : '' }}>Badminton</option>
                            <option value="Pickle Ball" {{ old('sport_type', $event->sport_type) == 'Pickle Ball' ? 'selected' : '' }}>Pickle Ball</option>
                            <option value="Tennis" {{ old('sport_type', $event->sport_type) == 'Tennis' ? 'selected' : '' }}>Tennis</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Description</label>
                        <textarea name="description" class="form-control" rows="3">{{ old('description', $event->description) }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Status</label>
                        <select name="status" class="form-select">
                            <option value="upcoming" {{ old('status', $event->status) == 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                            <option value="ongoing" {{ old('status', $event->status) == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                            <option value="completed" {{ old('status', $event->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ old('status', $event->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-warning">Update Event</button>
                        <a href="{{ route('events.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection