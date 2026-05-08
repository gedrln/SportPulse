@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css">

<style>
    @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&family=Bebas+Neue&display=swap');

    .sp-dash { font-family: 'DM Sans', sans-serif; }

    /* Hero */
    .sp-hero {
        background: linear-gradient(135deg, #1e293b 0%, #1e1a2e 100%);
        border: 1px solid rgba(249,115,22,0.2);
        border-radius: 16px;
        padding: 28px 32px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        position: relative;
        overflow: hidden;
    }
    .sp-hero::before {
        content: '';
        position: absolute;
        right: -30px; top: -30px;
        width: 180px; height: 180px;
        border-radius: 50%;
        background: rgba(249,115,22,0.06);
    }
    .sp-hero::after {
        content: '';
        position: absolute;
        right: 40px; top: 20px;
        width: 100px; height: 100px;
        border-radius: 50%;
        background: rgba(249,115,22,0.04);
    }
    .sp-hero-badge {
        background: rgba(249,115,22,0.15);
        border: 1px solid rgba(249,115,22,0.3);
        color: #f97316;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.72rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: inline-block;
        margin-bottom: 10px;
    }
    .sp-hero-title {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 2.2rem;
        letter-spacing: 1px;
        color: #f1f5f9;
        line-height: 1;
    }
    .sp-hero-sub { color: #94a3b8; font-size: 0.85rem; margin-top: 6px; }

    /* Notification Banner */
    .sp-notif {
        border-radius: 12px;
        padding: 14px 18px;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 14px;
    }
    .sp-notif.urgent {
        background: rgba(239,68,68,0.1);
        border: 1px solid rgba(239,68,68,0.3);
        border-left: 3px solid #ef4444;
    }
    .sp-notif.soon {
        background: rgba(249,115,22,0.08);
        border: 1px solid rgba(249,115,22,0.25);
        border-left: 3px solid #f97316;
    }
    .sp-notif-icon {
        font-size: 18px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .sp-notif.urgent .sp-notif-icon { color: #f87171; }
    .sp-notif.soon   .sp-notif-icon { color: #fb923c; }
    .sp-notif-text { font-size: 0.83rem; flex: 1; }
    .sp-notif.urgent .sp-notif-text { color: #fca5a5; }
    .sp-notif.urgent .sp-notif-text strong { color: #fef2f2; }
    .sp-notif.soon .sp-notif-text { color: #fdba74; }
    .sp-notif.soon .sp-notif-text strong { color: #fff7ed; }
    .sp-notif-badge-red   { background: #ef4444; color: white; font-size: 0.68rem; font-weight: 700; padding: 2px 8px; border-radius: 20px; margin-left: 4px; }
    .sp-notif-badge-orange { background: #f97316; color: white; font-size: 0.68rem; font-weight: 700; padding: 2px 8px; border-radius: 20px; margin-left: 4px; }
    .sp-notif-close {
        background: none;
        border: none;
        color: #64748b;
        font-size: 1rem;
        cursor: pointer;
        padding: 0;
        line-height: 1;
        display: flex;
        align-items: center;
        transition: color 0.15s;
    }
    .sp-notif-close:hover { color: #94a3b8; }

    /* Stat Cards */
    .sp-stats { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 24px; }
    .sp-stat {
        background: #1e293b;
        border: 1px solid rgba(255,255,255,0.06);
        border-radius: 14px;
        padding: 20px 22px;
        position: relative;
        overflow: hidden;
    }
    .sp-stat::before { content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 3px; }
    .sp-stat.blue::before  { background: #3b82f6; }
    .sp-stat.green::before { background: #22c55e; }
    .sp-stat.orange::before { background: #f97316; }
    .sp-stat.red::before   { background: #ef4444; }
    .sp-stat-label { font-size: 0.72rem; color: #64748b; text-transform: uppercase; letter-spacing: 0.8px; font-weight: 600; margin-bottom: 10px; }
    .sp-stat-num { font-family: 'Bebas Neue', sans-serif; font-size: 2.4rem; line-height: 1; }
    .sp-stat.blue .sp-stat-num  { color: #60a5fa; }
    .sp-stat.green .sp-stat-num { color: #4ade80; }
    .sp-stat.orange .sp-stat-num { color: #fb923c; }
    .sp-stat.red .sp-stat-num   { color: #f87171; }
    .sp-stat-sub { font-size: 0.72rem; color: #475569; margin-top: 6px; }

    .sp-stats-admin { grid-template-columns: repeat(4, 1fr); }

    /* Cards */
    .sp-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 24px; }
    .sp-card { background: #1e293b; border: 1px solid rgba(255,255,255,0.06); border-radius: 14px; overflow: hidden; }
    .sp-card-full { grid-column: span 2; }
    .sp-card-head {
        padding: 16px 20px;
        border-bottom: 1px solid rgba(255,255,255,0.06);
        display: flex; align-items: center; justify-content: space-between;
    }
    .sp-card-title { font-size: 0.82rem; font-weight: 600; color: #cbd5e1; text-transform: uppercase; letter-spacing: 0.6px; }
    .sp-card-badge { background: rgba(249,115,22,0.15); color: #f97316; font-size: 0.68rem; padding: 2px 8px; border-radius: 10px; font-weight: 600; }
    .sp-card-body { padding: 4px 0; }

    /* Rows */
    .sp-row { padding: 12px 20px; border-bottom: 1px solid rgba(255,255,255,0.04); display: flex; align-items: center; gap: 12px; }
    .sp-row:last-child { border-bottom: none; }
    .sp-row-info { flex: 1; min-width: 0; }
    .sp-row-name { font-size: 0.82rem; font-weight: 500; color: #e2e8f0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .sp-row-sub  { font-size: 0.72rem; color: #64748b; margin-top: 2px; }

    /* Pills */
    .sp-pill { font-size: 0.68rem; font-weight: 600; padding: 3px 10px; border-radius: 20px; white-space: nowrap; }
    .sp-pill.approved  { background: rgba(34,197,94,0.12);  color: #4ade80; }
    .sp-pill.pending   { background: rgba(249,115,22,0.12); color: #fb923c; }
    .sp-pill.cancelled { background: rgba(239,68,68,0.12);  color: #f87171; }
    .sp-pill.rejected  { background: rgba(239,68,68,0.12);  color: #f87171; }
    .sp-pill.archived  { background: rgba(100,116,139,0.15); color: #94a3b8; }

    /* Buttons */
    .sp-reg-btn {
        background: rgba(249,115,22,0.15);
        border: 1px solid rgba(249,115,22,0.3);
        color: #f97316;
        font-size: 0.72rem; padding: 5px 14px; border-radius: 8px;
        font-family: 'DM Sans', sans-serif; cursor: pointer; font-weight: 600;
        white-space: nowrap; text-decoration: none; display: inline-block;
        transition: background 0.2s;
    }
    .sp-reg-btn:hover { background: rgba(249,115,22,0.28); color: #f97316; }
    .sp-approve-btn {
        background: rgba(34,197,94,0.15); border: 1px solid rgba(34,197,94,0.3); color: #4ade80;
        font-size: 0.72rem; padding: 5px 12px; border-radius: 8px;
        font-family: 'DM Sans', sans-serif; cursor: pointer; font-weight: 600;
    }
    .sp-reject-btn {
        background: rgba(239,68,68,0.12); border: 1px solid rgba(239,68,68,0.25); color: #f87171;
        font-size: 0.72rem; padding: 5px 12px; border-radius: 8px;
        font-family: 'DM Sans', sans-serif; cursor: pointer; font-weight: 600;
    }

    /* Chart */
    .sp-chart-filters { display: flex; gap: 8px; align-items: center; }
    .sp-chart-filters select {
        background: #0f172a; border: 1px solid rgba(255,255,255,0.1); color: #cbd5e1;
        font-size: 0.75rem; padding: 4px 8px; border-radius: 8px; font-family: 'DM Sans', sans-serif;
    }
    .sp-chart-filters .sp-filter-btn {
        background: #f97316; border: none; color: white; font-size: 0.75rem;
        padding: 5px 14px; border-radius: 8px; font-family: 'DM Sans', sans-serif;
        cursor: pointer; font-weight: 600;
    }
    .sp-chart-filters .sp-reset-btn {
        background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1); color: #94a3b8;
        font-size: 0.75rem; padding: 5px 12px; border-radius: 8px;
        font-family: 'DM Sans', sans-serif; cursor: pointer; text-decoration: none; display: inline-block;
    }

    /* Empty state */
    .sp-empty { padding: 28px; text-align: center; color: #475569; font-size: 0.82rem; }
    .sp-empty-icon { font-size: 1.6rem; display: block; margin-bottom: 8px; color: #334155; }

    @media (max-width: 768px) {
        .sp-stats, .sp-stats-admin { grid-template-columns: repeat(2, 1fr); }
        .sp-grid { grid-template-columns: 1fr; }
        .sp-card-full { grid-column: span 1; }
        .sp-hero { flex-direction: column; gap: 16px; align-items: flex-start; }
    }
</style>

<div class="sp-dash">

    {{-- Hero --}}
    <div class="sp-hero">
        <div>
            <div class="sp-hero-badge">{{ auth()->user()->isAdmin() ? 'Admin' : 'Player' }}</div>
            <div class="sp-hero-title">Welcome back, {{ auth()->user()->username }}</div>
            <div class="sp-hero-sub">
                @if($isAdmin)
                    {{ $pendingRegistrations }} pending registration{{ $pendingRegistrations != 1 ? 's' : '' }} need your review
                @else
                    @if(isset($upcomingNotifications) && $upcomingNotifications->count() > 0)
                        You have {{ $upcomingNotifications->count() }} upcoming event{{ $upcomingNotifications->count() != 1 ? 's' : '' }} coming up soon
                    @else
                        You're all caught up — no events in the next 7 days
                    @endif
                @endif
            </div>
        </div>
        @if(!$isAdmin)
            <a href="{{ route('registrations.create') }}" class="btn btn-warning fw-bold px-4">+ Register for Event</a>
        @endif
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($isAdmin)
    {{-- ===================== ADMIN ===================== --}}
    <div class="sp-stats sp-stats-admin">
        <div class="sp-stat blue">
            <div class="sp-stat-label">Total Events</div>
            <div class="sp-stat-num">{{ $totalEvents }}</div>
            <div class="sp-stat-sub">All time</div>
        </div>
        <div class="sp-stat green">
            <div class="sp-stat-label">Upcoming Events</div>
            <div class="sp-stat-num">{{ $upcomingEvents }}</div>
            <div class="sp-stat-sub">Active &amp; open</div>
        </div>
        <div class="sp-stat orange">
            <div class="sp-stat-label">Pending Registrations</div>
            <div class="sp-stat-num">{{ $pendingRegistrations }}</div>
            <div class="sp-stat-sub">Awaiting review</div>
        </div>
        <div class="sp-stat red">
            <div class="sp-stat-label">Total Users</div>
            <div class="sp-stat-num">{{ $totalUsers }}</div>
            <div class="sp-stat-sub">Registered accounts</div>
        </div>
    </div>

    <div class="sp-grid">
        <div class="sp-card">
            <div class="sp-card-head">
                <div class="sp-card-title">Upcoming Events</div>
                <div class="sp-card-badge">{{ $recentEvents->count() }} events</div>
            </div>
            <div class="sp-card-body">
                @forelse($recentEvents as $e)
                <div class="sp-row">
                    <div class="sp-row-info">
                        <div class="sp-row-name">{{ $e->event_name }}</div>
                        <div class="sp-row-sub">{{ $e->event_date->format('M d, Y') }} • {{ $e->location }}</div>
                    </div>
                    <span class="sp-pill approved">{{ $e->sport_type }}</span>
                </div>
                @empty
                <div class="sp-empty">
                    <i class="bi bi-calendar-x sp-empty-icon"></i>No upcoming events
                </div>
                @endforelse
            </div>
        </div>

        <div class="sp-card">
            <div class="sp-card-head">
                <div class="sp-card-title">Pending Registrations</div>
                <div class="sp-card-badge">{{ $latestRegistrations->where('status','pending')->count() }} pending</div>
            </div>
            <div class="sp-card-body">
                @forelse($latestRegistrations->where('status','pending') as $r)
                <div class="sp-row">
                    <div class="sp-row-info">
                        <div class="sp-row-name">{{ $r->participant_name }}</div>
                        <div class="sp-row-sub">{{ $r->event->event_name }}</div>
                    </div>
                    <div class="d-flex gap-1">
                        <form action="{{ route('registrations.approve', $r) }}" method="POST" class="d-inline">
                            @csrf @method('PATCH')
                            <button class="sp-approve-btn"><i class="bi bi-check-lg"></i></button>
                        </form>
                        <form action="{{ route('registrations.reject', $r) }}" method="POST" class="d-inline">
                            @csrf @method('PATCH')
                            <button class="sp-reject-btn"><i class="bi bi-x-lg"></i></button>
                        </form>
                    </div>
                </div>
                @empty
                <div class="sp-empty">
                    <i class="bi bi-inbox sp-empty-icon"></i>No pending registrations
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="sp-grid">
        <div class="sp-card sp-card-full">
            <div class="sp-card-head">
                <div class="sp-card-title">Registrations — {{ $chartTitle }}</div>
                <form method="GET" action="{{ route('dashboard') }}" class="sp-chart-filters">
                    <select name="year">
                        @foreach($availableYears as $yr)
                            <option value="{{ $yr }}" {{ $selectedYear == $yr ? 'selected' : '' }}>{{ $yr }}</option>
                        @endforeach
                    </select>
                    <select name="month">
                        <option value="" {{ $selectedMonth === '' ? 'selected' : '' }}>All Months</option>
                        <option value="1"  {{ $selectedMonth == '1'  ? 'selected' : '' }}>January</option>
                        <option value="2"  {{ $selectedMonth == '2'  ? 'selected' : '' }}>February</option>
                        <option value="3"  {{ $selectedMonth == '3'  ? 'selected' : '' }}>March</option>
                        <option value="4"  {{ $selectedMonth == '4'  ? 'selected' : '' }}>April</option>
                        <option value="5"  {{ $selectedMonth == '5'  ? 'selected' : '' }}>May</option>
                        <option value="6"  {{ $selectedMonth == '6'  ? 'selected' : '' }}>June</option>
                        <option value="7"  {{ $selectedMonth == '7'  ? 'selected' : '' }}>July</option>
                        <option value="8"  {{ $selectedMonth == '8'  ? 'selected' : '' }}>August</option>
                        <option value="9"  {{ $selectedMonth == '9'  ? 'selected' : '' }}>September</option>
                        <option value="10" {{ $selectedMonth == '10' ? 'selected' : '' }}>October</option>
                        <option value="11" {{ $selectedMonth == '11' ? 'selected' : '' }}>November</option>
                        <option value="12" {{ $selectedMonth == '12' ? 'selected' : '' }}>December</option>
                    </select>
                    <button type="submit" class="sp-filter-btn">Filter</button>
                    <a href="{{ route('dashboard') }}" class="sp-reset-btn">Reset</a>
                </form>
            </div>
            <div class="sp-card-body p-3">
                <canvas id="registrationsChart" height="80"></canvas>
            </div>
        </div>
    </div>

    @else
    {{-- ===================== USER ===================== --}}

    @if(isset($upcomingNotifications) && $upcomingNotifications->count() > 0)
        @foreach($upcomingNotifications as $n)
            <div class="sp-notif {{ $n->days_left <= 3 ? 'urgent' : 'soon' }} mb-3">
                <div class="sp-notif-icon">
                    @if($n->days_left <= 3)
                        <i class="bi bi-exclamation-triangle-fill"></i>
                    @else
                        <i class="bi bi-clock-fill"></i>
                    @endif
                </div>
                <div class="sp-notif-text">
                    <strong>{{ $n->event->event_name }}</strong> is
                    @if($n->days_left == 0)
                        <span class="sp-notif-badge-red">TODAY!</span>
                    @elseif($n->days_left == 1)
                        <span class="sp-notif-badge-red">TOMORROW!</span>
                    @elseif($n->days_left <= 3)
                        in <span class="sp-notif-badge-red">{{ $n->days_left }} days</span>
                    @else
                        in <span class="sp-notif-badge-orange">{{ $n->days_left }} days</span>
                    @endif
                    — {{ $n->event->event_date->format('M d, Y') }} @ {{ $n->event->location }}
                </div>
                <button class="sp-notif-close" onclick="this.parentElement.remove()">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
        @endforeach
    @endif

    <div class="sp-stats">
        <div class="sp-stat blue">
            <div class="sp-stat-label">Events Available</div>
            <div class="sp-stat-num">{{ $totalEvents }}</div>
            <div class="sp-stat-sub">Open for registration</div>
        </div>
        <div class="sp-stat green">
            <div class="sp-stat-label">My Approved</div>
            <div class="sp-stat-num">{{ $myApproved }}</div>
            <div class="sp-stat-sub">Confirmed events</div>
        </div>
        <div class="sp-stat orange">
            <div class="sp-stat-label">Pending</div>
            <div class="sp-stat-num">{{ $myPending }}</div>
            <div class="sp-stat-sub">Awaiting approval</div>
        </div>
    </div>

    <div class="sp-grid">
        <div class="sp-card">
            <div class="sp-card-head">
                <div class="sp-card-title">My Registrations</div>
                <div class="sp-card-badge">{{ $myRegistrations->count() }} total</div>
            </div>
            <div class="sp-card-body">
                @forelse($myRegistrations as $r)
                <div class="sp-row">
                    <div class="sp-row-info">
                        <div class="sp-row-name">{{ $r->event->event_name }}</div>
                        <div class="sp-row-sub">{{ $r->event->event_date->format('M d, Y') }}</div>
                    </div>
                    <span class="sp-pill {{ $r->status }}">{{ ucfirst($r->status) }}</span>
                </div>
                @empty
                <div class="sp-empty">
                    <i class="bi bi-inbox sp-empty-icon"></i>
                    No registrations yet. <a href="{{ route('registrations.create') }}" style="color:#f97316;">Register now</a>
                </div>
                @endforelse
            </div>
        </div>

        <div class="sp-card">
            <div class="sp-card-head">
                <div class="sp-card-title">Upcoming Events</div>
                <div class="sp-card-badge">{{ $recentEvents->count() }} events</div>
            </div>
            <div class="sp-card-body">
                @forelse($recentEvents as $e)
                <div class="sp-row">
                    <div class="sp-row-info">
                        <div class="sp-row-name">{{ $e->event_name }}</div>
                        <div class="sp-row-sub">{{ $e->event_date->format('M d, Y') }}</div>
                    </div>
                    <a href="{{ route('registrations.create') }}?event_id={{ $e->event_id }}" class="sp-reg-btn">Register</a>
                </div>
                @empty
                <div class="sp-empty">
                    <i class="bi bi-calendar-x sp-empty-icon"></i>No upcoming events
                </div>
                @endforelse
            </div>
        </div>
    </div>

    @endif

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    @if($isAdmin)
    const ctx = document.getElementById('registrationsChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($chartLabels) !!},
            datasets: [{
                label: 'Registrations',
                data: {!! json_encode($chartData) !!},
                backgroundColor: 'rgba(249,115,22,0.7)',
                borderColor: '#f97316',
                borderWidth: 1,
                borderRadius: 6,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: { labels: { color: '#94a3b8', font: { family: 'DM Sans' } } }
            },
            scales: {
                x: {
                    ticks: { color: '#64748b', font: { family: 'DM Sans', size: 11 } },
                    grid: { color: 'rgba(255,255,255,0.04)' }
                },
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1, precision: 0, color: '#64748b', font: { family: 'DM Sans', size: 11 } },
                    grid: { color: 'rgba(255,255,255,0.04)' }
                }
            }
        }
    });
    @endif
</script>
@endsection