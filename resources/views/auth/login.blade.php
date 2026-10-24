@php
    $companyName = setting('company_name', setting('website_title', 'Unibox'));
    $adminLogo = setting('header_logo', setting('logo', setting('footer_logo')));
    $navIcon = setting('favicon', setting('nav_icon'));
    $hasLogo = $adminLogo && file_exists(public_path($adminLogo));
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $companyName }} | Admin Login</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=Manrope:wght@400;500;600;700&family=Hind+Siliguri:wght@400;500&display=swap" rel="stylesheet">
    @if($navIcon)
        <link rel="shortcut icon" href="{{ asset($navIcon) }}" type="image/x-icon">
    @endif

    <style>
        :root {
            --ff-serif: 'Instrument Serif', Georgia, serif;
            --ff-body: 'Manrope', 'Hind Siliguri', -apple-system, BlinkMacSystemFont, sans-serif;

            --night: #07110D;
            --night-2: #0C1C15;
            --forest: #123226;
            --gold: #D4B97F;
            --gold-soft: #E9D9B1;
            --on-dark: #F1EFE8;
            --on-dark-2: rgba(241,239,232,.62);

            --bg: #F8F8F6;
            --card: #FFFFFF;
            --ink: #0E1A15;
            --text-2: #5E6A64;
            --text-3: #8E9893;
            --line: #E4E6E3;
            --line-strong: #CBD0CC;
            --accent: #0B3D2B;
            --accent-hover: #115239;

            --r-md: 12px;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        html, body { height: 100%; }

        body {
            font-family: var(--ff-body);
            color: var(--ink);
            background: var(--bg);
            -webkit-font-smoothing: antialiased;
        }

        .layout { display: grid; grid-template-columns: 1.1fr 1fr; min-height: 100vh; }

        /* ================= LEFT ================= */
        .showcase {
            position: relative;
            overflow: hidden;
            padding: 48px 64px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            color: var(--on-dark);
            background:
                radial-gradient(ellipse 70% 55% at 85% 90%, rgba(212,185,127,.14), transparent 70%),
                linear-gradient(165deg, var(--night-2) 0%, var(--night) 100%);
        }

        .showcase > * { position: relative; z-index: 1; }

        .rosette {
            position: absolute !important;
            z-index: 0 !important;
            right: -190px; bottom: -190px;
            width: 720px; height: 720px;
            pointer-events: none;
            animation: rosette-in 2.2s ease-out both;
        }
        @keyframes rosette-in {
            from { opacity: 0; transform: rotate(-14deg) scale(.94); }
            to   { opacity: 1; transform: rotate(0) scale(1); }
        }

        .brand { display: flex; align-items: center; gap: 12px; min-height: 40px; }
        .brand img { max-height: 40px; max-width: 170px; object-fit: contain; }

        .mark {
            width: 38px; height: 38px; border-radius: 50%;
            display: grid; place-items: center;
            background: linear-gradient(180deg, #17352A, #0C1F18);
            box-shadow: 0 0 0 1px rgba(212,185,127,.45), inset 0 1px 0 rgba(255,255,255,.08);
            flex-shrink: 0;
        }
        .mark svg { width: 17px; height: 17px; }

        .brand-name { font-weight: 600; font-size: 15px; letter-spacing: .01em; }

        .pitch { max-width: 470px; }

        .headline {
            font-family: var(--ff-serif);
            font-weight: 400;
            font-size: clamp(42px, 4.6vw, 66px);
            line-height: 1.02;
            letter-spacing: -.015em;
        }
        .headline em { font-style: italic; color: var(--gold-soft); }

        .pitch-sub {
            margin-top: 22px;
            font-size: 16px;
            line-height: 1.65;
            color: var(--on-dark-2);
            max-width: 380px;
        }

        .showcase-foot { font-size: 13px; color: rgba(241,239,232,.42); }

        /* ================= RIGHT ================= */
        .auth {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 48px 40px;
        }

        .mobile-brand { display: none; }

        .auth-card { width: 100%; max-width: 390px; }

        .heading {
            font-family: var(--ff-serif);
            font-weight: 400;
            font-size: 42px;
            line-height: 1.05;
            letter-spacing: -.015em;
        }

        .subheading {
            margin: 10px 0 32px;
            font-size: 15px;
            color: var(--text-2);
            line-height: 1.5;
        }

        .auth-alert {
            padding: 12px 14px;
            border-radius: 10px;
            font-size: 14px;
            line-height: 1.45;
            margin-bottom: 22px;
        }
        .auth-alert-danger { background: #FEF2F2; border: 1px solid #FECACA; color: #991B1B; }
        .auth-alert-success { background: #F0FDF4; border: 1px solid #BBF7D0; color: #166534; }

        .field { margin-bottom: 20px; }

        .field label {
            display: block;
            font-size: 13.5px;
            font-weight: 600;
            color: var(--ink);
            margin-bottom: 8px;
        }

        .field-control { position: relative; }

        .field-control input {
            width: 100%;
            height: 52px;
            padding: 0 16px;
            font: inherit;
            font-size: 15px;
            color: var(--ink);
            background: var(--card);
            border: 1px solid var(--line);
            border-radius: var(--r-md);
            outline: none;
            box-shadow: 0 1px 2px rgba(14,26,21,.04);
            transition: border-color .15s, box-shadow .15s;
        }

        .field-control input::placeholder { color: var(--text-3); }
        .field-control input:hover { border-color: var(--line-strong); }
        .field-control input:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 4px rgba(11,61,43,.1);
        }

        .field-control.has-toggle input { padding-right: 72px; }

        .toggle-pass {
            position: absolute;
            right: 8px; top: 50%;
            transform: translateY(-50%);
            font: inherit;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-2);
            background: none;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            padding: 8px 10px;
            transition: color .15s, background .15s;
        }
        .toggle-pass:hover { color: var(--ink); background: rgba(14,26,21,.05); }

        .row-options {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin: 4px 0 26px;
            font-size: 13.5px;
        }

        .remember {
            display: flex; align-items: center; gap: 9px;
            color: var(--text-2);
            cursor: pointer; user-select: none;
        }
        .remember input { width: 16px; height: 16px; accent-color: var(--accent); cursor: pointer; }

        .row-options a {
            color: var(--ink);
            font-weight: 600;
            text-decoration: none;
            border-bottom: 1px solid var(--line-strong);
            transition: border-color .15s;
        }
        .row-options a:hover { border-bottom-color: var(--ink); }

        button.btn-primary {
            width: 100%;
            height: 54px;
            font: inherit;
            font-size: 15.5px;
            font-weight: 600;
            letter-spacing: .01em;
            color: #fff;
            background: linear-gradient(180deg, #145138 0%, var(--accent) 100%);
            border: none;
            border-radius: var(--r-md);
            cursor: pointer;
            box-shadow: 0 0 0 1px rgba(212,185,127,.0), inset 0 1px 0 rgba(255,255,255,.14), 0 12px 24px -10px rgba(11,61,43,.55);
            transition: background .15s, transform .08s, box-shadow .15s;
        }
        button.btn-primary:hover { background: linear-gradient(180deg, #1A6246 0%, var(--accent-hover) 100%); }
        button.btn-primary:active { transform: translateY(1px); }

        .back-link { margin-top: 24px; text-align: center; }
        .back-link a {
            font-size: 14px;
            font-weight: 500;
            color: var(--text-2);
            text-decoration: none;
        }
        .back-link a:hover { color: var(--ink); text-decoration: underline; text-underline-offset: 3px; }

        .page-footer {
            margin-top: 40px;
            text-align: center;
            font-size: 12.5px;
            color: var(--text-3);
        }

        button:focus-visible, a:focus-visible, input:focus-visible {
            outline: 2px solid var(--accent);
            outline-offset: 2px;
        }

        /* ================= RESPONSIVE ================= */
        @media (max-width: 980px) {
            .layout { grid-template-columns: 1fr; }
            .showcase { display: none; }
            .auth { padding: 40px 24px; min-height: 100vh; }
            .mobile-brand { display: flex; align-items: center; gap: 10px; margin-bottom: 36px; }
            .mobile-brand img { max-height: 36px; max-width: 150px; object-fit: contain; }
            .mobile-brand .brand-name { color: var(--ink); }
            .heading { font-size: 38px; }
        }

        @media (max-width: 400px) {
            .auth { padding: 32px 18px; }
            .heading { font-size: 34px; }
        }

        @media (prefers-reduced-motion: reduce) {
            .rosette { animation: none; }
        }
    </style>
</head>

<body>

<div class="layout">

    <!-- ============ LEFT: SHOWCASE ============ -->
    <aside class="showcase">
        <svg class="rosette" id="rosette" viewBox="-300 -300 600 600" aria-hidden="true"></svg>

        <div class="brand">
            @if($hasLogo)
                <a href="{{ url('/') }}" title="{{ $companyName }}" style="display:inline-block;">
                    <img src="{{ asset($adminLogo) }}" alt="{{ $companyName }}">
                </a>
            @else
                <div class="mark">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6 8H18L17.2 19.5C17.14 20.33 16.43 21 15.6 21H8.4C7.57 21 6.86 20.33 6.8 19.5L6 8Z" stroke="#E9D9B1" stroke-width="1.8" stroke-linejoin="round"/>
                        <path d="M9 8V6.5C9 4.567 10.567 3 12.5 3C14.433 3 16 4.567 16 6.5V8" stroke="#E9D9B1" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <span class="brand-name">{{ $companyName }} Admin</span>
            @endif
        </div>

        <div class="pitch">
            <h2 class="headline">Your store, <em>in perfect order.</em></h2>
            <p class="pitch-sub">Orders, stock and customers in one calm, clear workspace.</p>
        </div>

        <p class="showcase-foot">&copy; {{ date('Y') }} {{ $companyName }}</p>
    </aside>

    <!-- ============ RIGHT: LOGIN FORM ============ -->
    <main class="auth">
        <div class="mobile-brand">
            @if($hasLogo)
                <a href="{{ url('/') }}" title="{{ $companyName }}" style="display:inline-block;">
                    <img src="{{ asset($adminLogo) }}" alt="{{ $companyName }}">
                </a>
            @else
                <div class="mark">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6 8H18L17.2 19.5C17.14 20.33 16.43 21 15.6 21H8.4C7.57 21 6.86 20.33 6.8 19.5L6 8Z" stroke="#E9D9B1" stroke-width="1.8" stroke-linejoin="round"/>
                        <path d="M9 8V6.5C9 4.567 10.567 3 12.5 3C14.433 3 16 4.567 16 6.5V8" stroke="#E9D9B1" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <span class="brand-name">{{ $companyName }}</span>
            @endif
        </div>

        <div class="auth-card">
            <h1 class="heading">Welcome back</h1>
            <p class="subheading">Log in to manage your store.</p>

            @if(session('error'))
                <div class="auth-alert auth-alert-danger" role="alert">
                    <strong>Error:</strong> {{ session('error') }}
                </div>
            @endif

            @if(isset($errors) && $errors->any() && !session('error'))
                <div class="auth-alert auth-alert-danger" role="alert">
                    {{ $errors->first() }}
                </div>
            @endif

            @if(session('status'))
                <div class="auth-alert auth-alert-success" role="status">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="field">
                    <label for="email">Email address</label>
                    <div class="field-control">
                        <input type="text" id="email" name="email" value="{{ old('email') }}" placeholder="you@yourstore.com" required autocomplete="username" autofocus>
                    </div>
                </div>

                <div class="field">
                    <label for="pass">Password</label>
                    <div class="field-control has-toggle">
                        <input type="password" id="pass" name="password" placeholder="Enter your password" required autocomplete="current-password">
                        <button type="button" class="toggle-pass" onclick="togglePass()" aria-label="Show or hide password">Show</button>
                    </div>
                </div>

                <div class="row-options">
                    <label class="remember">
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        Remember me
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}">Forgot password?</a>
                    @endif
                </div>

                <button type="submit" class="btn-primary">Log in</button>

                <div class="back-link">
                    <a href="{{ url('/') }}">← Return to Website (ওয়েবসাইটে যান)</a>
                </div>
            </form>
        </div>

        <p class="page-footer">
            Protected by {{ $companyName }} Administrative Shield
        </p>
    </main>

</div>

<script>
    function togglePass() {
        const input = document.getElementById("pass");
        const btn = document.querySelector(".toggle-pass");
        const isHidden = input.type === "password";
        input.type = isHidden ? "text" : "password";
        btn.textContent = isHidden ? "Hide" : "Show";
    }

    // Guilloche rosette: rotated ellipses, like the pattern on banknotes and fine certificates
    (function () {
        const svg = document.getElementById("rosette");
        if (!svg) return;
        const NS = "http://www.w3.org/2000/svg";
        const g = document.createElementNS(NS, "g");
        g.setAttribute("fill", "none");
        g.setAttribute("stroke", "#D4B97F");
        g.setAttribute("stroke-width", "0.7");
        const count = 36;
        for (let i = 0; i < count; i++) {
            const e = document.createElementNS(NS, "ellipse");
            e.setAttribute("rx", "270");
            e.setAttribute("ry", "96");
            e.setAttribute("transform", "rotate(" + (i * 180 / count) + ")");
            e.setAttribute("stroke-opacity", (0.38 - (i % 6) * 0.04).toFixed(2));
            g.appendChild(e);
        }
        const ring = document.createElementNS(NS, "circle");
        ring.setAttribute("r", "280");
        ring.setAttribute("stroke-opacity", "0.25");
        g.appendChild(ring);
        svg.appendChild(g);
    })();
</script>

</body>
</html>