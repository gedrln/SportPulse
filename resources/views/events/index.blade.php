@extends('layouts.app')
@section('title', 'Events')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,400;0,500;0,600;1,400&family=Bebas+Neue&display=swap');

    .sp-events { font-family: 'DM Sans', sans-serif; }

    /* Page Header */
    .sp-page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
        padding-bottom: 20px;
        border-bottom: 1px solid rgba(249,115,22,0.2);
    }
    .sp-page-title {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 2.4rem;
        color: #f1f5f9;
        letter-spacing: 2px;
        line-height: 1;
    }
    .sp-page-title span { color: #f97316; }
    .sp-page-sub { color: #64748b; font-size: 0.8rem; margin-top: 4px; }

    /* Filter Bar */
    .sp-filter-bar {
        background: #1e293b;
        border: 1px solid rgba(255,255,255,0.06);
        border-radius: 14px;
        padding: 16px 20px;
        margin-bottom: 36px;
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }
    .sp-filter-label {
        font-size: 0.72rem;
        font-weight: 600;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        margin-right: 4px;
    }
    .sp-filter-select {
        background: #0f172a;
        border: 1px solid rgba(255,255,255,0.1);
        color: #cbd5e1;
        font-size: 0.82rem;
        padding: 8px 14px;
        border-radius: 10px;
        font-family: 'DM Sans', sans-serif;
        outline: none;
        transition: border-color 0.2s;
        min-width: 140px;
    }
    .sp-filter-select:focus { border-color: rgba(249,115,22,0.5); }
    .sp-filter-btn {
        background: #f97316;
        border: none;
        color: white;
        font-size: 0.82rem;
        padding: 8px 20px;
        border-radius: 10px;
        font-family: 'DM Sans', sans-serif;
        cursor: pointer;
        font-weight: 600;
        transition: background 0.2s;
    }
    .sp-filter-btn:hover { background: #ea580c; }
    .sp-reset-btn {
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.1);
        color: #94a3b8;
        font-size: 0.82rem;
        padding: 8px 16px;
        border-radius: 10px;
        font-family: 'DM Sans', sans-serif;
        cursor: pointer;
        text-decoration: none;
        transition: background 0.2s;
        display: inline-block;
    }
    .sp-reset-btn:hover { background: rgba(255,255,255,0.1); color: #cbd5e1; }

    /* Section Headers */
    .sp-section {
        margin-bottom: 40px;
    }
    .sp-section-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 18px;
        padding-bottom: 12px;
        border-bottom: 1px solid rgba(255,255,255,0.06);
    }
    .sp-section-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        flex-shrink: 0;
    }
    .sp-section-dot.upcoming  { background: #f97316; box-shadow: 0 0 8px rgba(249,115,22,0.6); }
    .sp-section-dot.ongoing   { background: #22c55e; box-shadow: 0 0 8px rgba(34,197,94,0.6); }
    .sp-section-dot.completed { background: #475569; }
    .sp-section-title {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 1.3rem;
        letter-spacing: 1.5px;
        line-height: 1;
    }
    .sp-section-title.upcoming  { color: #f97316; }
    .sp-section-title.ongoing   { color: #4ade80; }
    .sp-section-title.completed { color: #64748b; }
    .sp-section-count {
        background: rgba(255,255,255,0.06);
        border: 1px solid rgba(255,255,255,0.08);
        color: #64748b;
        font-size: 0.7rem;
        font-weight: 600;
        padding: 3px 10px;
        border-radius: 20px;
    }

    /* Events Grid */
    .sp-events-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
    }

    /* Event Card */
    .sp-event-card {
        background: #1e293b;
        border: 1px solid rgba(255,255,255,0.06);
        border-radius: 16px;
        overflow: hidden;
        transition: transform 0.2s, border-color 0.2s;
        position: relative;
    }
    .sp-event-card:hover {
        transform: translateY(-3px);
        border-color: rgba(249,115,22,0.3);
    }
    .sp-event-card-accent {
        height: 4px;
        background: linear-gradient(90deg, #f97316, #ea580c);
    }
    .sp-event-card-accent.ongoing   { background: linear-gradient(90deg, #22c55e, #16a34a); }
    .sp-event-card-accent.completed { background: linear-gradient(90deg, #64748b, #475569); }
    .sp-event-card-accent.full      { background: linear-gradient(90deg, #ef4444, #dc2626); }

    .sp-event-card-body { padding: 20px; }

    /* Status Badge */
    .sp-status-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 0.65rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        padding: 4px 10px;
        border-radius: 20px;
        margin-bottom: 12px;
    }
    .sp-status-badge.upcoming  { background: rgba(249,115,22,0.15); color: #f97316; border: 1px solid rgba(249,115,22,0.3); }
    .sp-status-badge.ongoing   { background: rgba(34,197,94,0.12);  color: #4ade80; border: 1px solid rgba(34,197,94,0.3); }
    .sp-status-badge.completed { background: rgba(100,116,139,0.15); color: #94a3b8; border: 1px solid rgba(100,116,139,0.3); }
    .sp-status-badge::before {
        content: '';
        width: 6px; height: 6px;
        border-radius: 50%;
        background: currentColor;
        display: inline-block;
    }

    .sp-event-name {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 1.5rem;
        color: #f1f5f9;
        letter-spacing: 1px;
        line-height: 1.1;
        margin-bottom: 14px;
    }

    /* Meta Info */
    .sp-event-meta { display: flex; flex-direction: column; gap: 6px; margin-bottom: 16px; }
    .sp-meta-row { display: flex; align-items: center; gap: 8px; font-size: 0.78rem; color: #64748b; }
    .sp-meta-row i { color: #475569; font-size: 0.82rem; width: 14px; }
    .sp-meta-row span { color: #94a3b8; }

    /* Participants bar */
    .sp-participants { margin-bottom: 18px; }
    .sp-participants-label {
        display: flex;
        justify-content: space-between;
        font-size: 0.72rem;
        color: #64748b;
        margin-bottom: 6px;
        font-weight: 500;
    }
    .sp-participants-label span { color: #94a3b8; }
    .sp-progress-track {
        height: 5px;
        background: rgba(255,255,255,0.06);
        border-radius: 10px;
        overflow: hidden;
    }
    .sp-progress-fill {
        height: 100%;
        border-radius: 10px;
        background: linear-gradient(90deg, #f97316, #fb923c);
        transition: width 0.5s ease;
    }
    .sp-progress-fill.full { background: linear-gradient(90deg, #ef4444, #f87171); }
    .sp-progress-fill.safe { background: linear-gradient(90deg, #22c55e, #4ade80); }

    /* Action Buttons */
    .sp-card-actions { display: flex; flex-direction: column; gap: 8px; }
    .sp-btn-view {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 9px 0;
        border-radius: 10px;
        font-size: 0.8rem;
        font-weight: 600;
        font-family: 'DM Sans', sans-serif;
        text-decoration: none;
        transition: all 0.2s;
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.1);
        color: #cbd5e1;
    }
    .sp-btn-view:hover { background: rgba(255,255,255,0.1); color: #f1f5f9; }
    .sp-btn-register {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 9px 0;
        border-radius: 10px;
        font-size: 0.8rem;
        font-weight: 600;
        font-family: 'DM Sans', sans-serif;
        text-decoration: none;
        transition: all 0.2s;
        background: #f97316;
        border: none;
        color: white;
        cursor: pointer;
    }
    .sp-btn-register:hover { background: #ea580c; color: white; }
    .sp-btn-registered {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 9px 0;
        border-radius: 10px;
        font-size: 0.8rem;
        font-weight: 600;
        background: rgba(34,197,94,0.1);
        border: 1px solid rgba(34,197,94,0.3);
        color: #4ade80;
        cursor: default;
    }
    .sp-btn-full {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 9px 0;
        border-radius: 10px;
        font-size: 0.8rem;
        font-weight: 600;
        background: rgba(239,68,68,0.08);
        border: 1px solid rgba(239,68,68,0.2);
        color: #f87171;
        cursor: not-allowed;
    }

    /* Sport type chip */
    .sp-sport-chip {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        background: rgba(249,115,22,0.08);
        border: 1px solid rgba(249,115,22,0.15);
        color: #f97316;
        font-size: 0.7rem;
        font-weight: 600;
        padding: 3px 9px;
        border-radius: 6px;
        margin-bottom: 10px;
    }

    /* Empty state */
    .sp-empty-state {
        grid-column: span 3;
        text-align: center;
        padding: 40px 20px;
        color: #475569;
    }
    .sp-empty-icon { font-size: 2.5rem; display: block; margin-bottom: 10px; }
    .sp-empty-title { font-family: 'Bebas Neue', sans-serif; font-size: 1.2rem; color: #64748b; letter-spacing: 1px; }

    /* No results (filtered) */
    .sp-no-results {
        text-align: center;
        padding: 60px 20px;
        color: #475569;
    }
    .sp-no-results-icon { font-size: 3rem; display: block; margin-bottom: 12px; }
    .sp-no-results-title { font-family: 'Bebas Neue', sans-serif; font-size: 1.5rem; color: #64748b; letter-spacing: 1px; }

    /* Admin add event btn */
    .sp-add-btn {
        background: #f97316;
        border: none;
        color: white;
        font-size: 0.82rem;
        padding: 10px 22px;
        border-radius: 10px;
        font-family: 'DM Sans', sans-serif;
        cursor: pointer;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: background 0.2s;
    }
    .sp-add-btn:hover { background: #ea580c; color: white; }

    @media (max-width: 900px) {
        .sp-events-grid { grid-template-columns: repeat(2, 1fr); }
        .sp-empty-state { grid-column: span 2; }
    }
    @media (max-width: 600px) {
        .sp-events-grid { grid-template-columns: 1fr; }
        .sp-empty-state { grid-column: span 1; }
        .sp-page-header { flex-direction: column; align-items: flex-start; gap: 12px; }
    }
</style>

@php
    /* Reusable macro to count total events shown */
    $totalCount = $groupedEvents
        ? collect($groupedEvents)->flatten()->count()
        : ($events ? $events->count() : 0);
@endphp

<div class="sp-events">

    {{-- Page Header --}}
    <div class="sp-page-header">
        <div>
            <div class="sp-page-title">Sports <span>Events</span></div>
            <div class="sp-page-sub">{{ $totalCount }} event{{ $totalCount != 1 ? 's' : '' }} found</div>
        </div>
        @if(auth()->check() && auth()->user()->isAdmin())
            <a href="{{ route('events.create') }}" class="sp-add-btn">
                <i class="bi bi-plus-lg"></i> Add Event
            </a>
        @endif
    </div>

    {{-- Filter Bar --}}
    <form method="GET" action="{{ route('events.index') }}">
        <div class="sp-filter-bar">
            <span class="sp-filter-label">Filter</span>
            <select name="sport_type" class="sp-filter-select">
                <option value="">All Sports</option>
                @foreach($sportTypes ?? [] as $sport)
                    <option value="{{ $sport }}" {{ request('sport_type') == $sport ? 'selected' : '' }}>{{ $sport }}</option>
                @endforeach
            </select>
            <select name="status" class="sp-filter-select">
                <option value="">All Status</option>
                <option value="upcoming"  {{ request('status') == 'upcoming'  ? 'selected' : '' }}>Upcoming</option>
                <option value="ongoing"   {{ request('status') == 'ongoing'   ? 'selected' : '' }}>Ongoing</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
            </select>
            <button type="submit" class="sp-filter-btn"><i class="bi bi-funnel-fill me-1"></i>Filter</button>
            <a href="{{ route('events.index') }}" class="sp-reset-btn"><i class="bi bi-arrow-counterclockwise me-1"></i>Reset</a>
        </div>
    </form>

    {{-- ============================================================
         GROUPED VIEW (no status filter active)
         Shows three separate sections: Upcoming, Ongoing, Completed
    ============================================================ --}}
    @if($groupedEvents)

        @php
            $sections = [
                'upcoming'  => ['label' => 'Upcoming',  'icon' => 'bi-calendar-event-fill'],
                'ongoing'   => ['label' => 'Ongoing',   'icon' => 'bi-lightning-charge-fill'],
                'completed' => ['label' => 'Completed', 'icon' => 'bi-check-circle-fill'],
            ];
        @endphp

        @foreach($sections as $statusKey => $meta)
            @php $sectionEvents = $groupedEvents[$statusKey]; @endphp

            {{-- Only render section if it has events --}}
            @if($sectionEvents->count() > 0)
            <div class="sp-section">
                <div class="sp-section-header">
                    <div class="sp-section-dot {{ $statusKey }}"></div>
                    <div class="sp-section-title {{ $statusKey }}">{{ $meta['label'] }}</div>
                    <span class="sp-section-count">{{ $sectionEvents->count() }} {{ $sectionEvents->count() == 1 ? 'event' : 'events' }}</span>
                </div>

                <div class="sp-events-grid">
                    @foreach($sectionEvents as $event)
                        @php
                            $isFull      = $event->participants >= $event->max_participants;
                            $fillPct     = $event->max_participants > 0 ? min(100, round(($event->participants / $event->max_participants) * 100)) : 0;
                            $fillClass   = $fillPct >= 100 ? 'full' : ($fillPct < 60 ? 'safe' : '');
                            $accentClass = $event->status == 'ongoing' ? 'ongoing' : ($event->status == 'completed' ? 'completed' : ($isFull ? 'full' : ''));

                            $userRegistered = false;
                            if(auth()->check() && !auth()->user()->isAdmin()) {
                                $userRegistered = $event->registrations()
                                    ->where('user_name', auth()->user()->username)
                                    ->whereIn('status', ['pending','approved'])
                                    ->exists();
                            }
                        @endphp
                        <div class="sp-event-card">
                            <div class="sp-event-card-accent {{ $accentClass }}"></div>
                            <div class="sp-event-card-body">
                                <span class="sp-status-badge {{ $event->status }}">{{ ucfirst($event->status) }}</span>
                                @if($event->sport_type)
                                    <div class="sp-sport-chip"><i class="bi bi-trophy-fill" style="font-size:10px"></i> {{ $event->sport_type }}</div>
                                @endif
                                <div class="sp-event-name">{{ $event->event_name }}</div>

                                <div class="sp-event-meta">
                                    <div class="sp-meta-row">
                                        <i class="bi bi-geo-alt-fill"></i>
                                        <span>{{ $event->location }}</span>
                                    </div>
                                    <div class="sp-meta-row">
                                        <i class="bi bi-calendar3"></i>
                                        <span>
                                            {{ $event->event_date->format('M d, Y g:i A') }}
                                            @if($event->event_end_date)
                                                — {{ $event->event_end_date->format('M d, Y') }}
                                            @endif
                                        </span>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <span><i class="bi bi-people"></i> Participants</span>
                                    <span class="fw-bold">{{ $event->activeRegistrationsCount() }}/{{ $event->max_participants }}</span>
                                </div>
                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar bg-success"
                                        style="width: {{ $event->max_participants > 0 ? ($event->activeRegistrationsCount() / $event->max_participants) * 100 : 0 }}%">
                                    </div>
                                </div>

                                <div class="sp-card-actions">
                                    <a href="{{ route('events.show', $event) }}" class="sp-btn-view">
                                        <i class="bi bi-eye"></i> View Details
                                    </a>
                                    @auth
                                        @if(!auth()->user()->isAdmin())
                                            @if($userRegistered)
                                                <div class="sp-btn-registered">
                                                    <i class="bi bi-check-circle-fill"></i> Already Registered
                                                </div>
                                            @elseif($isFull || $event->status == 'completed')
                                                <div class="sp-btn-full">
                                                    <i class="bi bi-slash-circle"></i> {{ $isFull ? 'Event Full' : 'Closed' }}
                                                </div>
                                            @elseif($event->status == 'upcoming' || $event->status == 'ongoing')
                                                <a href="{{ route('registrations.create') }}?event_id={{ $event->event_id }}" class="sp-btn-register">
                                                    <i class="bi bi-person-plus-fill"></i> Register Now
                                                </a>
                                            @endif
                                        @else
                                            <a href="{{ route('events.edit', $event) }}" class="sp-btn-view">
                                                <i class="bi bi-pencil-fill"></i> Edit Event
                                            </a>
                                        @endif
                                    @endauth
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif
        @endforeach

        {{-- All sections empty --}}
        @if(collect($groupedEvents)->flatten()->count() == 0)
            <div class="sp-no-results">
                <span class="sp-no-results-icon">🏟️</span>
                <div class="sp-no-results-title">No Events Found</div>
                <p style="color:#475569; font-size:0.82rem; margin-top:8px;">Check back later for upcoming events.</p>
            </div>
        @endif

    {{-- ============================================================
         FILTERED VIEW (a specific status was selected)
         Shows a flat grid under that status's section header only
    ============================================================ --}}
    @else
        <div class="sp-section">
            <div class="sp-section-header">
                <div class="sp-section-dot {{ $filterStatus }}"></div>
                <div class="sp-section-title {{ $filterStatus }}">{{ ucfirst($filterStatus) }}</div>
                <span class="sp-section-count">{{ $events->count() }} {{ $events->count() == 1 ? 'event' : 'events' }}</span>
            </div>

            <div class="sp-events-grid">
                @forelse($events as $event)
                    @php
                        $isFull      = $event->participants >= $event->max_participants;
                        $fillPct     = $event->max_participants > 0 ? min(100, round(($event->participants / $event->max_participants) * 100)) : 0;
                        $fillClass   = $fillPct >= 100 ? 'full' : ($fillPct < 60 ? 'safe' : '');
                        $accentClass = $event->status == 'ongoing' ? 'ongoing' : ($event->status == 'completed' ? 'completed' : ($isFull ? 'full' : ''));

                        $userRegistered = false;
                        if(auth()->check() && !auth()->user()->isAdmin()) {
                            $userRegistered = $event->registrations()
                                ->where('user_name', auth()->user()->username)
                                ->whereIn('status', ['pending','approved'])
                                ->exists();
                        }
                    @endphp
                    <div class="sp-event-card">
                        <div class="sp-event-card-accent {{ $accentClass }}"></div>
                        <div class="sp-event-card-body">
                            <span class="sp-status-badge {{ $event->status }}">{{ ucfirst($event->status) }}</span>
                            @if($event->sport_type)
                                <div class="sp-sport-chip"><i class="bi bi-trophy-fill" style="font-size:10px"></i> {{ $event->sport_type }}</div>
                            @endif
                            <div class="sp-event-name">{{ $event->event_name }}</div>

                            <div class="sp-event-meta">
                                <div class="sp-meta-row">
                                    <i class="bi bi-geo-alt-fill"></i>
                                    <span>{{ $event->location }}</span>
                                </div>
                                <div class="sp-meta-row">
                                    <i class="bi bi-calendar3"></i>
                                    <span>
                                        {{ $event->event_date->format('M d, Y g:i A') }}
                                        @if($event->event_end_date)
                                            — {{ $event->event_end_date->format('M d, Y') }}
                                        @endif
                                    </span>
                                </div>
                            </div>

                            <div class="sp-participants">
                                <div class="sp-participants-label">
                                    <span><i class="bi bi-people-fill me-1"></i>Participants</span>
                                    <span>{{ $event->participants }}/{{ $event->max_participants }}</span>
                                </div>
                                <div class="sp-progress-track">
                                    <div class="sp-progress-fill {{ $fillClass }}" style="width: {{ $fillPct }}%"></div>
                                </div>
                            </div>

                            <div class="sp-card-actions">
                                <a href="{{ route('events.show', $event) }}" class="sp-btn-view">
                                    <i class="bi bi-eye"></i> View Details
                                </a>
                                @auth
                                    @if(!auth()->user()->isAdmin())
                                        @if($userRegistered)
                                            <div class="sp-btn-registered">
                                                <i class="bi bi-check-circle-fill"></i> Already Registered
                                            </div>
                                        @elseif($isFull || $event->status == 'completed')
                                            <div class="sp-btn-full">
                                                <i class="bi bi-slash-circle"></i> {{ $isFull ? 'Event Full' : 'Closed' }}
                                            </div>
                                        @elseif($event->status == 'upcoming' || $event->status == 'ongoing')
                                            <a href="{{ route('registrations.create') }}?event_id={{ $event->event_id }}" class="sp-btn-register">
                                                <i class="bi bi-person-plus-fill"></i> Register Now
                                            </a>
                                        @endif
                                    @else
                                        <a href="{{ route('events.edit', $event) }}" class="sp-btn-view">
                                            <i class="bi bi-pencil-fill"></i> Edit Event
                                        </a>
                                    @endif
                                @endauth
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="sp-empty-state">
                        <span class="sp-empty-icon">🏟️</span>
                        <div class="sp-empty-title">No {{ ucfirst($filterStatus) }} Events</div>
                        <p style="color:#475569; font-size:0.82rem; margin-top:8px;">Try adjusting your filters or check back later.</p>
                    </div>
                @endforelse
            </div>
        </div>
    @endif

</div>
@endsection