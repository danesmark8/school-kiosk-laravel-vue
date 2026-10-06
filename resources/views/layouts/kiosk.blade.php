<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'School Kiosk') }} - Self-Service Portal</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --kiosk-primary: #1e3a8a;
            --kiosk-secondary: #0284c7;
            --kiosk-accent: #f59e0b;
            --kiosk-bg: #f8fafc;
            --kiosk-card: #ffffff;
            --kiosk-text: #0f172a;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--kiosk-bg);
            color: var(--kiosk-text);
            user-select: none;
            -webkit-user-select: none;
            overflow-x: hidden;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        h1, h2, h3, h4, h5, .brand-font {
            font-family: 'Outfit', sans-serif;
        }

        /* Kiosk Header */
        .kiosk-header {
            background: linear-gradient(135deg, #1e3a8a 0%, #0369a1 100%);
            color: #ffffff;
            padding: 1rem 1.5rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        /* Touch-friendly buttons */
        .btn-touch {
            min-height: 3.5rem;
            font-size: 1.15rem;
            font-weight: 600;
            border-radius: 1rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.6rem;
            padding: 0.75rem 1.75rem;
            transition: transform 0.15s ease, box-shadow 0.15s ease;
        }
        .btn-touch:active {
            transform: scale(0.97);
        }

        /* Large touch navigation card */
        .kiosk-nav-card {
            border: none;
            border-radius: 1.5rem;
            background: var(--kiosk-card);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.06), 0 8px 10px -6px rgba(0, 0, 0, 0.04);
            padding: 1.75rem 1.25rem;
            text-align: center;
            text-decoration: none;
            color: inherit;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
            min-height: 180px;
            transition: transform 0.15s ease, box-shadow 0.15s ease, border-color 0.15s ease;
            border: 2px solid transparent;
        }
        .kiosk-nav-card:hover, .kiosk-nav-card:focus {
            transform: translateY(-4px);
            box-shadow: 0 20px 30px -10px rgba(0, 0, 0, 0.12);
            color: inherit;
        }
        .kiosk-nav-card:active {
            transform: scale(0.97);
        }
        .kiosk-nav-card .icon-wrapper {
            width: 72px;
            height: 72px;
            border-radius: 1.25rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin-bottom: 1rem;
        }

        /* Status banner */
        .session-timer-pill {
            background: rgba(255, 255, 255, 0.18);
            backdrop-filter: blur(8px);
            border-radius: 50rem;
            padding: 0.4rem 1rem;
            font-size: 0.95rem;
            font-weight: 600;
        }

        /* Kiosk Footer */
        .kiosk-footer {
            margin-top: auto;
            background: #ffffff;
            border-top: 1px solid #e2e8f0;
            padding: 0.85rem 1.5rem;
        }
    </style>
    @stack('styles')
</head>
<body>

    <!-- Kiosk Top Navigation Bar -->
    <header class="kiosk-header">
        <div class="container-fluid d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-3">
                <div class="bg-white text-primary rounded-3 p-2 d-flex align-items-center justify-content-center shadow-sm" style="width: 48px; height: 48px;">
                    <i class="bi bi-display-fill fs-3 text-primary"></i>
                </div>
                <div>
                    <h3 class="mb-0 fw-bold fs-4 text-white">CAMPUS SELF-SERVICE KIOSK</h3>
                    <small class="text-white-50">Campus Terminal &bull; Main Lobby</small>
                </div>
            </div>

            <div class="d-flex align-items-center gap-3">
                @auth('student')
                    <div class="session-timer-pill d-flex align-items-center gap-2">
                        <i class="bi bi-person-circle fs-5 text-warning"></i>
                        <span>{{ Auth::guard('student')->user()->first_name }} ({{ Auth::guard('student')->user()->student_number }})</span>
                        <span class="badge bg-warning text-dark ms-2" id="kiosk-timer-display"><i class="bi bi-clock-history"></i> <span id="timer-seconds">90</span>s</span>
                    </div>

                    <form action="{{ route('kiosk.logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-touch py-2 px-3 fs-6">
                            <i class="bi bi-box-arrow-right"></i> Log Out
                        </button>
                    </form>
                @else
                    <a href="{{ route('kiosk.login') }}" class="btn btn-warning btn-touch py-2 px-4 text-dark fs-6 fw-bold">
                        <i class="bi bi-shield-lock-fill"></i> Student Sign In
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Alert Notices -->
    <div class="container-fluid mt-3">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm border-0 d-flex align-items-center gap-3 py-3" role="alert">
                <i class="bi bi-check-circle-fill fs-3 text-success"></i>
                <div class="fs-5 fw-semibold">{{ session('success') }}</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('info'))
            <div class="alert alert-info alert-dismissible fade show rounded-4 shadow-sm border-0 d-flex align-items-center gap-3 py-3" role="alert">
                <i class="bi bi-info-circle-fill fs-3 text-info"></i>
                <div class="fs-5 fw-semibold">{{ session('info') }}</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('warning'))
            <div class="alert alert-warning alert-dismissible fade show rounded-4 shadow-sm border-0 d-flex align-items-center gap-3 py-3" role="alert">
                <i class="bi bi-exclamation-triangle-fill fs-3 text-warning"></i>
                <div class="fs-5 fw-semibold">{{ session('warning') }}</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show rounded-4 shadow-sm border-0 d-flex align-items-center gap-3 py-3" role="alert">
                <i class="bi bi-exclamation-octagon-fill fs-3 text-danger"></i>
                <div class="fs-5 fw-semibold">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        @endif
    </div>

    <!-- Main Content Container -->
    <main class="flex-grow-1 py-4">
        @yield('content')
    </main>

    <!-- Kiosk Bottom Navigation & Controls -->
    <footer class="kiosk-footer">
        <div class="container-fluid d-flex align-items-center justify-content-between">
            <div class="d-flex gap-2">
                @if(!request()->routeIs('kiosk.home'))
                    <a href="{{ route('kiosk.home') }}" class="btn btn-outline-primary btn-touch py-2 px-3">
                        <i class="bi bi-house-door-fill"></i> Home
                    </a>
                    <button type="button" onclick="window.history.back()" class="btn btn-outline-secondary btn-touch py-2 px-3">
                        <i class="bi bi-arrow-left"></i> Back
                    </button>
                @endif
            </div>

            <div class="text-center text-muted small">
                <span>Touch screen enabled &bull; For assistance, press <strong>Help</strong> &bull; Sessions automatically end when left unattended</span>
            </div>

            <div class="text-muted fw-semibold">
                <span id="current-live-time"></span>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Kiosk Auto-Inactivity Timer and Clock Script -->
    <script>
        // 1. Live Campus Clock
        function updateClock() {
            const now = new Date();
            const timeStr = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', second: '2-digit' });
            const dateStr = now.toLocaleDateString([], { weekday: 'short', month: 'short', day: 'numeric' });
            const clockEl = document.getElementById('current-live-time');
            if (clockEl) {
                clockEl.textContent = `${dateStr} | ${timeStr}`;
            }
        }
        setInterval(updateClock, 1000);
        updateClock();

        // 2. Client-side Inactivity Idle Countdown for Authenticated Sessions
        @auth('student')
            let secondsLeft = 90;
            const timerDisplay = document.getElementById('timer-seconds');

            function resetTimer() {
                secondsLeft = 90;
                if (timerDisplay) timerDisplay.textContent = secondsLeft;
            }

            // User interaction resets timer
            ['touchstart', 'mousedown', 'mousemove', 'keydown', 'scroll'].forEach(evt => {
                window.addEventListener(evt, resetTimer, { passive: true });
            });

            setInterval(() => {
                secondsLeft--;
                if (timerDisplay) {
                    timerDisplay.textContent = secondsLeft;
                    if (secondsLeft <= 20) {
                        timerDisplay.parentElement.classList.remove('bg-warning');
                        timerDisplay.parentElement.classList.add('bg-danger', 'text-white');
                    } else {
                        timerDisplay.parentElement.classList.remove('bg-danger', 'text-white');
                        timerDisplay.parentElement.classList.add('bg-warning');
                    }
                }

                if (secondsLeft <= 0) {
                    // Automatically submit logout
                    window.location.href = "{{ route('kiosk.logout') }}";
                }
            }, 1000);
        @endauth
    </script>
    @stack('scripts')
</body>
</html>
