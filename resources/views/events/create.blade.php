@extends('layouts.app')
@section('title', 'Create Event')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="fw-bold mb-0"><i class="bi bi-calendar-plus text-primary me-2"></i>Create New Event</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('events.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-bold">Event Name</label>
                        <input type="text" name="event_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Location</label>
                        <input type="text" name="location" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Event Date & Time</label>
                        <input type="datetime-local" name="event_date" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Max Participants</label>
                        <input type="number" name="max_participants" class="form-control" value="50" min="1" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Sport Type</label>
                        <input type="text" name="sport_type" class="form-control" placeholder="Basketball, Football, etc.">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Description</label>
                        <textarea name="description" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Status</label>
                        <select name="status" class="form-select">
                            <option value="upcoming">Upcoming</option>
                            <option value="ongoing">Ongoing</option>
                            <option value="completed">Completed</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Create Event</button>
                    <a href="{{ route('events.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection