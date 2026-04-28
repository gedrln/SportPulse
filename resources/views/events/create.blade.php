@extends('layouts.app')
@section('title', 'Create Event')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&family=Bebas+Neue&display=swap');
    .sp-form-page { font-family: 'DM Sans', sans-serif; }
    .sp-form-wrap { max-width: 720px; margin: 0 auto; }
    .feature-icon-wrap { display: flex; align-items: center; margin: 0 0 0 1px; font-size: 1.9rem; }
    .sp-form-header { color: #f97316; margin-bottom: 28px; padding-bottom: 20px; border-bottom: 1px solid rgba(249,115,22,0.2); display: flex; align-items: center; gap: 16px; }
    .sp-form-title { font-family: 'Bebas Neue', sans-serif; font-size: 2rem; color: #f1f5f9; letter-spacing: 2px; line-height: 1; }
    .sp-form-title span { color: #f97316; }
    .sp-form-sub { color: #64748b; font-size: 0.8rem; margin-top: 4px; }
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
    .sp-input:focus, .sp-select:focus, .sp-textarea:focus { border-color: rgba(249,115,22,0.5); box-shadow: 0 0 0 3px rgba(249,115,22,0.08); }
    .sp-input::placeholder { color: #334155; }
    .sp-input[type="datetime-local"]::-webkit-calendar-picker-indicator { filter: invert(0.5); cursor: pointer; }
    .sp-select { background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%2364748b' d='M6 8L1 3h10z'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 14px center; padding-right: 36px; cursor: pointer; }
    .sp-select option { background: #1e293b; }
    .sp-textarea { resize: vertical; min-height: 90px; }
    .sp-error-msg { font-size: 0.72rem; color: #f87171; margin-top: 5px; }
    .sp-alert-danger { background: rgba(239,68,68,0.08); border: 1px solid rgba(239,68,68,0.2); border-left: 3px solid #ef4444; border-radius: 10px; padding: 12px 16px; font-size: 0.82rem; color: #fca5a5; margin-bottom: 20px; }
    .sp-alert-danger ul { margin: 6px 0 0 16px; padding: 0; }
    .sp-form-footer { padding: 20px 28px; background: rgba(0,0,0,0.15); border-top: 1px solid rgba(255,255,255,0.05); display: flex; align-items: center; gap: 12px; }
    .sp-btn-submit { background: #f97316; border: none; color: white; font-size: 0.87rem; padding: 11px 28px; border-radius: 10px; font-family: 'DM Sans', sans-serif; cursor: pointer; font-weight: 700; display: inline-flex; align-items: center; gap: 8px; transition: background 0.2s, transform 0.15s; }
    .sp-btn-submit:hover { background: #ea580c; transform: translateY(-1px); }
    .sp-btn-cancel { background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: #94a3b8; font-size: 0.87rem; padding: 11px 22px; border-radius: 10px; font-family: 'DM Sans', sans-serif; cursor: pointer; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; transition: background 0.2s; }
    .sp-btn-cancel:hover { background: rgba(255,255,255,0.1); color: #cbd5e1; }

    /* Team Division Styles */
    .sp-teams-container { display: flex; flex-direction: column; gap: 12px; }
    .sp-team-row { background: #0f172a; border: 1px solid rgba(255,255,255,0.08); border-radius: 12px; padding: 16px; display: grid; grid-template-columns: 1fr 1fr auto; gap: 12px; align-items: end; position: relative; }
    .sp-team-row .sp-team-index { position: absolute; top: -10px; left: 14px; font-size: 0.6rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #f97316; background: #1e293b; padding: 0 6px; }
    .sp-btn-remove-team { background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.25); color: #f87171; border-radius: 8px; padding: 9px 12px; cursor: pointer; font-size: 0.8rem; transition: background 0.2s; white-space: nowrap; }
    .sp-btn-remove-team:hover { background: rgba(239,68,68,0.2); }
    .sp-btn-add-team { background: rgba(249,115,22,0.08); border: 1px dashed rgba(249,115,22,0.3); color: #f97316; border-radius: 10px; padding: 11px; width: 100%; cursor: pointer; font-size: 0.82rem; font-weight: 600; font-family: 'DM Sans', sans-serif; display: flex; align-items: center; justify-content: center; gap: 8px; transition: background 0.2s, border-color 0.2s; margin-top: 4px; }
    .sp-btn-add-team:hover { background: rgba(249,115,22,0.14); border-color: rgba(249,115,22,0.5); }
    .sp-teams-notice { background: rgba(59,130,246,0.07); border: 1px solid rgba(59,130,246,0.18); border-radius: 10px; padding: 11px 14px; font-size: 0.78rem; color: #93c5fd; display: flex; align-items: flex-start; gap: 9px; margin-top: 14px; }
    .sp-teams-error { background: rgba(239,68,68,0.08); border: 1px solid rgba(239,68,68,0.2); border-radius: 8px; padding: 9px 13px; font-size: 0.75rem; color: #fca5a5; margin-top: 10px; display: none; }
    .sp-teams-error.visible { display: block; }
    .sp-default-size-hint { font-size: 0.68rem; color: #475569; margin-top: 4px; }

    @media (max-width: 640px) {
        .sp-form-row { grid-template-columns: 1fr; }
        .sp-form-section { padding: 18px 16px; }
        .sp-form-footer { padding: 16px; flex-wrap: wrap; }
        .sp-team-row { grid-template-columns: 1fr; }
    }
</style>

<div class="sp-form-page">
    <div class="sp-form-wrap">

        <div class="sp-form-header">
            <div class="feature-icon-wrap icon-orange">
                <i class="bi bi-calendar-plus-fill"></i>
            </div>
            <div>
                <div class="sp-form-title">Create <span>Event</span></div>
                <div class="sp-form-sub">Fill in the details to publish a new sports event</div>
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

        <form method="POST" action="{{ route('events.store') }}" id="createEventForm">
            @csrf
            <div class="sp-form-card">

                {{-- Basic Info --}}
                <div class="sp-form-section">
                    <div class="sp-section-label"><i class="bi bi-info-circle-fill"></i> Basic Info</div>
                    <div class="sp-form-group">
                        <label class="sp-label">Event Name <span class="required">*</span></label>
                        <input type="text" name="event_name" class="sp-input"
                            value="{{ old('event_name') }}"
                            placeholder="e.g. City Basketball Tournament 2026" required>
                        @error('event_name')<div class="sp-error-msg">{{ $message }}</div>@enderror
                    </div>
                    <div class="sp-form-row">
                        <div class="sp-form-group">
                            <label class="sp-label">Sport Type</label>
                            <select name="sport_type" id="sport_type" class="sp-select" onchange="onSportChange(this.value)">
                                <option value="">-- Select Sport --</option>
                                @foreach(['Basketball','Football','Volleyball','Swimming','Running','Badminton','Pickle Ball','Tennis'] as $sport)
                                    <option value="{{ $sport }}" {{ old('sport_type') == $sport ? 'selected' : '' }}>{{ $sport }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="sp-form-group">
                            <label class="sp-label">Status</label>
                            <select name="status" class="sp-select">
                                @foreach(['upcoming'=>'Upcoming','ongoing'=>'Ongoing','completed'=>'Completed','cancelled'=>'Cancelled'] as $val => $label)
                                    <option value="{{ $val }}" {{ old('status', 'upcoming') == $val ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="sp-form-group">
                        <label class="sp-label">Location <span class="required">*</span></label>
                        <input type="text" name="location" class="sp-input"
                            value="{{ old('location') }}"
                            placeholder="e.g. Quezon City Sports Complex" required>
                        @error('location')<div class="sp-error-msg">{{ $message }}</div>@enderror
                    </div>
                    <div class="sp-form-group">
                        <label class="sp-label">Description</label>
                        <textarea name="description" class="sp-textarea"
                            placeholder="Tell participants what to expect...">{{ old('description') }}</textarea>
                    </div>
                </div>

                {{-- Schedule --}}
                <div class="sp-form-section">
                    <div class="sp-section-label"><i class="bi bi-calendar3"></i> Schedule</div>
                    <div class="sp-form-row">
                        <div class="sp-form-group">
                            <label class="sp-label">Start Date & Time <span class="required">*</span></label>
                            <input type="datetime-local" name="event_date" class="sp-input"
                                value="{{ old('event_date') }}" required>
                            @error('event_date')<div class="sp-error-msg">{{ $message }}</div>@enderror
                        </div>
                        <div class="sp-form-group">
                            <label class="sp-label">End Date & Time</label>
                            <input type="datetime-local" name="event_end_date" class="sp-input"
                                value="{{ old('event_end_date') }}">
                        </div>
                    </div>
                    <div class="sp-form-group" style="max-width: 240px;">
                        <label class="sp-label">Max Participants <span class="required">*</span></label>
                        <input type="number" name="max_participants" id="max_participants" class="sp-input"
                            value="{{ old('max_participants', 50) }}" min="10" required
                            oninput="validateParticipants(this)">
                        @error('max_participants')<div class="sp-error-msg">{{ $message }}</div>@enderror
                        <div class="sp-default-size-hint" id="participantsHint">Minimum 10 participants required.</div>
                    </div>
                </div>

                {{-- Team Division (hidden until a team sport is selected) --}}
                <div class="sp-form-section" id="teamDivisionSection" style="display:none;">
                    <div class="sp-section-label"><i class="bi bi-people-fill"></i> Team Division</div>

                    <div class="sp-teams-container" id="teamsContainer"></div>

                    <div class="sp-teams-error" id="teamsError"></div>

                    <button type="button" class="sp-btn-add-team" onclick="addTeam()">
                        <i class="bi bi-plus-circle-fill"></i> Add Another Team
                    </button>

                    <div class="sp-teams-notice">
                        <i class="bi bi-info-circle-fill" style="flex-shrink:0; margin-top:1px"></i>
                        <span>
                            Two teams are auto-created based on the sport selected.
                            All teams <strong>must have equal player slots</strong> to be valid.
                            Admin can assign players to teams after registration.
                        </span>
                    </div>
                </div>

                {{-- Footer --}}
                <div class="sp-form-footer">
                    <button type="submit" class="sp-btn-submit" onclick="return validateForm()">
                        <i class="bi bi-calendar-plus-fill"></i> Create Event
                    </button>
                    <a href="{{ route('events.index') }}" class="sp-btn-cancel">
                        <i class="bi bi-x-lg"></i> Cancel
                    </a>
                </div>

            </div>
        </form>
    </div>
</div>

<script>
const defaultSizes = {
    'Basketball': 5,
    'Football': 11,
    'Volleyball': 6,
    'Badminton': 2,
    'Pickle Ball': 2,
    'Tennis': 2,
};

const teamSports = ['Basketball', 'Football', 'Volleyball', 'Badminton', 'Pickle Ball', 'Tennis'];

let teamCount = 0;

function isTeamSport(sport) {
    return teamSports.includes(sport);
}

function addTeam(name = '', size = '') {
    teamCount++;
    const idx = teamCount;
    const container = document.getElementById('teamsContainer');
    const sport = document.getElementById('sport_type').value;
    const defaultSize = size || defaultSizes[sport] || 5;
    const teamName = name || `Team ${String.fromCharCode(64 + idx)}`;

    const row = document.createElement('div');
    row.className = 'sp-team-row';
    row.id = `team-row-${idx}`;
    row.innerHTML = `
        <span class="sp-team-index">Team ${idx}</span>
        <div>
            <label class="sp-label">Team Name <span class="required">*</span></label>
            <input type="text" name="teams[${idx}][name]" class="sp-input team-name-input"
                value="${teamName}" placeholder="e.g. Team A" required>
        </div>
        <div>
            <label class="sp-label">Player Slots <span class="required">*</span></label>
            <input type="number" name="teams[${idx}][size]" class="sp-input team-size-input"
                value="${defaultSize}" min="1" max="50" required oninput="checkTeamBalance()">
        </div>
        <button type="button" class="sp-btn-remove-team" onclick="removeTeam(${idx})"
            ${idx <= 2 ? 'title="You need at least 2 teams"' : ''}>
            <i class="bi bi-trash3"></i> ${idx <= 2 ? 'Min 2' : 'Remove'}
        </button>
    `;
    container.appendChild(row);
    checkTeamBalance();
}

function removeTeam(idx) {
    const rows = document.querySelectorAll('.sp-team-row');
    if (rows.length <= 2) {
        showTeamError('You must have at least 2 teams.');
        return;
    }
    const row = document.getElementById(`team-row-${idx}`);
    if (row) row.remove();
    checkTeamBalance();
}

function clearTeams() {
    document.getElementById('teamsContainer').innerHTML = '';
    teamCount = 0;
}

function checkTeamBalance() {
    const sizes = Array.from(document.querySelectorAll('.team-size-input'))
        .map(i => parseInt(i.value) || 0);
    if (sizes.length < 2) return;
    const allEqual = sizes.every(s => s === sizes[0]);
    if (!allEqual) {
        showTeamError(`⚠ Teams must have equal player slots. Current: [${sizes.join(', ')}]. Please balance them.`);
    } else {
        hideTeamError();
    }
}

function showTeamError(msg) {
    const el = document.getElementById('teamsError');
    el.textContent = msg;
    el.classList.add('visible');
}

function hideTeamError() {
    const el = document.getElementById('teamsError');
    el.classList.remove('visible');
}

function onSportChange(sport) {
    const section = document.getElementById('teamDivisionSection');
    const hint = document.getElementById('participantsHint');

    if (isTeamSport(sport)) {
        section.style.display = 'block';
        clearTeams();
        const size = defaultSizes[sport] || 5;
        addTeam('Team A', size);
        addTeam('Team B', size);
        hint.textContent = `Default team size for ${sport}: ${size} players. Minimum 10 participants required.`;
    } else {
        section.style.display = 'none';
        clearTeams();
        hint.textContent = sport
            ? `${sport} is an individual sport — no team division needed. Minimum 10 participants required.`
            : 'Minimum 10 participants required.';
    }
}

function validateParticipants(input) {
    if (parseInt(input.value) < 10) {
        input.style.borderColor = 'rgba(239,68,68,0.6)';
        input.style.boxShadow = '0 0 0 3px rgba(239,68,68,0.08)';
    } else {
        input.style.borderColor = '';
        input.style.boxShadow = '';
    }
}

function validateForm() {
    const maxP = parseInt(document.getElementById('max_participants').value);
    if (maxP < 10) {
        alert('Maximum participants must be at least 10.');
        return false;
    }

    const sport = document.getElementById('sport_type').value;
    if (isTeamSport(sport)) {
        const sizes = Array.from(document.querySelectorAll('.team-size-input'))
            .map(i => parseInt(i.value) || 0);
        if (sizes.length < 2) {
            alert('You must have at least 2 teams.');
            return false;
        }
        const allEqual = sizes.every(s => s === sizes[0]);
        if (!allEqual) {
            alert(`All teams must have equal player slots. Current: [${sizes.join(', ')}]`);
            return false;
        }
    }

    return true;
}

window.addEventListener('DOMContentLoaded', () => {
    const sport = document.getElementById('sport_type').value;
    if (sport && isTeamSport(sport)) {
        onSportChange(sport);
    }
});
</script>
@endsection