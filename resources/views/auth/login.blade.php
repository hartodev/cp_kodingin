<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Masuk — {{ config('app.name', 'PanduanFlow') }}</title>
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
            --text: #FFFFFF;
            --text-muted: #B8BCC9;
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
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .particles {
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 0;
        }

        .particle {
            position: absolute;
            background: radial-gradient(circle, var(--gold) 0%, transparent 70%);
            border-radius: 50%;
            animation: float 20s infinite linear;
        }

        @keyframes float {
            0% {
                transform: translateY(100vh);
                opacity: 0;
            }

            10% {
                opacity: 0.5;
            }

            90% {
                opacity: 0.5;
            }

            100% {
                transform: translateY(-100px);
                opacity: 0;
            }
        }

        .auth-wrapper {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 460px;
            padding: 1.5rem;
            animation: fadeUp 0.6s cubic-bezier(0.23, 1, 0.32, 1) both;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .auth-card {
            background: rgba(255, 255, 255, 0.04);
            backdrop-filter: blur(40px);
            border: 1px solid rgba(244, 196, 48, 0.15);
            border-radius: 28px;
            padding: 3rem 2.5rem;
        }

        .auth-logo {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .auth-logo a {
            font-size: 2rem;
            font-weight: 900;
            text-decoration: none;
            background: linear-gradient(135deg, var(--gold), var(--gold-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .auth-logo p {
            font-size: 0.88rem;
            color: var(--text-muted);
            margin-top: 0.5rem;
        }

        .auth-title {
            font-size: 1.6rem;
            font-weight: 800;
            margin-bottom: 0.4rem;
            background: linear-gradient(135deg, #fff, var(--gold));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .auth-sub {
            font-size: 0.88rem;
            color: var(--text-muted);
            margin-bottom: 2rem;
        }

        .alert {
            padding: 0.9rem 1.2rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            font-size: 0.88rem;
            display: flex;
            align-items: center;
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

        .form-group {
            margin-bottom: 1.3rem;
        }

        .form-label {
            display: block;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.6px;
            margin-bottom: 0.5rem;
        }

        .input-wrap {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 0.88rem;
        }

        .form-control {
            width: 100%;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(244, 196, 48, 0.2);
            border-radius: 12px;
            padding: 0.9rem 1rem 0.9rem 2.8rem;
            color: var(--text);
            font-size: 0.95rem;
            font-family: 'Inter', sans-serif;
            outline: none;
            transition: border-color 0.3s, background 0.3s;
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.25);
        }

        .form-control:focus {
            border-color: rgba(244, 196, 48, 0.5);
            background: rgba(244, 196, 48, 0.04);
        }

        .form-control.is-invalid {
            border-color: rgba(239, 68, 68, 0.5);
        }

        .invalid-feedback {
            font-size: 0.78rem;
            color: #EF4444;
            margin-top: 0.4rem;
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }

        .form-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.8rem;
        }

        .remember-label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.85rem;
            color: var(--text-muted);
            cursor: pointer;
        }

        .remember-label input {
            accent-color: var(--gold);
            width: 15px;
            height: 15px;
        }

        .forgot-link {
            font-size: 0.85rem;
            color: var(--gold);
            text-decoration: none;
            transition: opacity 0.2s;
        }

        .forgot-link:hover {
            opacity: 0.75;
        }

        .btn-auth {
            width: 100%;
            background: linear-gradient(135deg, var(--gold), var(--gold-light));
            color: var(--dark-1);
            border: none;
            border-radius: 12px;
            padding: 1rem;
            font-size: 1rem;
            font-weight: 700;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.6rem;
            transition: transform 0.25s, box-shadow 0.25s;
        }

        .btn-auth:hover {
            transform: translateY(-2px);
            box-shadow: 0 16px 40px rgba(244, 196, 48, 0.35);
        }

        .auth-divider {
            text-align: center;
            margin: 1.5rem 0;
            font-size: 0.82rem;
            color: rgba(255, 255, 255, 0.2);
            position: relative;
        }

        .auth-divider::before,
        .auth-divider::after {
            content: '';
            position: absolute;
            top: 50%;
            width: 40%;
            height: 1px;
            background: rgba(255, 255, 255, 0.08);
        }

        .auth-divider::before {
            left: 0;
        }

        .auth-divider::after {
            right: 0;
        }

        .auth-footer {
            text-align: center;
            font-size: 0.88rem;
            color: var(--text-muted);
        }

        .auth-footer a {
            color: var(--gold);
            text-decoration: none;
            font-weight: 600;
        }

        .auth-footer a:hover {
            text-decoration: underline;
        }

        .back-home {
            display: block;
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.82rem;
            color: rgba(255, 255, 255, 0.3);
            text-decoration: none;
            transition: color 0.2s;
        }

        .back-home:hover {
            color: var(--gold);
        }
    </style>
</head>

<body>

    <div class="particles" id="particles"></div>

    <div class="auth-wrapper">
        <div class="auth-card">

            {{-- Logo --}}
            <div class="auth-logo">
                <a href="{{ url('/') }}">{{ config('app.name', 'PanduanFlow') }}</a>
                <p>Platform belajar next generation</p>
            </div>

            <div class="auth-title">Selamat Datang</div>
            <p class="auth-sub">Masuk ke akunmu untuk melanjutkan belajar</p>

            {{-- Alert --}}
            @if (session('success'))
                <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger"><i class="fas fa-times-circle"></i> {{ session('error') }}</div>
            @endif

            {{-- Form --}}
            <form method="POST" action="{{ route('auth.login.store') }}">
                @csrf

                <div class="form-group">
                    <label class="form-label">Email</label>
                    <div class="input-wrap">
                        <i class="fas fa-envelope input-icon"></i>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                            placeholder="kamu@email.com" value="{{ old('email') }}" autofocus autocomplete="email">
                    </div>
                    @error('email')
                        <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Password</label>
                    <div class="input-wrap">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" name="password"
                            class="form-control @error('password') is-invalid @enderror" placeholder="••••••••"
                            autocomplete="current-password">
                    </div>
                    @error('password')
                        <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>

                <div class="form-footer">
                    <label class="remember-label">
                        <input type="checkbox" name="remember"> Ingat saya
                    </label>
                    <a href="{{ route('auth.password.request') }}" class="forgot-link">Lupa password?</a>
                </div>

                <button type="submit" class="btn-auth">
                    <i class="fas fa-sign-in-alt"></i> Masuk
                </button>
            </form>

            <div class="auth-divider">atau</div>

            <div class="auth-footer">
                Belum punya akun?
                <a href="{{ route('auth.register') }}">Daftar Gratis</a>
            </div>

            <a href="{{ url('/') }}" class="back-home">
                <i class="fas fa-arrow-left" style="margin-right:0.3rem;"></i> Kembali ke website
            </a>

        </div>
    </div>

    <script>
        const c = document.getElementById('particles');
        for (let i = 0; i < 35; i++) {
            const p = document.createElement('div');
            p.className = 'particle';
            p.style.cssText =
                `left:${Math.random()*100}%;width:${Math.random()*4+2}px;height:${Math.random()*4+2}px;animation-duration:${Math.random()*20+12}s;animation-delay:${Math.random()*20}s;`;
            c.appendChild(p);
        }
    </script>

</body>

</html>
