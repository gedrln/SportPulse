@extends('layouts.app')
@section('title', $event->event_name)

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&family=Bebas+Neue&display=swap');
    .sp-show { font-family: 'DM Sans', sans-serif; max-width: 860px; margin: 0 auto; }

    /* Back link */
    .sp-back {
        display: inline-flex; align-items: center; gap: 6px;
        color: #64748b; font-size: 0.8rem; font-weight: 500;
        text-decoration: none; margin-bottom: 20px;
        transition: color 0.2s;
    }
    .sp-back:hover { color: #f97316; }

    /* Hero Card */
    .sp-hero-card {
        background: #1e293b;
        border: 1px solid rgba(255,255,255,0.06);
        border-radius: 20px;
        overflow: hidden;
        margin-bottom: 20px;
    }
    .sp-hero-accent { height: 5px; background: linear-gradient(90deg, #f97316, #eab308, #fb923c); }
    .sp-hero-accent.ongoing   { background: linear-gradient(90deg, #22c55e, #4ade80); }
    .sp-hero-accent.completed { background: linear-gradient(90deg, #64748b, #94a3b8); }
    .sp-hero-accent.cancelled { background: linear-gradient(90deg, #ef4444, #f87171); }

    .sp-hero-body { padding: 28px 32px; display: flex; align-items: flex-start; justify-content: space-between; gap: 20px; }

    .sp-badges { display: flex; gap: 8px; margin-bottom: 14px; flex-wrap: wrap; }
    .sp-status-pill {
        display: inline-flex; align-items: center; gap: 5px;
        font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px;
        padding: 4px 12px; border-radius: 20px;
    }
    .sp-status-pill::before { content: ''; width: 6px; height: 6px; border-radius: 50%; background: currentColor; display: inline-block; }
    .sp-status-pill.upcoming  { background: rgba(249,115,22,0.15); color: #f97316; border: 1px solid rgba(249,115,22,0.3); }
    .sp-status-pill.ongoing   { background: rgba(34,197,94,0.12);  color: #4ade80; border: 1px solid rgba(34,197,94,0.3); }
    .sp-status-pill.completed { background: rgba(100,116,139,0.15); color: #94a3b8; border: 1px solid rgba(100,116,139,0.3); }
    .sp-status-pill.cancelled { background: rgba(239,68,68,0.12);  color: #f87171; border: 1px solid rgba(239,68,68,0.3); }
    .sp-sport-pill {
        display: inline-flex; align-items: center; gap: 5px;
        background: rgba(234,179,8,0.1); border: 1px solid rgba(234,179,8,0.25);
        color: #eab308; font-size: 0.65rem; font-weight: 700; text-transform: uppercase;
        letter-spacing: 0.8px; padding: 4px 12px; border-radius: 20px;
    }

    .sp-event-title {
        font-family: 'Bebas Neue', sans-serif;
        font-size: clamp(1.8rem, 4vw, 2.8rem);
        letter-spacing: 2px; color: #f1f5f9; line-height: 1; margin-bottom: 0;
    }

    /* Admin actions */
    .sp-admin-actions { display: flex; gap: 8px; flex-shrink: 0; }
    .sp-btn-edit {
        display: inline-flex; align-items: center; gap: 6px;
        background: rgba(245,158,11,0.12); border: 1px solid rgba(245,158,11,0.3);
        color: #fbbf24; font-size: 0.78rem; font-weight: 600;
        padding: 8px 16px; border-radius: 10px;
        text-decoration: none; transition: background 0.2s;
        font-family: 'DM Sans', sans-serif;
    }
    .sp-btn-edit:hover { background: rgba(245,158,11,0.22); color: #fbbf24; }
    .sp-btn-delete {
        display: inline-flex; align-items: center; gap: 6px;
        background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.25);
        color: #f87171; font-size: 0.78rem; font-weight: 600;
        padding: 8px 16px; border-radius: 10px;
        cursor: pointer; transition: background 0.2s;
        font-family: 'DM Sans', sans-serif;
    }
    .sp-btn-delete:hover { background: rgba(239,68,68,0.2); }

    /* Info Grid */
    .sp-info-grid {
        display: grid; grid-template-columns: 1fr 1fr;
        gap: 12px; padding: 0 32px 28px;
    }
    .sp-info-tile {
        background: #0f172a;
        border: 1px solid rgba(255,255,255,0.06);
        border-radius: 14px; padding: 18px 20px;
    }
    .sp-info-tile-label {
        font-size: 0.65rem; font-weight: 700; text-transform: uppercase;
        letter-spacing: 0.8px; color: #475569; margin-bottom: 8px;
        display: flex; align-items: center; gap: 7px;
    }
    .sp-info-tile-label i { font-size: 0.85rem; }
    .sp-info-tile-val { font-size: 0.9rem; color: #e2e8f0; font-weight: 500; }
    .sp-info-tile-sub { font-size: 0.75rem; color: #64748b; margin-top: 2px; }

    /* Participants progress */
    .sp-prog-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px; }
    .sp-prog-count { font-family: 'Bebas Neue', sans-serif; font-size: 1.4rem; color: #f97316; line-height: 1; }
    .sp-prog-max { font-size: 0.72rem; color: #64748b; }
    .sp-prog-track { height: 6px; background: rgba(255,255,255,0.06); border-radius: 10px; overflow: hidden; }
    .sp-prog-fill { height: 100%; border-radius: 10px; background: linear-gradient(90deg, #22c55e, #4ade80); transition: width 0.6s ease; }
    .sp-prog-fill.warn { background: linear-gradient(90deg, #f97316, #fb923c); }
    .sp-prog-fill.full { background: linear-gradient(90deg, #ef4444, #f87171); }

    /* Description */
    .sp-desc-section { padding: 0 32px 28px; }
    .sp-desc-label {
        font-size: 0.65rem; font-weight: 700; text-transform: uppercase;
        letter-spacing: 0.8px; color: #f97316; margin-bottom: 12px;
        display: flex; align-items: center; gap: 8px;
    }
    .sp-desc-label::after { content: ''; flex: 1; height: 1px; background: rgba(249,115,22,0.15); }
    .sp-desc-text { font-size: 0.87rem; color: #94a3b8; line-height: 1.7; }

    /* Action Section */
    .sp-action-section {
        padding: 20px 32px 28px;
        border-top: 1px solid rgba(255,255,255,0.05);
    }

    /* Guest banner */
    .sp-guest-banner {
        background: rgba(59,130,246,0.08);
        border: 1px solid rgba(59,130,246,0.2);
        border-left: 3px solid #3b82f6;
        border-radius: 12px; padding: 16px 20px;
        display: flex; align-items: center; gap: 14px;
        font-size: 0.85rem; color: #93c5fd;
    }
    .sp-guest-banner i { font-size: 1.1rem; flex-shrink: 0; }
    .sp-guest-banner a { color: #f97316; font-weight: 600; text-decoration: none; }
    .sp-guest-banner a:hover { color: #eab308; }
    .sp-guest-banner .sep { color: #334155; margin: 0 4px; }

    /* Already registered */
    .sp-already-banner {
        background: rgba(34,197,94,0.08);
        border: 1px solid rgba(34,197,94,0.2);
        border-left: 3px solid #22c55e;
        border-radius: 12px; padding: 16px 20px;
        display: flex; align-items: center; gap: 14px;
        font-size: 0.85rem; color: #86efac;
    }
    .sp-already-banner a { color: #4ade80; font-weight: 600; text-decoration: none; }
    .sp-already-banner a:hover { text-decoration: underline; }

    /* Full banner */
    .sp-full-banner {
        background: rgba(239,68,68,0.08);
        border: 1px solid rgba(239,68,68,0.2);
        border-left: 3px solid #ef4444;
        border-radius: 12px; padding: 16px 20px;
        display: flex; align-items: center; gap: 14px;
        font-size: 0.85rem; color: #fca5a5;
    }

    /* Closed banner */
    .sp-closed-banner {
        background: rgba(100,116,139,0.1);
        border: 1px solid rgba(100,116,139,0.2);
        border-left: 3px solid #64748b;
        border-radius: 12px; padding: 16px 20px;
        display: flex; align-items: center; gap: 14px;
        font-size: 0.85rem; color: #94a3b8;
    }

    /* Register button */
    .sp-btn-register {
        display: flex; align-items: center; justify-content: center; gap: 10px;
        width: 100%; padding: 15px;
        background: linear-gradient(135deg, #f97316, #ea580c);
        border: none; border-radius: 12px;
        color: white; font-size: 0.95rem; font-weight: 700;
        font-family: 'DM Sans', sans-serif;
        text-decoration: none; cursor: pointer;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .sp-btn-register:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(249,115,22,0.3); color: white; }

    @media (max-width: 640px) {
        .sp-hero-body { flex-direction: column; padding: 20px; }
        .sp-info-grid { grid-template-columns: 1fr; padding: 0 20px 20px; }
        .sp-desc-section, .sp-action-section { padding-left: 20px; padding-right: 20px; }
    }
</style>

<div class="sp-show">

    <a href="{{ route('events.index') }}" class="sp-back">
        <i class="bi bi-arrow-left"></i> Back to Events
    </a>

    <div class="sp-hero-card">
        <div class="sp-hero-accent {{ $event->status }}"></div>

        <div class="sp-hero-body">
            <div>
                <div class="sp-badges">
                    <span class="sp-status-pill {{ $event->status }}">{{ ucfirst($event->status) }}</span>
                    @if($event->sport_type)
                        <span class="sp-sport-pill">
                            <i class="bi bi-trophy-fill" style="font-size:9px"></i>
                            {{ $event->sport_type }}
                        </span>
                    @endif
                </div>
                <h1 class="sp-event-title">{{ $event->event_name }}</h1>
            </div>

            @auth
                @if(auth()->user()->isAdmin())
                    <div class="sp-admin-actions">
                        <a href="{{ route('events.edit', $event) }}" class="sp-btn-edit">
                            <i class="bi bi-pencil-fill"></i> Edit
                        </a>
                        <a href="{{ route('teams.index', $event) }}" class="sp-btn-edit" style="background:rgba(34,197,94,0.12);border-color:rgba(34,197,94,0.3);color:#4ade80;">
                            <i class="bi bi-people-fill"></i> Teams
                        </a>
                        <form action="{{ route('events.destroy', $event) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Delete this event permanently?')">
                            @csrf @method('DELETE')
                            <button class="sp-btn-delete" type="submit">
                                <i class="bi bi-trash3-fill"></i> Delete
                            </button>
                        </form>
                    </div>
                @endif
            @endauth
        </div>

        {{-- Info Tiles --}}
        <div class="sp-info-grid">

            {{-- Location --}}
            <div class="sp-info-tile">
                <div class="sp-info-tile-label" style="color:#f87171">
                    <i class="bi bi-geo-alt-fill" style="color:#ef4444"></i> Location
                </div>
                <div class="sp-info-tile-val">{{ $event->location }}</div>
            </div>

            {{-- Date & Time --}}
            <div class="sp-info-tile">
                <div class="sp-info-tile-label" style="color:#93c5fd">
                    <i class="bi bi-calendar3" style="color:#60a5fa"></i> Date & Time
                </div>
                <div class="sp-info-tile-val">{{ $event->event_date->format('F j, Y') }}</div>
                <div class="sp-info-tile-sub">{{ $event->event_date->format('g:i A') }}
                    @if($event->event_end_date)
                        — {{ $event->event_end_date->format('F j, Y') }}
                    @endif
                </div>
            </div>

            {{-- Participants --}}
            <div class="sp-info-tile">
                <div class="sp-info-tile-label" style="color:#86efac">
                    <i class="bi bi-people-fill" style="color:#22c55e"></i> Participants
                </div>
               @php
                    $active = $event->activeRegistrationsCount();
                    $pct = $event->max_participants > 0
                        ? min(100, round(($active / $event->max_participants) * 100))
                        : 0;
                    $fillCls = $pct >= 100 ? 'full' : ($pct >= 70 ? 'warn' : '');
                @endphp

            {{-- Organizer --}}
            <div class="sp-info-tile">
                <div class="sp-info-tile-label" style="color:#c4b5fd">
                    <i class="bi bi-person-fill" style="color:#a78bfa"></i> Organizer
                </div>
                <div class="sp-info-tile-val">{{ $event->creator->name ?? 'Admin User' }}</div>
                <div class="sp-info-tile-sub">Event Administrator</div>
            </div>

        </div>

        {{-- Description --}}
        @if($event->description)
            <div class="sp-desc-section">
                <div class="sp-desc-label"><i class="bi bi-file-text-fill"></i> Description</div>
                <p class="sp-desc-text">{{ $event->description }}</p>
            </div>
        @endif

        {{-- Action --}}
        <div class="sp-action-section">
            @guest
                <div class="sp-guest-banner">
                    <i class="bi bi-info-circle-fill"></i>
                    <span>
                        <a href="/login">Login</a>
                        <span class="sep">or</span>
                        <a href="/register">Create an account</a>
                        to register for this event!
                    </span>
                </div>
            @endguest

            @auth
                @if(!auth()->user()->isAdmin())
                    @if($alreadyRegistered)
                        <div class="sp-already-banner">
                            <i class="bi bi-check-circle-fill" style="color:#22c55e; font-size:1.1rem; flex-shrink:0"></i>
                            <span>
                                You're already registered for this event!
                                <a href="/registrations">View your registrations →</a>
                            </span>
                        </div>
                    @elseif($event->isFull())
                        <div class="sp-full-banner">
                            <i class="bi bi-slash-circle-fill" style="font-size:1.1rem; flex-shrink:0"></i>
                            <span>Sorry, this event is already full. Check back for cancellations.</span>
                        </div>
                    @elseif($event->status == 'upcoming')             
                               <a href="{{ route('registrations.create') }}?event_id={{ $event->event_id }}" class="sp-btn-register">
                            <i class="bi bi-person-plus-fill"></i> Register for This Event
                        </a>
                    @else
                        <div class="sp-closed-banner">
                            <i class="bi bi-lock-fill" style="font-size:1.1rem; flex-shrink:0"></i>
                            <span>Registration is closed — this event is {{ ucfirst($event->status) }}.</span>
                        </div>
                    @endif
                @endif
            @endauth
        </div>

    </div>
</div>
@endsection