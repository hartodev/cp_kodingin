<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password — {{ config('app.name', 'PanduanFlow') }}</title>
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
            padding: 2rem 1rem;
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
            margin-bottom: 2rem;
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

        .icon-wrap {
            width: 70px;
            height: 70px;
            background: rgba(244, 196, 48, 0.1);
            border: 1px solid rgba(244, 196, 48, 0.25);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 1.8rem;
            color: var(--gold);
        }

        .auth-title {
            font-size: 1.5rem;
            font-weight: 800;
            margin-bottom: 0.4rem;
            text-align: center;
            background: linear-gradient(135deg, #fff, var(--gold));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .auth-sub {
            font-size: 0.88rem;
            color: var(--text-muted);
            margin-bottom: 2rem;
            text-align: center;
            line-height: 1.6;
        }

        .alert {
            padding: 0.9rem 1.2rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            font-size: 0.88rem;
            display: flex;
            align-items: flex-start;
            gap: 0.7rem;
        }

        .alert-danger {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #EF4444;
        }

        .form-group {
            margin-bottom: 1.2rem;
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
            transition: border-color 0.3s;
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.25);
        }

        .form-control:focus {
            border-color: rgba(244, 196, 48, 0.5);
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

        .strength-bar {
            height: 4px;
            border-radius: 4px;
            background: rgba(255, 255, 255, 0.08);
            margin-top: 0.5rem;
            overflow: hidden;
        }

        .strength-fill {
            height: 100%;
            border-radius: 4px;
            transition: width 0.3s, background 0.3s;
            width: 0;
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
            margin-top: 1.5rem;
        }

        .btn-auth:hover {
            transform: translateY(-2px);
            box-shadow: 0 16px 40px rgba(244, 196, 48, 0.35);
        }

        .auth-footer {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.88rem;
            color: var(--text-muted);
        }

        .auth-footer a {
            color: var(--gold);
            text-decoration: none;
            font-weight: 600;
        }
    </style>
</head>

<body>

    <div class="particles" id="particles"></div>

    <div class="auth-wrapper">
        <div class="auth-card">

            <div class="auth-logo">
                <a href="{{ url('/') }}">{{ config('app.name', 'PanduanFlow') }}</a>
            </div>

            <div class="icon-wrap"><i class="fas fa-shield-alt"></i></div>

            <div class="auth-title">Buat Password Baru</div>
            <p class="auth-sub">Masukkan password baru untuk akunmu.</p>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle" style="flex-shrink:0;margin-top:2px;"></i>
                    <ul style="margin:0;padding-left:1rem;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('auth.password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="form-group">
                    <label class="form-label">Email</label>
                    <div class="input-wrap">
                        <i class="fas fa-envelope input-icon"></i>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                            placeholder="kamu@email.com" value="{{ old('email') }}" autofocus>
                    </div>
                    @error('email')
                        <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Password Baru</label>
                    <div class="input-wrap">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" name="password" id="pwInput"
                            class="form-control @error('password') is-invalid @enderror"
                            placeholder="Minimal 8 karakter" autocomplete="new-password">
                    </div>
                    <div class="strength-bar">
                        <div class="strength-fill" id="strengthFill"></div>
                    </div>
                    @error('password')
                        <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Konfirmasi Password</label>
                    <div class="input-wrap">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" name="password_confirmation" class="form-control"
                            placeholder="Ulangi password baru" autocomplete="new-password">
                    </div>
                </div>

                <button type="submit" class="btn-auth">
                    <i class="fas fa-check"></i> Reset Password
                </button>
            </form>

            <div class="auth-footer">
                <a href="{{ route('auth.login') }}">
                    <i class="fas fa-arrow-left" style="margin-right:0.3rem;"></i> Kembali ke Login
                </a>
            </div>

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
        const pwInput = document.getElementById('pwInput');
        const fill = document.getElementById('strengthFill');
        if (pwInput) {
            pwInput.addEventListener('input', function() {
                const val = pwInput.value;
                let s = 0;
                if (val.length >= 8) s++;
                if (/[A-Z]/.test(val)) s++;
                if (/[0-9]/.test(val)) s++;
                if (/[^A-Za-z0-9]/.test(val)) s++;
                const colors = ['#EF4444', '#F59E0B', '#10B981', '#10B981'];
                const widths = ['25%', '50%', '75%', '100%'];
                fill.style.width = val.length ? widths[s - 1] || '25%' : '0';
                fill.style.background = val.length ? colors[s - 1] || '#EF4444' : '';
            });
        }
    </script>

</body>

</html>
