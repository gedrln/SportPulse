@extends('layouts.app')
@section('title', 'Register for Event')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&family=Bebas+Neue&display=swap');
    .sp-form-page { font-family: 'DM Sans', sans-serif; }
    .sp-form-wrap { max-width: 640px; margin: 0 auto; }
    .sp-form-header { margin-bottom: 28px; padding-bottom: 20px; border-bottom: 1px solid rgba(249,115,22,0.2); display: flex; align-items: center; gap: 16px; }
    .sp-form-header-icon { width: 48px; height: 48px; border-radius: 14px; background: rgba(249,115,22,0.12); border: 1px solid rgba(249,115,22,0.25); display: flex; align-items: center; justify-content: center; font-size: 1.3rem; flex-shrink: 0; }
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
    .sp-label { display: block; font-size: 0.75rem; font-weight: 600; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.6px; margin-bottom: 7px; }
    .sp-label .required { color: #f87171; margin-left: 2px; }
    .sp-input, .sp-select { width: 100%; background: #0f172a; border: 1px solid rgba(255,255,255,0.08); border-radius: 10px; padding: 11px 14px; color: #e2e8f0; font-size: 0.87rem; font-family: 'DM Sans', sans-serif; outline: none; transition: border-color 0.2s, box-shadow 0.2s; appearance: none; -webkit-appearance: none; }
    .sp-input:focus, .sp-select:focus { border-color: rgba(249,115,22,0.5); box-shadow: 0 0 0 3px rgba(249,115,22,0.08); }
    .sp-input::placeholder { color: #334155; }
    .sp-select { background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%2364748b' d='M6 8L1 3h10z'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 14px center; padding-right: 36px; cursor: pointer; }
    .sp-select option { background: #1e293b; }
    .sp-error-msg { font-size: 0.72rem; color: #f87171; margin-top: 5px; }
    .sp-alert-danger { background: rgba(239,68,68,0.08); border: 1px solid rgba(239,68,68,0.2); border-left: 3px solid #ef4444; border-radius: 10px; padding: 12px 16px; font-size: 0.82rem; color: #fca5a5; margin-bottom: 20px; }
    .sp-alert-danger ul { margin: 6px 0 0 16px; padding: 0; }

    /* User Identity Card */
    .sp-identity-card {
        background: #0f172a;
        border: 1px solid rgba(255,255,255,0.06);
        border-radius: 12px;
        padding: 14px 16px;
        display: flex;
        align-items: center;
        gap: 14px;
        margin-bottom: 20px;
    }
    .sp-identity-avatar {
        width: 40px; height: 40px;
        border-radius: 50%;
        background: rgba(249,115,22,0.15);
        border: 2px solid rgba(249,115,22,0.3);
        display: flex; align-items: center; justify-content: center;
        font-family: 'Bebas Neue', sans-serif;
        font-size: 1.1rem;
        color: #f97316;
        flex-shrink: 0;
    }
    .sp-identity-name { font-weight: 600; color: #f1f5f9; font-size: 0.9rem; }
    .sp-identity-sub { font-size: 0.72rem; color: #64748b; margin-top: 2px; }
    .sp-identity-badge { margin-left: auto; background: rgba(249,115,22,0.12); border: 1px solid rgba(249,115,22,0.25); color: #f97316; font-size: 0.65rem; font-weight: 700; padding: 3px 10px; border-radius: 20px; text-transform: uppercase; letter-spacing: 0.5px; white-space: nowrap; }

    /* Event Preview Card */
    .sp-event-preview {
        background: #0f172a;
        border: 1px solid rgba(255,255,255,0.06);
        border-radius: 12px;
        padding: 14px 16px;
        margin-top: 12px;
        display: none;
    }
    .sp-event-preview.visible { display: block; }
    .sp-preview-name { font-weight: 600; color: #f1f5f9; font-size: 0.87rem; margin-bottom: 4px; }
    .sp-preview-meta { font-size: 0.75rem; color: #64748b; display: flex; gap: 14px; flex-wrap: wrap; }
    .sp-preview-meta span { display: flex; align-items: center; gap: 4px; color: #94a3b8; }
    .sp-preview-slots { font-size: 0.72rem; font-weight: 700; padding: 2px 8px; border-radius: 20px; margin-left: auto; }
    .sp-preview-slots.ok { background: rgba(34,197,94,0.12); color: #4ade80; }
    .sp-preview-slots.low { background: rgba(249,115,22,0.12); color: #fb923c; }

    /* Pending Notice */
    .sp-pending-notice {
        background: rgba(249,115,22,0.06);
        border: 1px solid rgba(249,115,22,0.15);
        border-radius: 10px;
        padding: 12px 16px;
        font-size: 0.8rem;
        color: #94a3b8;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .sp-pending-notice strong { color: #fbbf24; }

    .sp-form-footer { padding: 20px 28px; background: rgba(0,0,0,0.15); border-top: 1px solid rgba(255,255,255,0.05); display: flex; align-items: center; gap: 12px; }
    .sp-btn-submit { background: #f97316; border: none; color: white; font-size: 0.87rem; padding: 11px 28px; border-radius: 10px; font-family: 'DM Sans', sans-serif; cursor: pointer; font-weight: 700; display: inline-flex; align-items: center; gap: 8px; transition: background 0.2s, transform 0.15s; }
    .sp-btn-submit:hover { background: #ea580c; transform: translateY(-1px); }
    .sp-btn-cancel { background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: #94a3b8; font-size: 0.87rem; padding: 11px 22px; border-radius: 10px; font-family: 'DM Sans', sans-serif; cursor: pointer; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; transition: background 0.2s; }
    .sp-btn-cancel:hover { background: rgba(255,255,255,0.1); color: #cbd5e1; }
    @media (max-width: 640px) { .sp-form-section { padding: 18px 16px; } .sp-form-footer { padding: 16px; flex-wrap: wrap; } }
</style>

<div class="sp-form-page">
    <div class="sp-form-wrap">

        <div class="sp-form-header">
            <div class="sp-form-header-icon">🏅</div>
            <div>
                <div class="sp-form-title">Register for <span>Event</span></div>
                <div class="sp-form-sub">Secure your spot in the competition</div>
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

        <form method="POST" action="{{ route('registrations.store') }}">
            @csrf
            <div class="sp-form-card">

                {{-- Who's registering --}}
                <div class="sp-form-section">
                    <div class="sp-section-label"><i class="bi bi-person-fill"></i> Registering As</div>
                    <div class="sp-identity-card">
                        <div class="sp-identity-avatar">{{ strtoupper(substr(auth()->user()->username, 0, 1)) }}</div>
                        <div>
                            <div class="sp-identity-name">{{ auth()->user()->username }}</div>
                            <div class="sp-identity-sub">Your registration will be reviewed by an admin</div>
                        </div>
                        <div class="sp-identity-badge">Player</div>
                    </div>
                </div>

                {{-- Event Selection --}}
                <div class="sp-form-section">
                    <div class="sp-section-label"><i class="bi bi-trophy-fill"></i> Select Event</div>
                    <div class="sp-form-group">
                        <label class="sp-label">Event <span class="required">*</span></label>
                        <select name="event_id" id="event_id" class="sp-select" required onchange="showPreview(this)">
                            <option value="">-- Choose an Event --</option>
                            @foreach($events as $event)
                                <option value="{{ $event->event_id }}"
                                    data-name="{{ $event->event_name }}"
                                    data-sport="{{ $event->sport_type ?? 'General' }}"
                                    data-date="{{ $event->event_date->format('M d, Y') }}"
                                    data-location="{{ $event->location }}"
                                    data-slots="{{ $event->max_participants - $event->participants }}"
                                    {{ old('event_id') == $event->event_id || (isset($selectedEvent) && $selectedEvent->event_id == $event->event_id) ? 'selected' : '' }}>
                                    {{ $event->event_name }} — {{ $event->event_date->format('M d, Y') }} ({{ $event->max_participants - $event->participants }} slots left)
                                </option>
                            @endforeach
                        </select>
                        @error('event_id')<div class="sp-error-msg">{{ $message }}</div>@enderror

                        <div class="sp-event-preview" id="eventPreview">
                            <div style="display:flex; align-items:flex-start; justify-content:space-between; gap:8px;">
                                <div class="sp-preview-name" id="previewName"></div>
                                <span class="sp-preview-slots" id="previewSlots"></span>
                            </div>
                            <div class="sp-preview-meta" id="previewMeta"></div>
                        </div>
                    </div>
                </div>

                {{-- Participant Info --}}
                <div class="sp-form-section">
                    <div class="sp-section-label"><i class="bi bi-id-card-fill"></i> Participant Info</div>
                    <div class="sp-form-group">
                        <label class="sp-label">Participant Name <span class="required">*</span></label>
                        <input type="text" name="participant_name" class="sp-input"
                            value="{{ old('participant_name', auth()->user()->name ?? '') }}"
                            placeholder="Full name of the participant" required>
                        @error('participant_name')<div class="sp-error-msg">{{ $message }}</div>@enderror
                    </div>
                    <div class="sp-form-group">
                        <label class="sp-label">Contact Number <span class="required">*</span></label>
                        <input type="text" name="contact_number" class="sp-input"
                            value="{{ old('contact_number') }}"
                            placeholder="09XXXXXXXXX" required>
                        @error('contact_number')<div class="sp-error-msg">{{ $message }}</div>@enderror
                    </div>
                    <div class="sp-pending-notice">
                        <i class="bi bi-hourglass-split" style="color:#f97316; flex-shrink:0"></i>
                        Registration status will be <strong>Pending</strong> until an admin approves your request.
                    </div>
                </div>

                <div class="sp-form-footer">
                    <button type="submit" class="sp-btn-submit">
                        <i class="bi bi-send-fill"></i> Submit Registration
                    </button>
                    <a href="{{ route('registrations.index') }}" class="sp-btn-cancel">
                        <i class="bi bi-x-lg"></i> Cancel
                    </a>
                </div>

            </div>
        </form>
    </div>
</div>

<script>
function showPreview(select) {
    const opt = select.options[select.selectedIndex];
    const preview = document.getElementById('eventPreview');
    if (!opt.value) { preview.classList.remove('visible'); return; }
    document.getElementById('previewName').textContent = opt.dataset.name;
    const slots = parseInt(opt.dataset.slots);
    const slotEl = document.getElementById('previewSlots');
    slotEl.textContent = slots + ' slots left';
    slotEl.className = 'sp-preview-slots ' + (slots <= 5 ? 'low' : 'ok');
    document.getElementById('previewMeta').innerHTML =
        `<span><i class="bi bi-trophy-fill" style="font-size:10px;color:#f97316"></i>${opt.dataset.sport}</span>
         <span><i class="bi bi-calendar3" style="font-size:10px"></i>${opt.dataset.date}</span>
         <span><i class="bi bi-geo-alt-fill" style="font-size:10px"></i>${opt.dataset.location}</span>`;
    preview.classList.add('visible');
}
// Run on load if an event is pre-selected
window.addEventListener('DOMContentLoaded', () => {
    const sel = document.getElementById('event_id');
    if (sel.value) showPreview(sel);
});
</script>
@endsection