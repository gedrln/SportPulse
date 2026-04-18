<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SportPulse - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            background: #0f172a;  /* was #f1f5f9 */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .main-content {
            flex: 1;
            padding: 1.5rem 0;
            background: #0f172a;  /* add this line */
        }

        /* Navbar */
        .navbar-custom {
            background: #0f172a;
            border-bottom: 3px solid #f97316;
            padding: 0.75rem 0;
            width: 100%;
        }
        .navbar-custom .container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }
        .navbar-custom .nav-link { color: #cbd5e1 !important; font-weight: 500; transition: color 0.2s; }
        .navbar-custom .nav-link:hover { color: #f97316 !important; }
        .navbar-custom .nav-link.active { color: #f97316 !important; }
        .navbar-brand { font-weight: 800; font-size: 1.3rem; }

        /* Buttons */
        .btn-primary-custom {
            background: #f97316; border: none; padding: 0.4rem 1.2rem;
            border-radius: 8px; color: white; font-weight: 600;
            text-decoration: none; display: inline-block; transition: background 0.2s;
        }
        .btn-primary-custom:hover { background: #ea580c; color: white; }

        /* Main Content */
        .main-content { flex: 1; padding: 1.5rem 0; }
        .main-content .container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }

        /* Cards */
        .card { border: none; border-radius: 16px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-bottom: 1.5rem; }
        .card-header {
            background: white; border-bottom: 1px solid #e2e8f0;
            padding: 1rem 1.5rem; font-weight: 700; border-radius: 16px 16px 0 0 !important;
        }

        /* Stats */
        .stat-card {
            background: white; border-radius: 16px; padding: 1.5rem;
            text-align: center; box-shadow: 0 1px 3px rgba(0,0,0,0.1); height: 100%;
        }
        .stat-number { font-size: 2rem; font-weight: 800; color: #f97316; margin-bottom: 0.5rem; }

        /* Footer */
        .footer { background: #0f172a; color: #94a3b8; padding: 1rem 0; text-align: center; margin-top: auto; width: 100%; }
        .footer .container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }
        .footer p { font-size: 0.75rem; margin-bottom: 0; }
        .footer a { color: #f97316; text-decoration: none; }
        .footer a:hover { text-decoration: underline; }

        /* Table */
        .table th { background: #f8fafc; font-weight: 600; }

        /* Badges */
        .badge-pending { background: #fef3c7; color: #92400e; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.7rem; }
        .badge-approved { background: #dcfce7; color: #166534; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.7rem; }
        .badge-rejected { background: #fee2e2; color: #991b1b; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.7rem; }

        /* Notification Bell */
        .notif-bell { position: relative; cursor: pointer; }
        .notif-bell .bi-bell-fill { font-size: 1.2rem; color: #cbd5e1; transition: color 0.2s; }
        .notif-bell:hover .bi-bell-fill { color: #f97316; }
        .notif-badge {
            position: absolute; top: -5px; right: -6px;
            background: #f97316; color: white;
            font-size: 0.6rem; font-weight: 700;
            border-radius: 50%; width: 16px; height: 16px;
            display: flex; align-items: center; justify-content: center; line-height: 1;
        }
        .notif-dropdown {
            width: 320px; padding: 0; border-radius: 12px;
            overflow: hidden; box-shadow: 0 8px 24px rgba(0,0,0,0.15); border: none;
        }
        .notif-dropdown .notif-header {
            background: #0f172a; color: white;
            padding: 0.75rem 1rem; font-weight: 700; font-size: 0.85rem;
        }
        .notif-item {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #f1f5f9;
            font-size: 0.82rem;
        }
        .notif-item:last-child { border-bottom: none; }
        .notif-item.urgent { border-left: 3px solid #ef4444; background: #fff5f5; }
        .notif-item.soon { border-left: 3px solid #f97316; background: #fff7ed; }
        .notif-empty { padding: 1rem; text-align: center; color: #94a3b8; font-size: 0.82rem; }

        @media (max-width: 768px) {
            .navbar-custom .container, .main-content .container, .footer .container { padding: 0 15px; }
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar-custom navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand fw-bold text-white" href="/">
            <i class="bi bi-lightning-charge-fill text-warning me-2"></i>SportPulse
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
            <span class="navbar-toggler-icon bg-white rounded"></span>
        </button>
        <div class="collapse navbar-collapse" id="nav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('events.*') ? 'active' : '' }}" href="/events">Events</a>
                </li>
                @auth
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="/dashboard">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('registrations.*') ? 'active' : '' }}" href="/registrations">Registrations</a>
                    </li>
                    @if(auth()->user()->isAdmin())
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('events.create') ? 'active' : '' }}" href="{{ route('events.create') }}">Add Event</a>
                        </li>
                    @endif
                @endauth
            </ul>

            @auth
                <div class="d-flex align-items-center gap-3">

                    {{-- Bell Notification (non-admin only) --}}
                    @if(!auth()->user()->isAdmin())
                        @php
                            $navNotifs = \App\Models\EventRegistration::with('event')
                                ->where('user_name', auth()->user()->username)
                                ->where('status', 'approved')
                                ->whereHas('event', function($q) {
                                    $q->whereBetween('event_date', [
                                        now()->startOfDay(),
                                        now()->addDays(7)->endOfDay()
                                    ]);
                                })
                                ->get()
                                ->map(function($r) {
                                    $r->days_left = now()->startOfDay()->diffInDays($r->event->event_date->startOfDay());
                                    return $r;
                                });
                        @endphp
                        <div class="dropdown notif-bell">
                            <button class="btn p-0 border-0 bg-transparent" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-bell-fill"></i>
                                @if($navNotifs->count() > 0)
                                    <span class="notif-badge">{{ $navNotifs->count() }}</span>
                                @endif
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end notif-dropdown">
                                <div class="notif-header">
                                    <i class="bi bi-bell-fill me-2"></i>Upcoming Events
                                </div>
                                @forelse($navNotifs as $n)
                                    <li class="notif-item {{ $n->days_left <= 3 ? 'urgent' : 'soon' }}">
                                        <div class="fw-bold">{{ $n->event->event_name }}</div>
                                        <div class="text-muted">{{ $n->event->event_date->format('M d, Y') }} • {{ $n->event->location }}</div>
                                        <div class="mt-1">
                                            @if($n->days_left == 0)
                                                <span class="badge bg-danger">Today!</span>
                                            @elseif($n->days_left == 1)
                                                <span class="badge bg-danger">Tomorrow!</span>
                                            @elseif($n->days_left <= 3)
                                                <span class="badge bg-danger">In {{ $n->days_left }} days</span>
                                            @else
                                                <span class="badge bg-warning text-dark">In {{ $n->days_left }} days</span>
                                            @endif
                                        </div>
                                    </li>
                                @empty
                                    <li class="notif-empty">
                                        <i class="bi bi-check-circle text-success d-block mb-1" style="font-size:1.5rem"></i>
                                        No upcoming events in 7 days
                                    </li>
                                @endforelse
                            </ul>
                        </div>
                    @endif

                    {{-- User Dropdown --}}
                    <div class="dropdown">
                        <button class="btn btn-outline-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle"></i> {{ auth()->user()->username }}
                            @if(auth()->user()->isAdmin())
                                <span class="badge bg-warning text-dark ms-1">Admin</span>
                            @endif
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="/dashboard">Dashboard</a></li>
                            <li><a class="dropdown-item" href="/registrations">Registrations</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="/logout">
                                    @csrf
                                    <button class="dropdown-item text-danger" type="submit">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>

                </div>
            @else
                <div class="d-flex gap-2">
                    <a href="/login" class="btn btn-outline-light">Login</a>
                    <a href="/register" class="btn-primary-custom">Sign Up</a>
                </div>
            @endauth
        </div>
    </div>
</nav>

<!-- Main Content -->
<main class="main-content">
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>
</main>

<!-- Footer -->
<footer class="footer">
    <div class="container">
        <p><strong class="text-warning">SportPulse</strong> — Sports Event Management System © {{ date('Y') }}</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>