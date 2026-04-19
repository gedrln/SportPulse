<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SportPulse - Sports Event Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&family=Bebas+Neue&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: #0f172a;
            color: #f1f5f9;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* ── Navbar ── */
        .navbar-custom {
            background: #0f172a;
            border-bottom: 3px solid #f97316;
            padding: 0.75rem 0;
            position: sticky; top: 0; z-index: 100;
        }
        .navbar-custom .container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }
        .navbar-custom .nav-link { color: #94a3b8 !important; font-weight: 500; font-size: 0.9rem; transition: color 0.2s; }
        .navbar-custom .nav-link:hover, .navbar-custom .nav-link.active { color: #f97316 !important; }
        .navbar-brand { font-family: 'Bebas Neue', sans-serif; font-size: 1.5rem; letter-spacing: 1px; color: white !important; display: flex; align-items: center; gap: 8px; }
        .nav-btn-primary { background: #f97316; border: none; color: white; padding: 8px 20px; border-radius: 10px; font-weight: 600; font-size: 0.85rem; text-decoration: none; display: inline-block; transition: background 0.2s; font-family: 'DM Sans', sans-serif; }
        .nav-btn-primary:hover { background: #ea580c; color: white; }
        .nav-btn-outline { background: transparent; border: 1px solid rgba(255,255,255,0.2); color: #cbd5e1; padding: 8px 18px; border-radius: 10px; font-weight: 500; font-size: 0.85rem; text-decoration: none; display: inline-block; transition: all 0.2s; }
        .nav-btn-outline:hover { border-color: #eab308; color: #eab308; }

        /* ── Hero ── */
        .hero {
            min-height: calc(100vh - 59px);
            background: #0f172a;
            display: flex; align-items: center; text-align: center;
            position: relative; overflow: hidden;
        }
        .hero::before {
            content: ''; position: absolute; top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            width: 700px; height: 700px; border-radius: 50%;
            border: 1px solid rgba(249,115,22,0.05); pointer-events: none;
        }
        .hero::after {
            content: ''; position: absolute; top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            width: 500px; height: 500px; border-radius: 50%;
            border: 1px solid rgba(234,179,8,0.06); pointer-events: none;
        }
        .hero-ring-sm {
            position: absolute; top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            width: 320px; height: 320px; border-radius: 50%;
            border: 1px solid rgba(249,115,22,0.08); pointer-events: none;
        }
        .hero-glow {
            position: absolute; top: 28%; left: 50%;
            transform: translate(-50%, -50%);
            width: 560px; height: 560px;
            background: radial-gradient(circle, rgba(249,115,22,0.06) 0%, rgba(234,179,8,0.03) 45%, transparent 70%);
            pointer-events: none;
        }
        .hero .container { max-width: 820px; margin: 0 auto; padding: 0 20px; position: relative; z-index: 1; }

        .hero-pill {
            display: inline-flex; align-items: center; gap: 8px;
            background: rgba(249,115,22,0.1);
            border: 1px solid rgba(249,115,22,0.25);
            border-radius: 100px; padding: 6px 18px;
            font-size: 0.75rem; font-weight: 600; color: #f97316;
            margin-bottom: 28px; letter-spacing: 0.5px;
        }
        .hero-title {
            font-family: 'Bebas Neue', sans-serif;
            font-size: clamp(3rem, 8vw, 5.5rem);
            line-height: 1; letter-spacing: 2px;
            color: #f1f5f9; margin-bottom: 20px;
        }
        .c-orange { color: #f97316; }
        .c-yellow { color: #eab308; }
        .hero-sub {
            font-size: 1rem; color: #64748b;
            max-width: 480px; margin: 0 auto 36px; line-height: 1.6;
        }
        .hero-btns { display: flex; gap: 14px; justify-content: center; flex-wrap: wrap; margin-bottom: 40px; }
        .btn-hero-primary {
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
            color: white; padding: 14px 32px; border-radius: 12px;
            text-decoration: none; display: inline-flex; align-items: center; gap: 9px;
            font-weight: 700; font-size: 0.95rem;
            transition: transform 0.2s, box-shadow 0.2s; border: none;
        }
        .btn-hero-primary:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(249,115,22,0.3); color: white; }
        .btn-hero-secondary {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.15);
            color: #cbd5e1; padding: 14px 28px; border-radius: 12px;
            text-decoration: none; display: inline-flex; align-items: center; gap: 9px;
            font-weight: 600; font-size: 0.95rem; transition: all 0.2s;
        }
        .btn-hero-secondary:hover { border-color: #eab308; color: #eab308; transform: translateY(-2px); }
        .hero-checks { display: flex; gap: 28px; justify-content: center; flex-wrap: wrap; }
        .hero-check { font-size: 0.8rem; color: #64748b; display: flex; align-items: center; gap: 7px; }
        .hero-check i { color: #eab308; font-size: 0.88rem; }

        /* ── Stats Bar ── */
        .stats-bar {
            background: #1e293b;
            border-top: 1px solid rgba(255,255,255,0.05);
            border-bottom: 1px solid rgba(255,255,255,0.05);
            padding: 28px 0;
        }
        .stats-bar .container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }
        .stats-grid { display: grid; grid-template-columns: repeat(3, 1fr); }
        .stat-item { text-align: center; padding: 0 20px; border-right: 1px solid rgba(255,255,255,0.06); }
        .stat-item:last-child { border-right: none; }
        .stat-num { font-family: 'Bebas Neue', sans-serif; font-size: 2.8rem; line-height: 1; }
        .stat-label { font-size: 0.75rem; color: #64748b; margin-top: 4px; text-transform: uppercase; letter-spacing: 0.8px; font-weight: 600; }

        /* ── Features ── */
        .features-section { padding: 80px 0; background: #0f172a; }
        .features-section .container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }
        .section-eyebrow {
            font-size: 0.7rem; font-weight: 700; text-transform: uppercase;
            letter-spacing: 1.5px; color: #eab308; margin-bottom: 14px;
            display: flex; align-items: center; gap: 10px; justify-content: center;
        }
        .section-eyebrow::before, .section-eyebrow::after { content: ''; width: 40px; height: 1px; background: rgba(234,179,8,0.3); }
        .section-title { font-family: 'Bebas Neue', sans-serif; font-size: clamp(2rem, 5vw, 3rem); letter-spacing: 2px; color: #f1f5f9; margin-bottom: 14px; line-height: 1; }
        .section-sub { color: #64748b; font-size: 0.9rem; max-width: 480px; margin: 0 auto 56px; }

        .features-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
        .feature-card {
            background: #1e293b;
            border: 1px solid rgba(255,255,255,0.06);
            border-radius: 16px; padding: 32px 24px; text-align: center;
            transition: border-color 0.2s, transform 0.2s;
            position: relative; overflow: hidden;
        }
        .feature-card::after {
            content: ''; position: absolute; bottom: 0; left: 0; right: 0;
            height: 3px; opacity: 0; transition: opacity 0.2s;
        }
        .feature-card.f-orange::after { background: linear-gradient(90deg, #f97316, #fb923c); }
        .feature-card.f-yellow::after { background: linear-gradient(90deg, #ca8a04, #eab308); }
        .feature-card.f-blue::after   { background: linear-gradient(90deg, #2563eb, #60a5fa); }
        .feature-card:hover { transform: translateY(-4px); }
        .feature-card.f-orange:hover { border-color: rgba(249,115,22,0.3); }
        .feature-card.f-yellow:hover { border-color: rgba(234,179,8,0.3); }
        .feature-card.f-blue:hover   { border-color: rgba(96,165,250,0.3); }
        .feature-card:hover::after { opacity: 1; }

        /* Icon wrap — Bootstrap Icons only, no emojis */
        .feature-icon-wrap {
            width: 64px; height: 64px; border-radius: 18px;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 20px; font-size: 1.7rem;
        }
        .icon-orange { background: rgba(249,115,22,0.12); border: 1px solid rgba(249,115,22,0.25); color: #f97316; }
        .icon-yellow { background: rgba(234,179,8,0.1);  border: 1px solid rgba(234,179,8,0.25); color: #eab308; }
        .icon-blue   { background: rgba(59,130,246,0.1); border: 1px solid rgba(59,130,246,0.2); color: #60a5fa; }

        .feature-name { font-family: 'Bebas Neue', sans-serif; font-size: 1.3rem; letter-spacing: 1px; color: #f1f5f9; margin-bottom: 10px; }
        .feature-desc { font-size: 0.82rem; color: #64748b; line-height: 1.6; margin-bottom: 20px; }
        .feature-tag {
            display: inline-flex; align-items: center; gap: 5px;
            font-size: 0.65rem; font-weight: 700; text-transform: uppercase;
            letter-spacing: 0.8px; padding: 5px 14px; border-radius: 20px;
        }
        .tag-orange { background: rgba(249,115,22,0.12); color: #f97316; border: 1px solid rgba(249,115,22,0.2); }
        .tag-yellow { background: rgba(234,179,8,0.1);  color: #ca8a04; border: 1px solid rgba(234,179,8,0.25); }
        .tag-blue   { background: rgba(59,130,246,0.1); color: #60a5fa; border: 1px solid rgba(59,130,246,0.2); }

        /* ── CTA ── */
        .cta-section {
            padding: 80px 0; background: #1e293b;
            text-align: center; position: relative; overflow: hidden;
        }
        .cta-section::before {
            content: ''; position: absolute; top: 50%; left: 50%;
            transform: translate(-50%,-50%);
            width: 700px; height: 350px;
            background: radial-gradient(ellipse, rgba(249,115,22,0.05) 0%, rgba(234,179,8,0.03) 45%, transparent 70%);
            pointer-events: none;
        }
        .cta-section .container { max-width: 700px; margin: 0 auto; padding: 0 20px; position: relative; z-index: 1; }
        .cta-badge {
            display: inline-flex; align-items: center; gap: 7px;
            background: rgba(234,179,8,0.08); border: 1px solid rgba(234,179,8,0.2);
            color: #f97316; font-size: 0.72rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: 0.8px;
            padding: 5px 16px; border-radius: 20px; margin-bottom: 20px;
        }
        .cta-title { font-family: 'Bebas Neue', sans-serif; font-size: clamp(2.2rem, 5vw, 3.5rem); letter-spacing: 2px; color: #f1f5f9; margin-bottom: 16px; line-height: 1; }
        .cta-sub { color: #64748b; font-size: 0.9rem; margin-bottom: 36px; line-height: 1.6; }

        /* ── Footer ── */
        .footer { background: #0f172a; border-top: 1px solid rgba(255,255,255,0.05); padding: 20px 0; text-align: center; }
        .footer .container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }
        .footer p { font-size: 0.75rem; color: #475569; margin: 0; }
        .footer a { color: #f97316; text-decoration: none; transition: color 0.2s; }
        .footer a:hover { color: #eab308; }

        @media (max-width: 768px) {
            .stats-grid { grid-template-columns: 1fr 1fr; }
            .stat-item:nth-child(2) { border-right: none; }
            .stat-item:nth-child(3) { border-right: none; border-top: 1px solid rgba(255,255,255,0.06); padding-top: 20px; grid-column: span 2; }
            .features-grid { grid-template-columns: 1fr; }
            .hero-title { font-size: 3rem; }
            .hero-checks { gap: 16px; }
        }
    </style>
</head>
<body>

{{-- Navbar --}}
<nav class="navbar-custom navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="/">
            <i class="bi bi-lightning-charge-fill" style="color:#f97316"></i>SportPulse
        </a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
            <span class="navbar-toggler-icon" style="filter:invert(1)"></span>
        </button>
        <div class="collapse navbar-collapse" id="nav">
            <ul class="navbar-nav mx-auto gap-1">
                <li class="nav-item"><a class="nav-link active" href="#home">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="#features">Features</a></li>
                <li class="nav-item"><a class="nav-link" href="/events">View Events</a></li>
                @auth
                    <li class="nav-item"><a class="nav-link" href="/dashboard">Dashboard</a></li>
                @endauth
            </ul>
            @auth
                <a href="/dashboard" class="nav-btn-primary">Dashboard</a>
            @else
                <div class="d-flex gap-2">
                    <a href="/login" class="nav-btn-outline">Login</a>
                    <a href="/register" class="nav-btn-primary">Sign Up</a>
                </div>
            @endauth
        </div>
    </div>
</nav>

{{-- Hero --}}
<section class="hero" id="home">
    <div class="hero-glow"></div>
    <div class="hero-ring-sm"></div>
    <div class="container">
        <div class="hero-pill">
            <i class="bi bi-lightning-charge-fill"></i> Plan Smarter. Play Better
        </div>
        <h1 class="hero-title">
            Where <span class="c-orange">Sports</span><br>
            Events <span class="c-yellow">Come Together</span>
        </h1>
        <p class="hero-sub">From sign-ups to scoreboards, manage it all in seconds.</p>
        <div class="hero-btns">
            @auth
                <a href="/dashboard" class="btn-hero-primary">
                    <i class="bi bi-speedometer2"></i> Go to Dashboard
                </a>
                <a href="/events" class="btn-hero-secondary">
                    <i class="bi bi-calendar-event"></i> View Events
                </a>
            @else
                <a href="/register" class="btn-hero-primary">
                    <i class="bi bi-person-plus-fill"></i> Create Account
                </a>
                <a href="/events" class="btn-hero-secondary">
                    <i class="bi bi-calendar-event"></i> Browse Events
                </a>
            @endauth
        </div>
        <div class="hero-checks">
            <span class="hero-check"><i class="bi bi-check-circle-fill"></i> Fast Registration</span>
            <span class="hero-check"><i class="bi bi-check-circle-fill"></i> Fast Onboarding</span>
            <span class="hero-check"><i class="bi bi-check-circle-fill"></i> Game-Ready Setup</span>
        </div>
    </div>
</section>

{{-- Stats Bar --}}
<div class="stats-bar">
    <div class="container">
        <div class="stats-grid">
            <div class="stat-item">
                <div class="stat-num c-orange">8+</div>
                <div class="stat-label">Sport Categories</div>
            </div>
            <div class="stat-item">
                <div class="stat-num c-yellow">100%</div>
                <div class="stat-label">Online Management</div>
            </div>
            <div class="stat-item">
                <div class="stat-num" style="color:#f1f5f9">3</div>
                <div class="stat-label">User Roles</div>
            </div>
        </div>
    </div>
</div>

{{-- Features --}}
<section class="features-section" id="features">
    <div class="container text-center">
        <div class="section-eyebrow">What We Offer</div>
        <h2 class="section-title">
            Everything in <span class="c-orange">One</span> <span class="c-yellow">System</span>
        </h2>
        <p class="section-sub">Complete sports event management solution built for every type of user</p>

        <div class="features-grid">

            {{-- Card 1 --}}
            <div class="feature-card f-orange">
                <div class="feature-icon-wrap icon-orange">
                    <i class="bi bi-calendar-plus-fill"></i>
                </div>
                <div class="feature-name">Build the Game Plan</div>
                <p class="feature-desc">Create and manage sports events with full control over dates, locations, capacity, and sport types.</p>
                <span class="feature-tag tag-orange">
                    <i class="bi bi-controller" style="font-size:9px"></i> Game Ready
                </span>
            </div>

            {{-- Card 2 --}}
            <div class="feature-card f-yellow">
                <div class="feature-icon-wrap icon-yellow">
                    <i class="bi bi-person-check-fill"></i>
                </div>
                <div class="feature-name">Join in Seconds</div>
                <p class="feature-desc">Register for any event with a single click. Your spot is secured the moment admin approves.</p>
                <span class="feature-tag tag-yellow">
                    <i class="bi bi-lightning-fill" style="font-size:9px"></i> Quick Access
                </span>
            </div>

            {{-- Card 3 --}}
            <div class="feature-card f-blue">
                <div class="feature-icon-wrap icon-blue">
                    <i class="bi bi-graph-up-arrow"></i>
                </div>
                <div class="feature-name">Participant Tracking</div>
                <p class="feature-desc">Participant counts update automatically when registrations are approved, keeping slots always accurate.</p>
                <span class="feature-tag tag-blue">
                    <i class="bi bi-arrow-repeat" style="font-size:9px"></i> Auto Sync
                </span>
            </div>

        </div>
    </div>
</section>

{{-- CTA --}}
<section class="cta-section">
    <div class="container">
        <div class="cta-badge">
            <i class="bi bi-trophy-fill"></i> Get Started Today
        </div>
        <h2 class="cta-title">
            Ready to <span class="c-orange">Join</span> <span class="c-yellow">the Game?</span>
        </h2>
        <p class="cta-sub">Create an account to register for events, or browse as a guest right now. No commitment required.</p>
        @auth
            <a href="/dashboard" class="btn-hero-primary">
                <i class="bi bi-speedometer2"></i> Go to Dashboard
            </a>
        @else
            <div class="d-flex gap-3 justify-content: center; flex-wrap: wrap; justify-content: center;">
                <div class="d-flex gap-3 justify-content-center flex-wrap">
                    <a href="/register" class="btn-hero-primary">
                        <i class="bi bi-person-plus-fill"></i> Create Free Account
                    </a>
                    <a href="/events" class="btn-hero-secondary">
                        <i class="bi bi-binoculars-fill"></i> Browse as Guest
                    </a>
                </div>
            </div>
        @endauth
    </div>
</section>

{{-- Footer --}}
<footer class="footer">
    <div class="container">
        <p>
            <strong style="color:#f97316; font-family:'Bebas Neue',sans-serif; letter-spacing:1px; font-size:0.9rem;">SportPulse</strong>
            <span style="color:#334155"> — </span>
            Sports Event Management System © {{ date('Y') }}
            <span style="color:#334155"> | </span>
            <a href="/login">Login</a>
            <span style="color:#334155"> | </span>
            <a href="/register">Sign Up</a>
            <span style="color:#334155"> | </span>
            <a href="/events">Browse Events</a>
        </p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>