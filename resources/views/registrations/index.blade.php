@extends('layouts.app')
@section('title', 'Registrations')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&family=Bebas+Neue&display=swap');

    .sp-reg { font-family: 'DM Sans', sans-serif; }

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

    /* Info Alert */
    .sp-alert-info {
        background: rgba(59,130,246,0.08);
        border: 1px solid rgba(59,130,246,0.2);
        border-left: 3px solid #3b82f6;
        border-radius: 12px;
        padding: 12px 18px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 0.82rem;
        color: #93c5fd;
    }
    .sp-alert-admin {
        background: rgba(249,115,22,0.08);
        border: 1px solid rgba(249,115,22,0.2);
        border-left: 3px solid #f97316;
        border-radius: 12px;
        padding: 12px 18px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 0.82rem;
        color: #fdba74;
    }

    /* Tabs */
    .sp-tabs {
        display: flex;
        gap: 4px;
        margin-bottom: 24px;
        background: #1e293b;
        border: 1px solid rgba(255,255,255,0.06);
        border-radius: 14px;
        padding: 6px;
        flex-wrap: wrap;
    }
    .sp-tab-btn {
        display: flex;
        align-items: center;
        gap: 7px;
        padding: 9px 18px;
        border-radius: 10px;
        font-size: 0.8rem;
        font-weight: 600;
        font-family: 'DM Sans', sans-serif;
        border: none;
        background: transparent;
        color: #64748b;
        cursor: pointer;
        transition: all 0.2s;
        white-space: nowrap;
    }
    .sp-tab-btn:hover { background: rgba(255,255,255,0.05); color: #94a3b8; }
    .sp-tab-btn.active {
        background: #0f172a;
        color: #f1f5f9;
        border: 1px solid rgba(255,255,255,0.08);
    }
    .sp-tab-btn.active.tab-pending  { color: #fbbf24; border-color: rgba(251,191,36,0.2); }
    .sp-tab-btn.active.tab-approved { color: #4ade80; border-color: rgba(74,222,128,0.2); }
    .sp-tab-btn.active.tab-cancelled { color: #f87171; border-color: rgba(248,113,113,0.2); }
    .sp-tab-btn.active.tab-rejected  { color: #f87171; border-color: rgba(248,113,113,0.2); }
    .sp-tab-btn.active.tab-archived  { color: #94a3b8; border-color: rgba(148,163,184,0.2); }

    .sp-tab-count {
        font-size: 0.65rem;
        font-weight: 700;
        padding: 2px 7px;
        border-radius: 20px;
        line-height: 1.4;
    }
    .tab-pending  .sp-tab-count { background: rgba(251,191,36,0.15); color: #fbbf24; }
    .tab-approved .sp-tab-count { background: rgba(74,222,128,0.12); color: #4ade80; }
    .tab-cancelled .sp-tab-count { background: rgba(248,113,113,0.12); color: #f87171; }
    .tab-rejected  .sp-tab-count { background: rgba(248,113,113,0.12); color: #f87171; }
    .tab-archived  .sp-tab-count { background: rgba(148,163,184,0.12); color: #94a3b8; }

    /* Tab Panes */
    .sp-tab-pane { display: none; }
    .sp-tab-pane.active { display: block; }

    /* Table */
    .sp-table-wrap {
        background: #1e293b;
        border: 1px solid rgba(255,255,255,0.06);
        border-radius: 14px;
        overflow: hidden;
    }
    .sp-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.82rem;
    }
    .sp-table thead tr {
        border-bottom: 1px solid rgba(255,255,255,0.06);
    }
    .sp-table thead th {
        padding: 13px 18px;
        font-size: 0.68rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: #475569;
        background: transparent;
        text-align: left;
        white-space: nowrap;
    }
    .sp-table tbody tr {
        border-bottom: 1px solid rgba(255,255,255,0.04);
        transition: background 0.15s;
    }
    .sp-table tbody tr:last-child { border-bottom: none; }
    .sp-table tbody tr:hover { background: rgba(255,255,255,0.02); }
    .sp-table td {
        padding: 14px 18px;
        color: #cbd5e1;
        vertical-align: middle;
    }

    /* ID badge */
    .sp-id-badge {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 1rem;
        color: #f97316;
        letter-spacing: 0.5px;
    }

    /* Event cell */
    .sp-event-cell-name { font-weight: 600; color: #f1f5f9; }
    .sp-event-cell-date { font-size: 0.72rem; color: #64748b; margin-top: 2px; }

    /* User badge */
    .sp-user-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.08);
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        color: #cbd5e1;
    }
    .sp-user-avatar {
        width: 20px; height: 20px;
        border-radius: 50%;
        background: rgba(249,115,22,0.2);
        display: flex; align-items: center; justify-content: center;
        font-size: 0.6rem;
        font-weight: 700;
        color: #f97316;
        text-transform: uppercase;
    }

    /* Status pills */
    .sp-pill {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 0.68rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 4px 10px;
        border-radius: 20px;
    }
    .sp-pill::before {
        content: '';
        width: 5px; height: 5px;
        border-radius: 50%;
        background: currentColor;
    }
    .sp-pill.pending   { background: rgba(251,191,36,0.12); color: #fbbf24; }
    .sp-pill.approved  { background: rgba(74,222,128,0.12); color: #4ade80; }
    .sp-pill.cancelled { background: rgba(248,113,113,0.12); color: #f87171; }
    .sp-pill.rejected  { background: rgba(248,113,113,0.12); color: #f87171; }
    .sp-pill.archived  { background: rgba(148,163,184,0.1); color: #94a3b8; }

    /* Action buttons */
    .sp-action-wrap { display: flex; gap: 6px; align-items: center; flex-wrap: wrap; }
    .sp-btn-approve {
        background: rgba(34,197,94,0.12);
        border: 1px solid rgba(34,197,94,0.3);
        color: #4ade80;
        font-size: 0.72rem; font-weight: 700;
        padding: 5px 12px; border-radius: 8px;
        font-family: 'DM Sans', sans-serif; cursor: pointer;
        transition: background 0.2s;
    }
    .sp-btn-approve:hover { background: rgba(34,197,94,0.22); }
    .sp-btn-reject {
        background: rgba(239,68,68,0.1);
        border: 1px solid rgba(239,68,68,0.25);
        color: #f87171;
        font-size: 0.72rem; font-weight: 700;
        padding: 5px 12px; border-radius: 8px;
        font-family: 'DM Sans', sans-serif; cursor: pointer;
        transition: background 0.2s;
    }
    .sp-btn-reject:hover { background: rgba(239,68,68,0.2); }
    .sp-btn-archive {
        background: rgba(100,116,139,0.12);
        border: 1px solid rgba(100,116,139,0.25);
        color: #94a3b8;
        font-size: 0.72rem; font-weight: 700;
        padding: 5px 12px; border-radius: 8px;
        font-family: 'DM Sans', sans-serif; cursor: pointer;
        transition: background 0.2s;
    }
    .sp-btn-archive:hover { background: rgba(100,116,139,0.22); }
    .sp-btn-cancel {
        background: rgba(239,68,68,0.08);
        border: 1px solid rgba(239,68,68,0.2);
        color: #f87171;
        font-size: 0.72rem; font-weight: 700;
        padding: 5px 12px; border-radius: 8px;
        font-family: 'DM Sans', sans-serif; cursor: pointer;
        transition: background 0.2s;
    }
    .sp-btn-cancel:hover { background: rgba(239,68,68,0.18); }

    /* Empty state */
    .sp-empty {
        padding: 48px 20px;
        text-align: center;
        color: #475569;
    }
    .sp-empty-icon { font-size: 2.5rem; display: block; margin-bottom: 12px; }
    .sp-empty-text { font-family: 'Bebas Neue', sans-serif; font-size: 1.2rem; letter-spacing: 1px; color: #64748b; }

    /* Register btn */
    .sp-register-btn {
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
    .sp-register-btn:hover { background: #ea580c; color: white; }

    @media (max-width: 768px) {
        .sp-table thead { display: none; }
        .sp-table tbody tr { display: block; padding: 12px; border-bottom: 1px solid rgba(255,255,255,0.06); }
        .sp-table td { display: block; padding: 4px 0; border: none; }
        .sp-page-header { flex-direction: column; align-items: flex-start; gap: 12px; }
    }
</style>

<div class="sp-reg">

    {{-- Page Header --}}
    <div class="sp-page-header">
        <div>
            <div class="sp-page-title">
                @if(auth()->user()->isAdmin()) All <span>Registrations</span>
                @else My <span>Registrations</span>
                @endif
            </div>
            <div class="sp-page-sub">
                @if(auth()->user()->isAdmin())
                    {{ $pending->count() + $approved->count() + $cancelled->count() + $archived->count() }} total registrations
                @else
                    {{ $pending->count() + $approved->count() + $cancelled->count() + $rejected->count() }} total registrations
                @endif
            </div>
        </div>
        @if(!auth()->user()->isAdmin())
            <a href="{{ route('registrations.create') }}" class="sp-register-btn">
                <i class="bi bi-plus-lg"></i> Register
            </a>
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

    {{-- Info Banner --}}
    @if(auth()->user()->isAdmin())
        <div class="sp-alert-admin">
            <i class="bi bi-shield-fill-check" style="font-size:1rem;flex-shrink:0"></i>
            <span>Admin mode — you can approve, reject, or archive any registration.</span>
        </div>
    @else
        <div class="sp-alert-info">
            <i class="bi bi-info-circle-fill" style="font-size:1rem;flex-shrink:0"></i>
            <span>Your registration will be reviewed by an admin before approval.</span>
        </div>
    @endif

    {{-- Tabs --}}
    <div class="sp-tabs" id="regTabs">
        <button class="sp-tab-btn tab-pending active" onclick="switchTab('pending', this)">
            <i class="bi bi-hourglass-split"></i> Pending
            @if($pending->count() > 0)
                <span class="sp-tab-count">{{ $pending->count() }}</span>
            @endif
        </button>
        <button class="sp-tab-btn tab-approved" onclick="switchTab('approved', this)">
            <i class="bi bi-check-circle"></i> Approved
            @if($approved->count() > 0)
                <span class="sp-tab-count">{{ $approved->count() }}</span>
            @endif
        </button>
        <button class="sp-tab-btn tab-cancelled" onclick="switchTab('cancelled', this)">
            <i class="bi bi-slash-circle"></i> Cancelled
            @if($cancelled->count() > 0)
                <span class="sp-tab-count">{{ $cancelled->count() }}</span>
            @endif
        </button>
        @if(!auth()->user()->isAdmin())
        <button class="sp-tab-btn tab-rejected" onclick="switchTab('rejected', this)">
            <i class="bi bi-x-circle"></i> Rejected
            @if($rejected->count() > 0)
                <span class="sp-tab-count">{{ $rejected->count() }}</span>
            @endif
        </button>
        @endif
        @if(auth()->user()->isAdmin())
        <button class="sp-tab-btn tab-archived" onclick="switchTab('archived', this)">
            <i class="bi bi-archive"></i> Archived
            @if($archived->count() > 0)
                <span class="sp-tab-count">{{ $archived->count() }}</span>
            @endif
        </button>
        @endif
    </div>

    {{-- PENDING TAB --}}
    <div class="sp-tab-pane active" id="tab-pending">
        <div class="sp-table-wrap">
            <table class="sp-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        @if(auth()->user()->isAdmin())<th>User</th>@endif
                        <th>Event</th>
                        <th>Participant</th>
                        <th>Contact</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pending as $r)
                    <tr>
                        <td><span class="sp-id-badge">#{{ $r->id }}</span></td>
                        @if(auth()->user()->isAdmin())
                        <td>
                            <div class="sp-user-badge">
                                <div class="sp-user-avatar">{{ substr($r->user->username, 0, 1) }}</div>
                                {{ $r->user->username }}
                            </div>
                        </td>
                        @endif
                        <td>
                            <div class="sp-event-cell-name">{{ $r->event->event_name }}</div>
                            <div class="sp-event-cell-date">{{ $r->event->event_date->format('M d, Y') }}</div>
                        </td>
                        <td>{{ $r->participant_name }}</td>
                        <td style="color:#64748b">{{ $r->contact_number }}</td>
                        <td style="color:#64748b">{{ $r->created_at->format('M d, Y') }}</td>
                        <td>
                            <div class="sp-action-wrap">
                                @if(auth()->user()->isAdmin())
                                    <form action="{{ route('registrations.approve', $r) }}" method="POST" class="d-inline">
                                        @csrf @method('PATCH')
                                        <button class="sp-btn-approve">✓ Approve</button>
                                    </form>
                                    <form action="{{ route('registrations.reject', $r) }}" method="POST" class="d-inline" onsubmit="return confirm('Reject this registration?')">
                                        @csrf @method('PATCH')
                                        <button class="sp-btn-reject">✗ Reject</button>
                                    </form>
                                @else
                                    <form action="{{ route('registrations.cancel', $r) }}" method="POST" class="d-inline" onsubmit="return confirm('Cancel your registration?')">
                                        @csrf @method('PATCH')
                                        <button class="sp-btn-cancel">Cancel</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="{{ auth()->user()->isAdmin() ? 7 : 6 }}">
                        <div class="sp-empty">
                            <span class="sp-empty-icon">⏳</span>
                            <div class="sp-empty-text">No Pending Registrations</div>
                        </div>
                    </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- APPROVED TAB --}}
    <div class="sp-tab-pane" id="tab-approved">
        <div class="sp-table-wrap">
            <table class="sp-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        @if(auth()->user()->isAdmin())<th>User</th>@endif
                        <th>Event</th>
                        <th>Participant</th>
                        <th>Contact</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($approved as $r)
                    <tr>
                        <td><span class="sp-id-badge">#{{ $r->id }}</span></td>
                        @if(auth()->user()->isAdmin())
                        <td>
                            <div class="sp-user-badge">
                                <div class="sp-user-avatar">{{ substr($r->user->username, 0, 1) }}</div>
                                {{ $r->user->username }}
                            </div>
                        </td>
                        @endif
                        <td>
                            <div class="sp-event-cell-name">{{ $r->event->event_name }}</div>
                            <div class="sp-event-cell-date">{{ $r->event->event_date->format('M d, Y') }}</div>
                        </td>
                        <td>{{ $r->participant_name }}</td>
                        <td style="color:#64748b">{{ $r->contact_number }}</td>
                        <td style="color:#64748b">{{ $r->created_at->format('M d, Y') }}</td>
                        <td>
                            <div class="sp-action-wrap">
                                @if(auth()->user()->isAdmin())
                                    <form action="{{ route('registrations.archive', $r) }}" method="POST" class="d-inline" onsubmit="return confirm('Archive this registration?')">
                                        @csrf @method('PATCH')
                                        <button class="sp-btn-archive">🗃 Archive</button>
                                    </form>
                                @else
                                    <span class="sp-pill approved">Approved</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="{{ auth()->user()->isAdmin() ? 7 : 6 }}">
                        <div class="sp-empty">
                            <span class="sp-empty-icon">✅</span>
                            <div class="sp-empty-text">No Approved Registrations</div>
                        </div>
                    </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- CANCELLED TAB --}}
    <div class="sp-tab-pane" id="tab-cancelled">
        <div class="sp-table-wrap">
            <table class="sp-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        @if(auth()->user()->isAdmin())<th>User</th>@endif
                        <th>Event</th>
                        <th>Participant</th>
                        <th>Contact</th>
                        <th>Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cancelled as $r)
                    <tr>
                        <td><span class="sp-id-badge">#{{ $r->id }}</span></td>
                        @if(auth()->user()->isAdmin())
                        <td>
                            <div class="sp-user-badge">
                                <div class="sp-user-avatar">{{ substr($r->user->username, 0, 1) }}</div>
                                {{ $r->user->username }}
                            </div>
                        </td>
                        @endif
                        <td>
                            <div class="sp-event-cell-name">{{ $r->event->event_name }}</div>
                            <div class="sp-event-cell-date">{{ $r->event->event_date->format('M d, Y') }}</div>
                        </td>
                        <td>{{ $r->participant_name }}</td>
                        <td style="color:#64748b">{{ $r->contact_number }}</td>
                        <td style="color:#64748b">{{ $r->created_at->format('M d, Y') }}</td>
                        <td><span class="sp-pill cancelled">Cancelled</span></td>
                    </tr>
                    @empty
                    <tr><td colspan="{{ auth()->user()->isAdmin() ? 7 : 6 }}">
                        <div class="sp-empty">
                            <span class="sp-empty-icon">🚫</span>
                            <div class="sp-empty-text">No Cancelled Registrations</div>
                        </div>
                    </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- REJECTED TAB (non-admin only) --}}
    @if(!auth()->user()->isAdmin())
    <div class="sp-tab-pane" id="tab-rejected">
        <div class="sp-table-wrap">
            <table class="sp-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Event</th>
                        <th>Participant</th>
                        <th>Contact</th>
                        <th>Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rejected as $r)
                    <tr>
                        <td><span class="sp-id-badge">#{{ $r->id }}</span></td>
                        <td>
                            <div class="sp-event-cell-name">{{ $r->event->event_name }}</div>
                            <div class="sp-event-cell-date">{{ $r->event->event_date->format('M d, Y') }}</div>
                        </td>
                        <td>{{ $r->participant_name }}</td>
                        <td style="color:#64748b">{{ $r->contact_number }}</td>
                        <td style="color:#64748b">{{ $r->created_at->format('M d, Y') }}</td>
                        <td><span class="sp-pill rejected">Rejected</span></td>
                    </tr>
                    @empty
                    <tr><td colspan="6">
                        <div class="sp-empty">
                            <span class="sp-empty-icon">📭</span>
                            <div class="sp-empty-text">No Rejected Registrations</div>
                        </div>
                    </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @endif

    {{-- ARCHIVED TAB (admin only) --}}
    @if(auth()->user()->isAdmin())
    <div class="sp-tab-pane" id="tab-archived">
        <div class="sp-table-wrap">
            <table class="sp-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Event</th>
                        <th>Participant</th>
                        <th>Contact</th>
                        <th>Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($archived as $r)
                    <tr>
                        <td><span class="sp-id-badge">#{{ $r->id }}</span></td>
                        <td>
                            <div class="sp-user-badge">
                                <div class="sp-user-avatar">{{ substr($r->user->username, 0, 1) }}</div>
                                {{ $r->user->username }}
                            </div>
                        </td>
                        <td>
                            <div class="sp-event-cell-name">{{ $r->event->event_name }}</div>
                            <div class="sp-event-cell-date">{{ $r->event->event_date->format('M d, Y') }}</div>
                        </td>
                        <td>{{ $r->participant_name }}</td>
                        <td style="color:#64748b">{{ $r->contact_number }}</td>
                        <td style="color:#64748b">{{ $r->created_at->format('M d, Y') }}</td>
                        <td>
                            @if($r->status == 'rejected')
                                <span class="sp-pill rejected">Rejected</span>
                            @else
                                <span class="sp-pill archived">Archived</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7">
                        <div class="sp-empty">
                            <span class="sp-empty-icon">🗃️</span>
                            <div class="sp-empty-text">No Archived Registrations</div>
                        </div>
                    </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @endif

</div>

<script>
function switchTab(name, btn) {
    document.querySelectorAll('.sp-tab-pane').forEach(p => p.classList.remove('active'));
    document.querySelectorAll('.sp-tab-btn').forEach(b => b.classList.remove('active'));
    document.getElementById('tab-' + name).classList.add('active');
    btn.classList.add('active');
}
</script>

@endsection