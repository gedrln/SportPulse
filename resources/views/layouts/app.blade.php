<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SportPulse - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            background: #f1f5f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        
        /* Navbar - Full Width with Centered Content */
        .navbar-custom {
            background: #0f172a;
            border-bottom: 3px solid #f97316;
            padding: 0.75rem 0;
            width: 100%;
        }
        .navbar-custom .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        .navbar-custom .nav-link {
            color: #cbd5e1 !important;
            font-weight: 500;
            transition: color 0.2s;
        }
        .navbar-custom .nav-link:hover {
            color: #f97316 !important;
        }
        .navbar-custom .nav-link.active {
            color: #f97316 !important;
        }
        .navbar-brand {
            font-weight: 800;
            font-size: 1.3rem;
        }
        
        /* Buttons */
        .btn-primary-custom {
            background: #f97316;
            border: none;
            padding: 0.4rem 1.2rem;
            border-radius: 8px;
            color: white;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: background 0.2s;
        }
        .btn-primary-custom:hover {
            background: #ea580c;
            color: white;
        }
        
        /* Main Content */
        .main-content {
            flex: 1;
            padding: 1.5rem 0;
        }
        .main-content .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        /* Cards */
        .card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            margin-bottom: 1.5rem;
        }
        .card-header {
            background: white;
            border-bottom: 1px solid #e2e8f0;
            padding: 1rem 1.5rem;
            font-weight: 700;
            border-radius: 16px 16px 0 0 !important;
        }
        
        /* Stats Cards */
        .stat-card {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            text-align: center;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            height: 100%;
        }
        .stat-number {
            font-size: 2rem;
            font-weight: 800;
            color: #f97316;
            margin-bottom: 0.5rem;
        }
        
        /* Footer - Same width as header */
        .footer {
            background: #0f172a;
            color: #94a3b8;
            padding: 1rem 0;
            text-align: center;
            margin-top: auto;
            width: 100%;
        }
        .footer .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        .footer p {
            font-size: 0.75rem;
            margin-bottom: 0;
        }
        .footer a {
            color: #f97316;
            text-decoration: none;
        }
        .footer a:hover {
            text-decoration: underline;
        }
        
        /* Table */
        .table th {
            background: #f8fafc;
            font-weight: 600;
        }
        
        /* Badges */
        .badge-pending {
            background: #fef3c7;
            color: #92400e;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.7rem;
        }
        .badge-approved {
            background: #dcfce7;
            color: #166534;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.7rem;
        }
        .badge-rejected {
            background: #fee2e2;
            color: #991b1b;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.7rem;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .navbar-custom .container, .main-content .container, .footer .container {
                padding: 0 15px;
            }
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
                            <a class="nav-link {{ request()->routeIs('events.create') ? 'active' : '' }}" href="/events/create">Add Event</a>
                        </li>
                    @endif
                @endauth
            </ul>
            
            @auth
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