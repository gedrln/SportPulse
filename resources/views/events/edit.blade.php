@extends('layouts.app')
@section('title', 'Edit Event')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&family=Bebas+Neue&display=swap');
    .sp-form-page { font-family: 'DM Sans', sans-serif; }
    .sp-form-wrap { max-width: 720px; margin: 0 auto; }
    .sp-form-header { margin-bottom: 28px; padding-bottom: 20px; border-bottom: 1px solid rgba(249,115,22,0.2); display: flex; align-items: center; gap: 16px; }
    .sp-form-header-icon { width: 48px; height: 48px; border-radius: 14px; background: rgba(245,158,11,0.12); border: 1px solid rgba(245,158,11,0.25); display: flex; align-items: center; justify-content: center; font-size: 1.3rem; flex-shrink: 0; }
    .sp-form-title { font-family: 'Bebas Neue', sans-serif; font-size: 2rem; color: #f1f5f9; letter-spacing: 2px; line-height: 1; }
    .sp-form-title span { color: #f97316; }
    .sp-form-sub { color: #64748b; font-size: 0.8rem; margin-top: 4px; }
    .sp-event-chip { display: inline-flex; align-items: center; gap: 6px; background: rgba(245,158,11,0.1); border: 1px solid rgba(245,158,11,0.2); color: #fbbf24; font-size: 0.72rem; font-weight: 600; padding: 3px 10px; border-radius: 20px; margin-top: 6px; }
    .sp-form-card { background: #1e293b; border: 1px solid rgba(255,255,255,0.06); border-radius: 16px; overflow: hidden; }
    .sp-form-section { padding: 24px 28px; border-bottom: 1px solid rgba(255,255,255,0.05); }
    .sp-form-section:last-child { border-bottom: none; }
    .sp-section-label { font-size: 0.68rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #f97316; margin-bottom: 18px; display: flex; align-items: center; gap: 8px; }
    .sp-section-label::after { content: ''; flex: 1; height: 1px; background: rgba(249,115,22,0.15); }
    .sp-form-group { margin-bottom: 18px; }
    .sp-form-group:last-child { margin-bottom: 0; }
    .sp-form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    .sp-label { display: block; font-size: 0.75rem; font-weight: 600; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.6px; margin-bottom: 7px; }
    .sp-label .required { color: #f87171; margin-left: 2px; }
    .sp-input, .sp-select, .sp-textarea { width: 100%; background: #0f172a; border: 1px solid rgba(255,255,255,0.08); border-radius: 10px; padding: 11px 14px; color: #e2e8f0; font-size: 0.87rem; font-family: 'DM Sans', sans-serif; outline: none; transition: border-color 0.2s, box-shadow 0.2s; appearance: none; -webkit-appearance: none; }
    .sp-input:focus, .sp-select:focus, .sp-textarea:focus { border-color: rgba(245,158,11,0.5); box-shadow: 0 0 0 3px rgba(245,158,11,0.08); }
    .sp-input::placeholder { color: #334155; }
    .sp-input[type="datetime-local"]::-webkit-calendar-picker-indicator { filter: invert(0.5); cursor: pointer; }
    .sp-select { background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%2364748b' d='M6 8L1 3h10z'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 14px center; padding-right: 36px; cursor: pointer; }
    .sp-select option { background: #1e293b; }
    .sp-textarea { resize: vertical; min-height: 90px; }
    .sp-error-msg { font-size: 0.72rem; color: #f87171; margin-top: 5px; }
    .sp-alert-danger { background: rgba(239,68,68,0.08); border: 1px solid rgba(239,68,68,0.2); border-left: 3px solid #ef4444; border-radius: 10px; padding: 12px 16px; font-size: 0.82rem; color: #fca5a5; margin-bottom: 20px; }
    .sp-alert-danger ul { margin: 6px 0 0 16px; padding: 0; }
    .sp-stat-row { display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; }
    .sp-stat-mini { background: #0f172a; border: 1px solid rgba(255,255,255,0.06); border-radius: 10px; padding: 12px 14px; }
    .sp-stat-mini-label { font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; color: #475569; margin-bottom: 4px; }
    .sp-stat-mini-val { font-family: 'Bebas Neue', sans-serif; font-size: 1.4rem; color: #f97316; line-height: 1; }
    .sp-form-footer { padding: 20px 28px; background: rgba(0,0,0,0.15); border-top: 1px solid rgba(255,255,255,0.05); display: flex; align-items: center; gap: 12px; }
    .sp-btn-submit { background: #f59e0b; border: none; color: white; font-size: 0.87rem; padding: 11px 28px; border-radius: 10px; font-family: 'DM Sans', sans-serif; cursor: pointer; font-weight: 700; display: inline-flex; align-items: center; gap: 8px; transition: background 0.2s, transform 0.15s; }
    .sp-btn-submit:hover { background: #d97706; transform: translateY(-1px); }
    .sp-btn-cancel { background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: #94a3b8; font-size: 0.87rem; padding: 11px 22px; border-radius: 10px; font-family: 'DM Sans', sans-serif; cursor: pointer; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; transition: background 0.2s; }
    .sp-btn-cancel:hover { background: rgba(255,255,255,0.1); color: #cbd5e1; }
    @media (max-width: 640px) { .sp-form-row { grid-template-columns: 1fr; } .sp-stat-row { grid-template-columns: 1fr 1fr; } .sp-form-section { padding: 18px 16px; } .sp-form-footer { padding: 16px; flex-wrap: wrap; } }
</style>

<div class="sp-form-page">
    <div class="sp-form-wrap">

        <div class="sp-form-header">
            <div>
                <div class="sp-form-title">Edit <span>Event</span></div>
                <div class="sp-form-sub">Update the details for this event</div>
                <div class="sp-event-chip"><i class="bi bi-hash" style="font-size:10px"></i> ID {{ $event->event_id }} — {{ $event->event_name }}</div>
            </div>
        </div>

        @if($errors->any())
            <div class="sp-alert-danger">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>Please fix the following errors:
                <ul>
                    @foreach($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('events.update', $event) }}">
            @csrf @method('PUT')
            <div class="sp-form-card">

                {{-- Quick Stats --}}
                <div class="sp-form-section">
                    <div class="sp-section-label"><i class="bi bi-bar-chart-fill"></i> Current Stats</div>
                    <div class="sp-stat-row">
                        <div class="sp-stat-mini">
                            <div class="sp-stat-mini-label">Registered</div>
                            <div class="sp-stat-mini-val">{{ $event->participants }}</div>
                        </div>
                        <div class="sp-stat-mini">
                            <div class="sp-stat-mini-label">Max Slots</div>
                            <div class="sp-stat-mini-val">{{ $event->max_participants }}</div>
                        </div>
                        <div class="sp-stat-mini">
                            <div class="sp-stat-mini-label">Slots Left</div>
                            <div class="sp-stat-mini-val" style="color: {{ ($event->max_participants - $event->participants) <= 0 ? '#f87171' : '#4ade80' }}">
                                {{ max(0, $event->max_participants - $event->participants) }}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Basic Info --}}
                <div class="sp-form-section">
                    <div class="sp-section-label"><i class="bi bi-info-circle-fill"></i> Basic Info</div>
                    <div class="sp-form-group">
                        <label class="sp-label">Event Name <span class="required">*</span></label>
                        <input type="text" name="event_name" class="sp-input" value="{{ old('event_name', $event->event_name) }}" required>
                        @error('event_name')<div class="sp-error-msg">{{ $message }}</div>@enderror
                    </div>
                    <div class="sp-form-row">
                        <div class="sp-form-group">
                            <label class="sp-label">Sport Type</label>
                            <select name="sport_type" class="sp-select">
                                <option value="">-- Select Sport --</option>
                                @foreach(['Basketball','Football','Volleyball','Swimming','Running','Badminton','Pickle Ball','Tennis'] as $sport)
                                    <option value="{{ $sport }}" {{ old('sport_type', $event->sport_type) == $sport ? 'selected' : '' }}>{{ $sport }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="sp-form-group">
                            <label class="sp-label">Status</label>
                            <select name="status" class="sp-select">
                                @foreach(['upcoming'=>'Upcoming','ongoing'=>'Ongoing','completed'=>'Completed','cancelled'=>'Cancelled'] as $val => $label)
                                    <option value="{{ $val }}" {{ old('status', $event->status) == $val ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="sp-form-group">
                        <label class="sp-label">Location <span class="required">*</span></label>
                        <input type="text" name="location" class="sp-input" value="{{ old('location', $event->location) }}" required>
                        @error('location')<div class="sp-error-msg">{{ $message }}</div>@enderror
                    </div>
                    <div class="sp-form-group">
                        <label class="sp-label">Description</label>
                        <textarea name="description" class="sp-textarea">{{ old('description', $event->description) }}</textarea>
                    </div>
                </div>

                {{-- Schedule --}}
                <div class="sp-form-section">
                    <div class="sp-section-label"><i class="bi bi-calendar3"></i> Schedule</div>
                    <div class="sp-form-row">
                        <div class="sp-form-group">
                            <label class="sp-label">Start Date & Time <span class="required">*</span></label>
                            <input type="datetime-local" name="event_date" class="sp-input"
                                value="{{ old('event_date', $event->event_date->format('Y-m-d\TH:i')) }}" required>
                            @error('event_date')<div class="sp-error-msg">{{ $message }}</div>@enderror
                        </div>
                        <div class="sp-form-group">
                            <label class="sp-label">End Date & Time</label>
                            <input type="datetime-local" name="event_end_date" class="sp-input"
                                value="{{ old('event_end_date', $event->event_end_date?->format('Y-m-d\TH:i')) }}">
                        </div>
                    </div>
                    <div class="sp-form-group" style="max-width: 240px;">
                        <label class="sp-label">Max Participants <span class="required">*</span></label>
                        <input type="number" name="max_participants" class="sp-input" value="{{ old('max_participants', $event->max_participants) }}" min="1" required>
                        @error('max_participants')<div class="sp-error-msg">{{ $message }}</div>@enderror
                    </div>
                </div>

                {{-- Footer --}}
                <div class="sp-form-footer">
                    <button type="submit" class="sp-btn-submit">
                        <i class="bi bi-check-lg"></i> Update Event
                    </button>
                    <a href="{{ route('events.index') }}" class="sp-btn-cancel">
                        <i class="bi bi-x-lg"></i> Cancel
                    </a>
                </div>

            </div>
        </form>
    </div>
</div>
@endsection