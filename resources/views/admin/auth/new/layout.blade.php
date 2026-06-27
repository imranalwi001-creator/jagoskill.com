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

    @if($isRtl)
        <link rel="stylesheet" href="/assets/design_1/css/rtl-app.min.css">
    @endif

    @stack('styles_top')
    @stack('scripts_top')

    <style>
        :root{
            --admin-auth-bg:#071526;
            --admin-auth-panel:#0e2238;
            --admin-auth-line:rgba(255,255,255,.12);
            --admin-auth-text:#f7fbff;
            --admin-auth-muted:#9fb2c8;
            --admin-auth-primary:#18b6a3;
            --admin-auth-primary-dark:#0f8378;
            --admin-auth-accent:#f5b85f;
        }
        body.admin-auth-body{
            background:
                radial-gradient(circle at 14% 18%, rgba(24,182,163,.28), transparent 28rem),
                radial-gradient(circle at 86% 82%, rgba(245,184,95,.2), transparent 24rem),
                linear-gradient(135deg, #06111f 0%, var(--admin-auth-bg) 58%, #10263d 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            overflow-x: hidden;
            color: var(--admin-auth-text);
            font-family: "Segoe UI", "Helvetica Neue", Arial, sans-serif;
        }
        .admin-auth-shell{
            position: relative;
            width: 100%;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 28px 16px;
        }
        .admin-auth-shell:before{
            content:"";
            position: fixed;
            inset: 0;
            pointer-events: none;
            opacity: .15;
            background-image:
                linear-gradient(rgba(255,255,255,.08) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,.08) 1px, transparent 1px);
            background-size: 44px 44px;
            mask-image: linear-gradient(to bottom, #000, transparent 78%);
        }
        .admin-auth-container{
            position: relative;
            z-index: 1;
            width: min(100%, 448px);
            padding: 32px;
            background: linear-gradient(180deg, rgba(14,34,56,.96), rgba(8,22,38,.98));
            border: 1px solid var(--admin-auth-line);
            border-radius: 22px;
            box-shadow: 0 22px 70px rgba(0,0,0,.34);
            font-family: "Segoe UI", "Helvetica Neue", Arial, sans-serif !important;
        }
        .admin-auth-container *{
            font-family: inherit !important;
        }
        .admin-auth-home-link{
            position: absolute;
            top: 24px;
            left: 24px;
            z-index: 2;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            min-height: 46px;
            padding: 7px 16px 7px 8px;
            color: var(--admin-auth-text);
            background:
                linear-gradient(135deg, rgba(255,255,255,.16), rgba(255,255,255,.06)) padding-box,
                linear-gradient(135deg, rgba(125,228,215,.75), rgba(245,184,95,.52)) border-box;
            border: 1px solid transparent;
            border-radius: 999px;
            box-shadow: 0 16px 42px rgba(0,0,0,.22), inset 0 1px 0 rgba(255,255,255,.18);
            backdrop-filter: blur(14px);
            font-size: 14px;
            font-weight: 800;
            text-decoration: none;
            overflow: hidden;
            transition: transform .18s ease, box-shadow .18s ease, color .18s ease;
        }
        .admin-auth-home-link:before{
            content:"";
            position: absolute;
            inset: 1px;
            border-radius: inherit;
            background: linear-gradient(120deg, rgba(255,255,255,.22), transparent 42%);
            pointer-events: none;
        }
        .admin-auth-home-link:hover{
            color: var(--admin-auth-text);
            transform: translateY(-2px);
            box-shadow: 0 20px 48px rgba(0,0,0,.28), 0 0 0 4px rgba(24,182,163,.12);
            text-decoration: none;
        }
        .admin-auth-home-link__icon{
            position: relative;
            z-index: 1;
            width: 30px;
            height: 30px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            color: #06111f;
            background: linear-gradient(135deg, #7de4d7, #f5b85f);
            box-shadow: 0 8px 20px rgba(24,182,163,.2);
            font-size: 17px;
            line-height: 1;
        }
        .admin-auth-home-link__text{
            position: relative;
            z-index: 1;
        }
        .admin-auth-container:before{
            content:"";
            position: absolute;
            top: 0;
            left: 24px;
            right: 24px;
            height: 3px;
            border-radius: 0 0 999px 999px;
            background: linear-gradient(90deg, var(--admin-auth-primary), var(--admin-auth-accent));
        }
        .admin-auth-container h1,
        .admin-auth-container h2,
        .admin-auth-container h3,
        .admin-auth-container h4,
        .admin-auth-container h5{
            font-family: inherit !important;
            letter-spacing: 0;
        }
        .admin-auth-container h1{
            font-weight: 800;
            line-height: 1.22;
        }
        .admin-auth-container label{
            position: static !important;
            display: inline-flex;
            width: auto !important;
            height: auto !important;
            transform: none !important;
            color: var(--admin-auth-muted);
            font-weight: 600;
            font-size: 14px;
            margin-bottom: 8px;
            background-color: transparent !important;
            padding: 0;
            line-height: 1.35;
        }
        .admin-auth-container .form-group{
            margin-bottom: 18px !important;
        }
        .admin-auth-container .form-group > .d-flex{
            min-height: 20px;
            margin-bottom: 8px !important;
        }
        .admin-auth-container .form-control{
            height: 50px;
            color: var(--admin-auth-text) !important;
            background: rgba(255,255,255,.07) !important;
            border: 1px solid rgba(255,255,255,.14) !important;
            border-radius: 14px;
            padding: 13px 16px;
            transition: border-color .18s ease, box-shadow .18s ease, background-color .18s ease;
        }
        .admin-auth-container input.form-control{
            line-height: 1.35;
        }
        .admin-auth-container .form-control:focus{
            background: rgba(255,255,255,.1) !important;
            border-color: var(--admin-auth-primary) !important;
            box-shadow: 0 0 0 4px rgba(24,182,163,.16) !important;
        }
        .admin-auth-container .btn-primary{
            min-height: 52px;
            background: linear-gradient(135deg, var(--admin-auth-primary), var(--admin-auth-primary-dark)) !important;
            border: none;
            border-radius: 14px;
            font-weight: 800;
            letter-spacing: 0;
            transition: transform .18s ease, box-shadow .18s ease;
        }
        .admin-auth-container .btn-primary:hover{
            transform: translateY(-2px);
            box-shadow: 0 14px 26px rgba(24,182,163,.24);
        }
        .admin-auth-container a{
            color: #7de4d7;
            text-decoration: none;
        }
        .admin-auth-container a:hover{
            color: var(--admin-auth-text);
        }
        .admin-auth-logo{
            max-width: 150px;
            max-height: 58px;
            object-fit: contain;
            filter: brightness(0) invert(1);
        }
        .admin-auth-muted{
            color: var(--admin-auth-muted);
        }
        .admin-auth-container .password-input-visibility{
            position: absolute !important;
            top: 42px !important;
            right: 15px !important;
            left: auto !important;
            bottom: auto !important;
            transform: none !important;
            z-index: 3;
        }
        .rtl .admin-auth-container .password-input-visibility{
            right: auto !important;
            left: 15px !important;
        }
        .admin-auth-forgot{
            position: static !important;
            right: auto !important;
            top: auto !important;
            display: inline-flex !important;
            width: auto !important;
            margin-left: auto;
            font-size: 12px;
            line-height: 1.4;
            white-space: nowrap;
        }
        .admin-auth-container .custom-control{
            min-height: 24px;
            padding-left: 0 !important;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .admin-auth-container .custom-control-input{
            position: static !important;
            width: 20px !important;
            height: 20px !important;
            margin: 0 !important;
            opacity: 1 !important;
        }
        .admin-auth-container .custom-control__label,
        .admin-auth-container .custom-control-label{
            margin: 0 !important;
            color: var(--admin-auth-muted);
            font-weight: 700;
        }
        .admin-auth-container .custom-control__label:before,
        .admin-auth-container .custom-control__label:after,
        .admin-auth-container .custom-control-label:before,
        .admin-auth-container .custom-control-label:after{
            display: none !important;
        }
        .admin-auth-footer{
            position: relative;
            z-index: 1;
            width: min(100%, 448px);
            margin-top: 18px;
            color: rgba(247,251,255,.68);
            text-align: center;
            font-size: 12px;
            line-height: 1.6;
        }
        .admin-auth-footer a{
            color: #7de4d7;
            font-weight: 700;
            text-decoration: none;
        }
        .admin-auth-footer a:hover{
            color: var(--admin-auth-text);
        }
        @media (max-width: 575px){
            .admin-auth-home-link{
                position: relative;
                top: auto;
                left: auto;
                margin-bottom: 18px;
            }
            .admin-auth-container{
                padding: 24px 18px;
                border-radius: 18px;
            }
        }
    </style>
</head>

<body class="admin-auth-body {{ $isRtl ? 'rtl' : '' }}">

<div id="app">
    <main class="admin-auth-shell">
        <a href="/" class="admin-auth-home-link">
            <span class="admin-auth-home-link__icon">&larr;</span>
            <span class="admin-auth-home-link__text">{{ trans('navbar.home') }}</span>
        </a>

        <div class="w-100 d-flex flex-column align-items-center">
            <div class="admin-auth-container">
                @yield('content')
            </div>

            <footer class="admin-auth-footer">
                <div>{{ $generalSettings['site_name'] ?? config('app.name') }} admin area</div>
                <div><a href="/">{{ trans('navbar.home') }}</a> &middot; <a href="/contact">{{ trans('site.contact_us') }}</a></div>
            </footer>
        </div>
    </main>
</div>

<!-- Template JS File -->
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
