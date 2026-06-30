<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

@php
    $generalSettings = $generalSettings ?? getGeneralSettings();
    $rtlLanguages = !empty($generalSettings['rtl_languages']) ? $generalSettings['rtl_languages'] : [];
    $isRtl = ((in_array(mb_strtoupper(app()->getLocale()), $rtlLanguages)) or (!empty($generalSettings['rtl_layout']) and $generalSettings['rtl_layout'] == 1));
    $userThemeColorMode = 'light';
@endphp

<head>
    @include('design_1.web.includes.metas')
    <title>{{ $pageTitle ?? '' }}{{ !empty($generalSettings['site_name']) ? (' | '.$generalSettings['site_name']) : '' }}</title>

    <link rel="stylesheet" href="/assets/design_1/css/app.min.css">
    <link rel="stylesheet" href="/assets/admin/css/extra.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @if($isRtl)
        <link rel="stylesheet" href="/assets/design_1/css/rtl-app.min.css">
    @endif

    @stack('styles_top')
    @stack('scripts_top')

    <style>
        :root {
            --admin-auth-bg: #090e17;
            --admin-auth-panel: rgba(15, 23, 42, 0.45);
            --admin-auth-line: rgba(255, 255, 255, 0.08);
            --admin-auth-text: #f8fafc;
            --admin-auth-muted: #94a3b8;
            --admin-auth-primary: #18b6a3;
            --admin-auth-primary-dark: #0f8378;
            --admin-auth-accent: #f5b85f;
            --font-family: 'Outfit', sans-serif;
        }

        body.admin-auth-body {
            background-color: var(--admin-auth-bg);
            min-height: 100vh;
            margin: 0;
            overflow-x: hidden;
            color: var(--admin-auth-text);
            font-family: var(--font-family);
            display: flex;
            align-items: stretch;
            justify-content: stretch;
        }

        .split-wrapper {
            display: flex;
            width: 100%;
            min-height: 100vh;
        }

        /* Left Side: Brand Panel */
        .brand-side {
            flex: 1.2;
            background: linear-gradient(135deg, #090e17 0%, #0c1829 50%, #050b14 100%);
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 60px;
            overflow: hidden;
        }

        @media (max-width: 991px) {
            .brand-side {
                display: none;
            }
        }

        /* Abstract glowing blobs for futuristic effect */
        .glowing-blob-1 {
            position: absolute;
            top: -10%;
            left: -10%;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(24, 182, 163, 0.15) 0%, transparent 70%);
            filter: blur(50px);
            pointer-events: none;
            animation: float-slow 12s infinite alternate;
        }

        .glowing-blob-2 {
            position: absolute;
            bottom: -10%;
            right: -10%;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(245, 184, 95, 0.08) 0%, transparent 70%);
            filter: blur(60px);
            pointer-events: none;
            animation: float-slow 18s infinite alternate-reverse;
        }

        @keyframes float-slow {
            0% { transform: translate(0, 0) scale(1); }
            100% { transform: translate(40px, 30px) scale(1.1); }
        }

        /* Cybernetic grid overlay */
        .brand-side::before {
            content: "";
            position: absolute;
            inset: 0;
            opacity: 0.04;
            background-image: 
                linear-gradient(rgba(255, 255, 255, 0.1) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.1) 1px, transparent 1px);
            background-size: 50px 50px;
            pointer-events: none;
        }

        .brand-logo-container img {
            max-height: 48px;
            filter: drop-shadow(0 0 12px rgba(24, 182, 163, 0.3));
        }

        .brand-content {
            position: relative;
            z-index: 2;
            max-width: 600px;
            margin-top: auto;
            margin-bottom: auto;
            text-align: left;
        }

        .brand-badge {
            display: inline-flex;
            align-items: center;
            padding: 6px 14px;
            border-radius: 99px;
            background: rgba(24, 182, 163, 0.1);
            border: 1px solid rgba(24, 182, 163, 0.2);
            color: var(--admin-auth-primary);
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 24px;
            letter-spacing: 0.5px;
        }

        .brand-title {
            font-size: 42px;
            font-weight: 800;
            line-height: 1.2;
            color: #ffffff;
            margin-bottom: 20px;
        }

        .brand-title span {
            background: linear-gradient(120deg, var(--admin-auth-primary), var(--admin-auth-accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .brand-description {
            font-size: 16px;
            color: var(--admin-auth-muted);
            line-height: 1.6;
        }

        .brand-footer {
            position: relative;
            z-index: 2;
            font-size: 13px;
            color: rgba(255, 255, 255, 0.4);
            display: flex;
            gap: 20px;
        }

        /* Right Side: Form Panel */
        .form-side {
            flex: 0.9;
            background: #05080e;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 40px;
            position: relative;
            border-left: 1px solid var(--admin-auth-line);
        }

        @media (max-width: 991px) {
            .form-side {
                flex: 1;
                border-left: none;
            }
        }

        .admin-auth-container {
            width: 100%;
            max-width: 420px;
            background: var(--admin-auth-panel);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--admin-auth-line);
            border-radius: 24px;
            padding: 40px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3);
            position: relative;
        }

        .admin-auth-container::before {
            content: "";
            position: absolute;
            top: 0;
            left: 10%;
            right: 10%;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--admin-auth-primary), var(--admin-auth-accent), transparent);
        }

        /* Isolated Form Styling to avoid system conflicts */
        .auth-input-group {
            margin-bottom: 22px !important;
            position: relative;
            text-align: left;
        }

        .auth-label {
            display: block !important;
            font-size: 14px !important;
            font-weight: 600 !important;
            color: #e2e8f0 !important;
            margin-bottom: 8px !important;
            background: transparent !important;
            padding: 0 !important;
            position: static !important;
            transform: none !important;
            height: auto !important;
            width: auto !important;
        }

        .auth-input {
            width: 100% !important;
            height: 48px !important;
            background: rgba(15, 23, 42, 0.6) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            border-radius: 12px !important;
            color: #ffffff !important;
            padding: 10px 16px !important;
            font-size: 15px !important;
            outline: none !important;
            box-sizing: border-box !important;
            transition: all 0.25s ease !important;
        }

        .auth-input:focus {
            border-color: var(--admin-auth-primary) !important;
            box-shadow: 0 0 0 3px rgba(24, 182, 163, 0.25) !important;
            background: rgba(15, 23, 42, 0.8) !important;
        }

        /* Override Browser Auto-fill color changes */
        .auth-input:-webkit-autofill,
        .auth-input:-webkit-autofill:hover,
        .auth-input:-webkit-autofill:focus {
            -webkit-text-fill-color: #ffffff !important;
            -webkit-box-shadow: 0 0 0px 1000px #0b1324 inset !important;
            transition: background-color 5000s ease-in-out 0s;
        }

        /* Password Visibility icon placement fix */
        .admin-auth-container .password-input-visibility {
            position: absolute !important;
            top: 12px !important;
            right: 16px !important;
            z-index: 10 !important;
            left: auto !important;
            bottom: auto !important;
            transform: none !important;
            background: transparent !important;
        }

        .admin-auth-forgot {
            font-size: 13px;
            color: var(--admin-auth-primary) !important;
            font-weight: 600;
            background: transparent !important;
            text-decoration: none !important;
            transition: color 0.2s ease;
        }

        .admin-auth-forgot:hover {
            color: var(--admin-auth-accent) !important;
        }

        /* Custom Checkbox Group styling */
        .auth-checkbox-group {
            display: flex !important;
            align-items: center !important;
            gap: 10px !important;
            margin-top: 15px !important;
            text-align: left;
        }

        .auth-checkbox-input {
            width: 18px !important;
            height: 18px !important;
            cursor: pointer !important;
            accent-color: var(--admin-auth-primary) !important;
            margin: 0 !important;
            position: static !important;
            opacity: 1 !important;
        }

        .auth-checkbox-label {
            color: var(--admin-auth-muted) !important;
            font-size: 14px !important;
            font-weight: 500 !important;
            cursor: pointer !important;
            margin: 0 !important;
            background: transparent !important;
            padding: 0 !important;
            position: static !important;
            transform: none !important;
        }

        /* Premium Buttons */
        .admin-auth-container .btn-primary {
            height: 50px;
            background: linear-gradient(135deg, var(--admin-auth-primary) 0%, var(--admin-auth-primary-dark) 100%) !important;
            border: none;
            border-radius: 12px;
            font-weight: 700;
            font-size: 16px;
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(24, 182, 163, 0.2);
            transition: all 0.25s ease;
        }

        .admin-auth-container .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(24, 182, 163, 0.4);
        }

        /* Top Home Button */
        .admin-auth-home-link {
            position: absolute;
            top: 24px;
            right: 24px;
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 99px;
            color: var(--admin-auth-text);
            font-size: 14px;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .admin-auth-home-link:hover {
            background: rgba(255, 255, 255, 0.08);
            border-color: var(--admin-auth-primary);
            color: #ffffff;
            text-decoration: none;
        }

        .admin-auth-footer {
            margin-top: 30px;
            font-size: 13px;
            color: var(--admin-auth-muted);
            text-align: center;
        }

        .admin-auth-footer a {
            color: var(--admin-auth-primary);
            font-weight: 600;
            transition: color 0.2s ease;
        }

        .admin-auth-footer a:hover {
            color: var(--admin-auth-accent);
            text-decoration: none;
        }
    </style>
</head>

<body class="admin-auth-body {{ $isRtl ? 'rtl' : '' }}">

<div id="app" class="w-100">
    <div class="split-wrapper">
        <!-- Left Brand Side -->
        <div class="brand-side">
            <div class="glowing-blob-1"></div>
            <div class="glowing-blob-2"></div>

            <div class="brand-logo-container">
                <img src="{{ $generalSettings['logo'] ?? '' }}" alt="logo" loading="eager">
            </div>

            <div class="brand-content">
                <div class="brand-badge">JAGOSKILL MANAGEMENT</div>
                <h1 class="brand-title">Elevate Your Platform, <span>Control the Future</span></h1>
                <p class="brand-description">Welcome to the JagoSkill administration command center. Manage webinars, courses, bundles, user restrictions, and configure system operations smoothly in a fast, robust workspace.</p>
            </div>

            <div class="brand-footer">
                <span>&copy; {{ date('Y') }} JagoSkill</span>
                <span>Version 1.4.0</span>
            </div>
        </div>

        <!-- Right Form Side -->
        <div class="form-side">
            <a href="/" class="admin-auth-home-link">
                <span>&larr;</span>
                <span>{{ trans('navbar.home') }}</span>
            </a>

            <div class="admin-auth-container">
                @yield('content')
            </div>

            <footer class="admin-auth-footer">
                <div>{{ $generalSettings['site_name'] ?? config('app.name') }} Admin Command Panel</div>
                <div class="mt-2">
                    <a href="/">{{ trans('navbar.home') }}</a> &middot; 
                    <a href="/contact">{{ trans('site.contact_us') }}</a>
                </div>
            </footer>
        </div>
    </div>
</div>

<script>
    var themeColorsMode = {};
</script>

<script defer type="text/javascript" src="/assets/design_1/js/app.min.js"></script>

@if(session()->has('toast'))
    <script>
        window.addEventListener('load', function () {
            if (typeof showToast === 'function') {
                showToast('{{ session()->get('toast')['status'] }}', '{{ session()->get('toast')['title'] ?? '' }}', '{{ session()->get('toast')['msg'] ?? '' }}');
            }
        });
    </script>
@endif

@stack('styles_bottom')
@stack('scripts_bottom')

<script defer src="/assets/admin/js/parts/auth_pages.min.js"></script>
<script defer src="/assets/design_1/js/parts/general.min.js"></script>
</body>
</html>
