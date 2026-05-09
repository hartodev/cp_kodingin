<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password — PanduanFlow Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
    :root {
        --gold: #F4C430;
        --gold-light: #FAD689;
        --black: #030304;
        --near-black: #0D0D11;
        --text: rgba(255, 255, 255, 0.95);
        --muted: rgba(255, 255, 255, 0.45);
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Inter', sans-serif;
        background: var(--black);
        color: var(--text);
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    body::before {
        content: '';
        position: fixed;
        inset: 0;
        background-image: linear-gradient(rgba(244, 196, 48, 0.04) 1px, transparent 1px), linear-gradient(90deg, rgba(244, 196, 48, 0.04) 1px, transparent 1px);
        background-size: 60px 60px;
        pointer-events: none;
    }

    body::after {
        content: '';
        position: fixed;
        width: 600px;
        height: 600px;
        background: radial-gradient(circle, rgba(244, 196, 48, 0.12) 0%, transparent 70%);
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        pointer-events: none;
    }

    .login-wrapper {
        position: relative;
        z-index: 10;
        width: 100%;
        max-width: 440px;
        padding: 1rem;
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

    .login-card {
        background: rgba(13, 13, 17, 0.85);
        backdrop-filter: blur(40px);
        border: 1px solid rgba(244, 196, 48, 0.15);
        border-radius: 28px;
        padding: 3rem 2.5rem;
    }

    .login-logo {
        text-align: center;
        margin-bottom: 2rem;
    }

    .logo-icon {
        width: 64px;
        height: 64px;
        background: linear-gradient(135deg, var(--gold), var(--gold-light));
        border-radius: 20px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        margin-bottom: 1rem;
        box-shadow: 0 0 40px rgba(244, 196, 48, 0.3);
    }

    .login-logo h1 {
        font-size: 1.5rem;
        font-weight: 800;
        background: linear-gradient(135deg, var(--gold), var(--gold-light));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .login-logo p {
        font-size: 0.85rem;
        color: var(--muted);
        margin-top: 0.3rem;
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

    .alert-danger {
        background: rgba(239, 68, 68, 0.1);
        border: 1px solid rgba(239, 68, 68, 0.3);
        color: #EF4444;
    }

    .alert-success {
        background: rgba(16, 185, 129, 0.1);
        border: 1px solid rgba(16, 185, 129, 0.3);
        color: #10B981;
    }

    .form-group {
        margin-bottom: 1.4rem;
    }

    .form-label {
        display: block;
        font-size: 0.82rem;
        font-weight: 600;
        color: var(--muted);
        text-transform: uppercase;
        letter-spacing: 0.8px;
        margin-bottom: 0.6rem;
    }

    .input-wrap {
        position: relative;
    }

    .input-icon {
        position: absolute;
        left: 1.1rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--muted);
        font-size: 0.9rem;
        pointer-events: none;
    }

    .form-control {
        width: 100%;
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(244, 196, 48, 0.15);
        border-radius: 12px;
        padding: 0.9rem 1rem 0.9rem 2.8rem;
        color: var(--text);
        font-size: 0.95rem;
        font-family: 'Inter', sans-serif;
        outline: none;
        transition: border-color 0.3s, background 0.3s;
    }

    .form-control::placeholder {
        color: var(--muted);
    }

    .form-control:focus {
        border-color: rgba(244, 196, 48, 0.5);
        background: rgba(244, 196, 48, 0.04);
    }

    .invalid-feedback {
        font-size: 0.8rem;
        color: #EF4444;
        margin-top: 0.4rem;
        display: flex;
        align-items: center;
        gap: 0.4rem;
    }

    .btn-submit {
        width: 100%;
        background: linear-gradient(135deg, var(--gold), var(--gold-light));
        color: var(--black);
        border: none;
        border-radius: 12px;
        padding: 1rem;
        font-size: 1rem;
        font-weight: 700;
        font-family: 'Inter', sans-serif;
        cursor: pointer;
        transition: transform 0.25s, box-shadow 0.25s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.6rem;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 16px 40px rgba(244, 196, 48, 0.35);
    }

    .login-note {
        text-align: center;
        margin-top: 1.5rem;
        font-size: 0.85rem;
        color: var(--muted);
    }

    .login-note a {
        color: var(--gold);
        text-decoration: none;
    }
    </style>
</head>

<body>
    <div class="login-wrapper">
        <div class="login-card">
            <div class="login-logo">
                <div class="logo-icon">🔑</div>
                <h1>Lupa Password</h1>
                <p>Masukkan email kamu untuk menerima link reset password</p>
            </div>

            @if(session('success'))
            <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('admin.password.email') }}">
                @csrf
                <div class="form-group">
                    <label class="form-label">Email Admin</label>
                    <div class="input-wrap">
                        <i class="fas fa-envelope input-icon"></i>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                            placeholder="admin@panduanflow.com" value="{{ old('email') }}" autofocus>
                    </div>
                    @error('email')
                    <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn-submit">
                    <i class="fas fa-paper-plane"></i> Kirim Link Reset
                </button>
            </form>

            <div class="login-note">
                <a href="{{ route('admin.login') }}">← Kembali ke Login</a>
            </div>
        </div>
    </div>
</body>

</html>