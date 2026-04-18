<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SportPulse - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', sans-serif;
        }
        .auth-card {
            max-width: 450px;
            margin: 3rem auto;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
            overflow: hidden;
        }
        .auth-header {
            background: #0f172a;
            padding: 1.5rem;
            text-align: center;
            border-bottom: 3px solid #f97316;
        }
        .auth-header h3 {
            color: white;
            font-weight: 800;
            margin-bottom: 0;
        }
        .auth-body {
            padding: 2rem;
        }
        .btn-auth {
            background: #f97316;
            border: none;
            width: 100%;
            padding: 0.75rem;
            border-radius: 10px;
            color: white;
            font-weight: 700;
            transition: background 0.2s;
        }
        .btn-auth:hover {
            background: #ea580c;
            color: white;
        }
        .back-link {
            text-align: center;
            margin-top: 1rem;
        }
        .back-link a {
            color: #f97316;
            text-decoration: none;
        }
        .back-link a:hover {
            text-decoration: underline;
        }
        .form-control:focus {
            border-color: #f97316;
            box-shadow: 0 0 0 0.2rem rgba(249,115,22,0.25);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="auth-card">
            <div class="auth-header">
                <i class="bi bi-lightning-charge-fill text-warning fs-2"></i>
                <h3>SportPulse</h3>
                <p class="text-white-50 small mb-0">Sports Event Management System</p>
            </div>
            <div class="auth-body">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $e)
                                <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                @yield('content')
            </div>
        </div>
        <div class="back-link">
            <a href="/"><i class="bi bi-arrow-left me-1"></i>Back to Home</a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>