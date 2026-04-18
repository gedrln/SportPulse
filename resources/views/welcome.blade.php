<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SportPulse - Sports Event Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: white;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        
        /* Navbar - Same width as dashboard */
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
            margin: 0 0.5rem;
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
        .btn-outline-custom {
            background: transparent;
            border: 1px solid #475569;
            color: #cbd5e1;
            padding: 0.4rem 1.2rem;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.2s;
        }
        .btn-outline-custom:hover {
            background: #f97316;
            border-color: #f97316;
            color: white;
        }
        
        /* Hero Section - Centered */
        .hero {
            min-height: 100vh;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);
            display: flex;
            align-items: center;
            text-align: center;
        }
        .hero .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        .hero-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(249,115,22,0.12);
            border: 1px solid rgba(249,115,22,0.25);
            border-radius: 100px;
            padding: 0.35rem 1.2rem;
            font-size: 0.75rem;
            font-weight: 600;
            color: #f97316;
            margin-bottom: 1.5rem;
        }
        .hero h1 {
            font-size: 3rem;
            font-weight: 800;
            color: white;
            margin-bottom: 1rem;
        }
        .hero h1 .accent {
            color: #f97316;
        }
        .hero p {
            font-size: 1rem;
            color: #94a3b8;
            max-width: 550px;
            margin: 0 auto 2rem;
        }
        .btn-hero-primary {
            background: #f97316;
            color: white;
            padding: 0.8rem 2rem;
            border-radius: 12px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-weight: 700;
            transition: transform 0.2s;
        }
        .btn-hero-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(249,115,22,0.3);
            color: white;
        }
        .btn-hero-secondary {
            background: transparent;
            border: 2px solid rgba(255,255,255,0.25);
            color: white;
            padding: 0.8rem 2rem;
            border-radius: 12px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-weight: 700;
            transition: all 0.2s;
        }
        .btn-hero-secondary:hover {
            border-color: #f97316;
            color: #f97316;
        }
        .hero-features {
            display: flex;
            gap: 2rem;
            justify-content: center;
            margin-top: 2rem;
        }
        .hero-features span {
            font-size: 0.8rem;
            color: #94a3b8;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .hero-features i {
            color: #f97316;
        }
        
        /* Features Section */
        .features-section {
            padding: 4rem 0;
            background: white;
        }
        .features-section .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        .section-badge {
            display: inline-block;
            background: #fef3c7;
            color: #d97706;
            font-size: 0.7rem;
            font-weight: 700;
            padding: 0.25rem 1rem;
            border-radius: 20px;
            margin-bottom: 1rem;
        }
        .section-title {
            font-size: 2rem;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 0.75rem;
        }
        .section-subtitle {
            color: #64748b;
            margin-bottom: 3rem;
        }
        .feature-card {
            background: white;
            border-radius: 20px;
            padding: 1.5rem;
            text-align: center;
            border: 1px solid #e2e8f0;
            transition: all 0.3s;
            height: 100%;
        }
        .feature-card:hover {
            transform: translateY(-5px);
            border-color: #f97316;
        }
        .feature-icon {
            width: 60px;
            height: 60px;
            background: #fff7ed;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
        }
        .feature-icon i {
            font-size: 1.5rem;
            color: #f97316;
        }
        
        /* How It Works Section */
        .howitworks-section {
            padding: 4rem 0;
            background: #f8fafc;
        }
        .howitworks-section .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        .role-card {
            background: white;
            border-radius: 20px;
            padding: 1.5rem;
            text-align: center;
            border: 1px solid #e2e8f0;
            height: 100%;
        }
        .role-icon {
            width: 60px;
            height: 60px;
            background: #f1f5f9;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
        }
        .role-icon i {
            font-size: 1.5rem;
            color: #f97316;
        }
        
        /* CTA Section */
        .cta-section {
            padding: 4rem 0;
            background: linear-gradient(135deg, #0f172a, #1e293b);
            text-align: center;
        }
        .cta-section .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        .cta-section h2 {
            font-size: 2rem;
            font-weight: 800;
            color: white;
            margin-bottom: 1rem;
        }
        .cta-section p {
            color: #94a3b8;
            margin-bottom: 2rem;
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
        
        /* Responsive */
        @media (max-width: 768px) {
            .navbar-custom .container, .hero .container, .features-section .container, 
            .howitworks-section .container, .cta-section .container, .footer .container {
                padding: 0 15px;
            }
            .hero h1 { font-size: 2rem; }
            .hero-features { flex-wrap: wrap; gap: 1rem; }
            .section-title { font-size: 1.5rem; }
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
                <li class="nav-item"><a class="nav-link active" href="#home">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="#features">Features</a></li>
                <!-- <li class="nav-item"><a class="nav-link" href="#howitworks">How It Works</a></li> -->
                <li class="nav-item"><a class="nav-link" href="/events">View Events</a></li>
                @auth
                    <li class="nav-item"><a class="nav-link" href="/dashboard">Dashboard</a></li>
                @endauth
            </ul>
            @auth
                <a href="/dashboard" class="btn-primary-custom">Dashboard</a>
            @else
                <div class="d-flex gap-2">
                    <a href="/login" class="btn-outline-custom">Login</a>
                    <a href="/register" class="btn-primary-custom">Sign Up</a>
                </div>
            @endauth
        </div>
    </div>
</nav>

<!-- Hero Section -->
<section class="hero" id="home">
    <div class="container">
        <div class="hero-pill">
            <i class="bi bi-lightning-charge-fill"></i> Plan Smarter. Play Better
        </div>
        <h1>Where  <span class="accent">Sports</span><br> Events Come Together</h1>
        <p>From sign-ups to scoreboards, manage it all in seconds</p>
        <div class="d-flex gap-3 justify-content-center flex-wrap">
            @auth
                <a href="/dashboard" class="btn-hero-primary"><i class="bi bi-speedometer2"></i> Go to Dashboard</a>
                <a href="/events" class="btn-hero-secondary"><i class="bi bi-calendar-event"></i> View Events</a>
            @else
                <a href="/register" class="btn-hero-primary"><i class="bi bi-person-plus"></i> Create Account</a>
                <a href="/events" class="btn-hero-secondary"><i class="bi bi-calendar-event"></i> Browse Events</a>
            @endauth
        </div>
        <div class="hero-features">
            <span><i class="bi bi-check-circle-fill"></i> Fast Registration</span>
            <span><i class="bi bi-check-circle-fill"></i> Fast Onboarding</span>
            <span><i class="bi bi-check-circle-fill"></i> Game-Ready Setup</span>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="features-section" id="features">
    <div class="container text-center">
        <div class="section-badge">WHAT WE OFFER</div>
        <h2 class="section-title">Everything in One System</h2>
        <p class="section-subtitle">Complete sports event management solution for all user types</p>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon"><i class="bi bi-calendar-plus"></i></div>
                    <h5>Build the Game Plan</h5>
                    <p class="text-muted small">Set up and manage your events with ease.</p>
                    <span class="badge bg-warning text-dark">Game Ready</span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon"><i class="bi bi-person-check"></i></div>
                    <h5>Join in Seconds</h5>
                    <p class="text-muted small">Join events with one click.</p>
                    <span class="badge bg-success text-white">Quick Access</span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon"><i class="bi bi-graph-up"></i></div>
                    <h5>Participant Tracking</h5>
                    <p class="text-muted small">Participant counts update automatically when registrations are approved.</p>
                    <span class="badge bg-primary text-white">Auto Sync</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- How It Works Section -->
<!-- <section class="howitworks-section" id="howitworks">
    <div class="container text-center">
        <div class="section-badge">HOW IT WORKS</div>
        <h2 class="section-title">Three Roles, One Platform</h2>
        <p class="section-subtitle">Every user type has exactly what they need</p>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="role-card">
                    <div class="role-icon"><i class="bi bi-eye"></i></div>
                    <h4>Guest</h4>
                    <p class="text-muted">Browse and view all sports events without creating an account.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="role-card">
                    <div class="role-icon"><i class="bi bi-person"></i></div>
                    <h4>Registered User</h4>
                    <p class="text-muted">Create an account, log in, and register for events you want to join.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="role-card">
                    <div class="role-icon"><i class="bi bi-shield-check"></i></div>
                    <h4>Administrator</h4>
                    <p class="text-muted">Manage all events (CRUD), approve registrations, and track participant counts.</p>
                </div>
            </div>
        </div>
    </div>
</section> -->

<!-- CTA Section -->
<section class="cta-section">
    <div class="container">
        <h2>Ready to Join?</h2>
        <p>Create an account to register for events, or browse as a guest right now.</p>
        @auth
            <a href="/dashboard" class="btn-hero-primary">Go to Dashboard</a>
        @else
            <div class="d-flex gap-3 justify-content-center flex-wrap">
                <a href="/register" class="btn-hero-primary">Create Free Account</a>
                <a href="/events" class="btn-hero-secondary">Browse as Guest</a>
            </div>
        @endauth
    </div>
</section>

<!-- Footer -->
<footer class="footer">
    <div class="container">
        <p><strong class="text-warning">SportPulse</strong> — Sports Event Management System © {{ date('Y') }} | <a href="/login">Login</a> | <a href="/register">Sign Up</a> | <a href="/events">Browse Events</a></p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>