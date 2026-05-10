<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — {{ config('app.name', 'PanduanFlow') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --gold: #F4C430;
            --gold-light: #F7D154;
            --dark-1: #0F0F23;
            --dark-2: #1A1A2E;
            --dark-3: #16213E;
            --sidebar-w: 260px;
            --text: rgba(255, 255, 255, 0.95);
            --text-muted: rgba(255, 255, 255, 0.45);
            --glass: rgba(244, 196, 48, 0.06);
            --border: rgba(244, 196, 48, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, var(--dark-1) 0%, var(--dark-2) 50%, var(--dark-3) 100%);
            color: var(--text);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* ── Scrollbar ── */
        ::-webkit-scrollbar {
            width: 5px;
        }

        ::-webkit-scrollbar-track {
            background: var(--dark-1);
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(244, 196, 48, 0.3);
            border-radius: 5px;
        }

        /* ── SIDEBAR ── */
        .user-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: var(--sidebar-w);
            background: rgba(10, 10, 20, 0.92);
            backdrop-filter: blur(30px);
            border-right: 1px solid var(--border);
            z-index: 100;
            display: flex;
            flex-direction: column;
            transition: transform 0.3s ease;
            overflow-y: auto;
        }

        .sidebar-logo {
            padding: 1.8rem 1.5rem;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }

        .sidebar-logo a {
            font-size: 1.4rem;
            font-weight: 900;
            text-decoration: none;
            background: linear-gradient(135deg, var(--gold), var(--gold-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .sidebar-logo span {
            font-size: 0.72rem;
            color: var(--text-muted);
            display: block;
            margin-top: 1px;
        }

        .sidebar-user {
            padding: 1.2rem 1.5rem;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--gold), var(--gold-light));
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            color: var(--dark-1);
            font-size: 0.9rem;
            flex-shrink: 0;
        }

        .user-name {
            font-weight: 700;
            font-size: 0.88rem;
            line-height: 1.3;
        }

        .user-role {
            font-size: 0.72rem;
            color: var(--gold);
        }

        .sidebar-nav {
            flex: 1;
            padding: 1rem 0;
        }

        .nav-group {
            padding: 0 1rem 0.5rem;
        }

        .nav-group-label {
            font-size: 0.65rem;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: var(--text-muted);
            padding: 0.5rem 0.5rem 0.3rem;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            padding: 0.7rem 0.8rem;
            border-radius: 10px;
            text-decoration: none;
            color: var(--text-muted);
            font-size: 0.88rem;
            font-weight: 500;
            transition: all 0.25s;
            margin-bottom: 0.15rem;
            position: relative;
        }

        .nav-item:hover {
            background: var(--glass);
            color: var(--text);
        }

        .nav-item.active {
            background: rgba(244, 196, 48, 0.12);
            color: var(--gold);
        }

        .nav-item .nav-icon {
            width: 18px;
            text-align: center;
            font-size: 0.9rem;
            flex-shrink: 0;
        }

        .nav-badge {
            margin-left: auto;
            background: #EF4444;
            color: #fff;
            font-size: 0.65rem;
            font-weight: 700;
            padding: 1px 6px;
            border-radius: 10px;
            min-width: 18px;
            text-align: center;
        }

        .sidebar-footer {
            padding: 1rem;
            border-top: 1px solid var(--border);
        }

        .btn-logout {
            display: flex;
            align-items: center;
            gap: 0.7rem;
            width: 100%;
            padding: 0.7rem 0.8rem;
            border-radius: 10px;
            background: rgba(239, 68, 68, 0.08);
            border: 1px solid rgba(239, 68, 68, 0.2);
            color: #EF4444;
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            transition: all 0.25s;
        }

        .btn-logout:hover {
            background: rgba(239, 68, 68, 0.15);
        }

        /* ── MAIN ── */
        .user-main {
            margin-left: var(--sidebar-w);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ── HEADER ── */
        .user-header {
            padding: 1.2rem 2rem;
            border-bottom: 1px solid var(--border);
            background: rgba(10, 10, 20, 0.6);
            backdrop-filter: blur(20px);
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .page-title {
            font-size: 1.2rem;
            font-weight: 800;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        /* ── CONTENT ── */
        .user-content {
            flex: 1;
            padding: 2rem;
        }

        /* ── CARD ── */
        .dash-card {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 1.5rem;
            transition: border-color 0.3s;
        }

        .dash-card:hover {
            border-color: rgba(244, 196, 48, 0.25);
        }

        .dash-card-title {
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: var(--text-muted);
            margin-bottom: 0.5rem;
        }

        /* ── STAT CARD ── */
        .stat-card {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 1.5rem;
            text-align: center;
        }

        .stat-number {
            font-size: 2.2rem;
            font-weight: 900;
            background: linear-gradient(135deg, var(--gold), var(--gold-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .stat-label {
            font-size: 0.78rem;
            color: var(--text-muted);
            margin-top: 0.2rem;
        }

        /* ── TABLE ── */
        .dash-table {
            width: 100%;
            border-collapse: collapse;
        }

        .dash-table th {
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--text-muted);
            padding: 0.7rem 1rem;
            text-align: left;
            border-bottom: 1px solid var(--border);
        }

        .dash-table td {
            padding: 0.9rem 1rem;
            border-bottom: 1px solid rgba(244, 196, 48, 0.04);
            font-size: 0.88rem;
        }

        .dash-table tr:hover td {
            background: rgba(244, 196, 48, 0.02);
        }

        /* ── BADGE / STATUS ── */
        .badge {
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 0.72rem;
            font-weight: 700;
        }

        .badge-gold {
            background: rgba(244, 196, 48, 0.12);
            color: var(--gold);
        }

        .badge-green {
            background: rgba(16, 185, 129, 0.12);
            color: #10B981;
        }

        .badge-red {
            background: rgba(239, 68, 68, 0.12);
            color: #EF4444;
        }

        .badge-blue {
            background: rgba(59, 130, 246, 0.12);
            color: #60A5FA;
        }

        .badge-orange {
            background: rgba(245, 158, 11, 0.12);
            color: #F59E0B;
        }

        /* ── BUTTON ── */
        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.7rem 1.4rem;
            border-radius: 50px;
            background: linear-gradient(135deg, var(--gold), var(--gold-light));
            color: var(--dark-1);
            border: none;
            font-weight: 700;
            font-size: 0.88rem;
            cursor: pointer;
            text-decoration: none;
            font-family: 'Inter', sans-serif;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(244, 196, 48, 0.3);
        }

        .btn-secondary {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.7rem 1.4rem;
            border-radius: 50px;
            background: rgba(255, 255, 255, 0.06);
            color: var(--text);
            border: 1px solid var(--border);
            font-weight: 600;
            font-size: 0.88rem;
            cursor: pointer;
            text-decoration: none;
            font-family: 'Inter', sans-serif;
            transition: all 0.2s;
        }

        .btn-secondary:hover {
            background: rgba(244, 196, 48, 0.08);
            border-color: rgba(244, 196, 48, 0.3);
        }

        .btn-danger {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.7rem 1.4rem;
            border-radius: 50px;
            background: rgba(239, 68, 68, 0.1);
            color: #EF4444;
            border: 1px solid rgba(239, 68, 68, 0.2);
            font-weight: 600;
            font-size: 0.88rem;
            cursor: pointer;
            text-decoration: none;
            font-family: 'Inter', sans-serif;
            transition: all 0.2s;
        }

        .btn-danger:hover {
            background: rgba(239, 68, 68, 0.2);
        }

        /* ── FORM ── */
        .form-group {
            margin-bottom: 1.3rem;
        }

        .form-label {
            display: block;
            font-size: 0.78rem;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.5rem;
        }

        .form-control {
            width: 100%;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 0.8rem 1rem;
            color: var(--text);
            font-size: 0.9rem;
            font-family: 'Inter', sans-serif;
            outline: none;
            transition: border-color 0.3s;
        }

        .form-control::placeholder {
            color: var(--text-muted);
        }

        .form-control:focus {
            border-color: rgba(244, 196, 48, 0.4);
        }

        .form-control.is-invalid {
            border-color: rgba(239, 68, 68, 0.5);
        }

        .invalid-feedback {
            font-size: 0.78rem;
            color: #EF4444;
            margin-top: 0.3rem;
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }

        textarea.form-control {
            resize: vertical;
            min-height: 100px;
        }

        /* ── ALERT ── */
        .alert {
            padding: 0.9rem 1.2rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            font-size: 0.88rem;
            display: flex;
            align-items: flex-start;
            gap: 0.7rem;
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.1);
            border: 1px solid rgba(16, 185, 129, 0.3);
            color: #10B981;
        }

        .alert-danger {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #EF4444;
        }

        .alert-info {
            background: rgba(244, 196, 48, 0.1);
            border: 1px solid rgba(244, 196, 48, 0.3);
            color: var(--gold);
        }

        /* ── PROGRESS BAR ── */
        .progress-bar {
            height: 6px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 6px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--gold), var(--gold-light));
            border-radius: 6px;
            transition: width 0.6s ease;
        }

        /* ── MOBILE ── */
        .mobile-toggle {
            display: none;
        }

        @media (max-width: 768px) {
            .user-sidebar {
                transform: translateX(-100%);
            }

            .user-sidebar.open {
                transform: translateX(0);
            }

            .user-main {
                margin-left: 0;
            }

            .user-content {
                padding: 1rem;
            }

            .user-header {
                padding: 1rem;
            }

            .mobile-toggle {
                display: flex;
            }
        }
    </style>
    @stack('styles')
</head>

<body>

    {{-- Sidebar --}}
    @include('user.layouts.sidebar')

    {{-- Main --}}
    <div class="user-main">

        {{-- Header --}}
        @include('user.layouts.header')

        {{-- Alert --}}
        @include('user.layouts.alert')

        {{-- Content --}}
        <div class="user-content">
            @yield('content')
        </div>

    </div>

    {{-- Overlay mobile --}}
    <div id="sidebarOverlay" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.6);z-index:99;"
        onclick="closeSidebar()"></div>

    <script>
        function openSidebar() {
            document.querySelector('.user-sidebar').classList.add('open');
            document.getElementById('sidebarOverlay').style.display = 'block';
        }

        function closeSidebar() {
            document.querySelector('.user-sidebar').classList.remove('open');
            document.getElementById('sidebarOverlay').style.display = 'none';
        }

        // Auto hide alert
        document.querySelectorAll('.alert').forEach(el => {
            setTimeout(() => {
                el.style.transition = 'opacity 0.5s';
                el.style.opacity = '0';
                setTimeout(() => el.remove(), 500);
            }, 5000);
        });
    </script>

    @stack('scripts')
</body>

</html>
