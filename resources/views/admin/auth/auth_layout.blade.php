<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
@php
    $rtlLanguages = !empty($generalSettings['rtl_languages']) ? $generalSettings['rtl_languages'] : [];

    $isRtl = ((in_array(mb_strtoupper(app()->getLocale()), $rtlLanguages)) or (!empty($generalSettings['rtl_layout']) and $generalSettings['rtl_layout'] == 1));
@endphp

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>{{ $pageTitle ?? '' }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- General CSS File -->
    <link rel="stylesheet" href="/assets/admin/vendor/bootstrap/bootstrap.min.css"/>
    <link rel="stylesheet" href="/assets/vendors/fontawesome/css/all.min.css"/>
    <link rel="stylesheet" href="/assets/admin/vendor/daterangepicker/daterangepicker.min.css">
    <link rel="stylesheet" href="/assets/admin/css/style.css">
    <link rel="stylesheet" href="/assets/admin/css/components.css">
    @if($isRtl)
        <link rel="stylesheet" href="/assets/admin/css/rtl.css">
    @endif
    <link rel="stylesheet" href="/assets/default/vendors/toast/jquery.toast.min.css">
    <link rel="stylesheet" href="/assets/admin/css/custom.css">
<style>
    :root {
        --glass-bg: rgba(18, 31, 62, 0.65);
        --glass-border: rgba(255, 255, 255, 0.1);
        --glass-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
        --dark-gradient: linear-gradient(135deg, #0e2145 0%, #121f3e 100%);
    }
    body.admin-auth-body {
        background: var(--dark-gradient);
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0;
        font-family: 'Inter', sans-serif;
    }
    /* Abstract shapes in the background */
    .bg-shape-1, .bg-shape-2 {
        position: fixed;
        border-radius: 50%;
        filter: blur(100px);
        z-index: 0;
        opacity: 0.5;
    }
    .bg-shape-1 {
        width: 400px;
        height: 400px;
        background: #0170ff;
        top: -100px;
        left: -100px;
    }
    .bg-shape-2 {
        width: 500px;
        height: 500px;
        background: #fe6257;
        bottom: -150px;
        right: -150px;
    }
    .admin-auth-container {
        position: relative;
        z-index: 1;
        width: 100%;
        max-width: 450px;
        padding: 40px;
        background: var(--glass-bg);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid var(--glass-border);
        border-radius: 24px;
        box-shadow: var(--glass-shadow);
        color: #fff;
    }
    .admin-auth-container label {
        color: #cdd5e2;
        font-weight: 500;
        font-size: 14px;
        margin-bottom: 8px;
    }
    .admin-auth-container .form-control {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: #fff;
        border-radius: 12px;
        padding: 12px 16px;
        height: auto;
        transition: all 0.3s ease;
    }
    .admin-auth-container .form-control:focus {
        background: rgba(255, 255, 255, 0.1);
        border-color: #0170ff;
        box-shadow: 0 0 0 4px rgba(1, 112, 255, 0.2);
    }
    .admin-auth-container .btn-primary {
        background: #0170ff;
        border: none;
        border-radius: 12px;
        padding: 12px;
        font-weight: 600;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
    }
    .admin-auth-container .btn-primary:hover {
        background: #67a9ff;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(1, 112, 255, 0.4);
    }
    .admin-auth-container a {
        color: #67a9ff;
        text-decoration: none;
        transition: color 0.3s ease;
    }
    .admin-auth-container a:hover {
        color: #fff;
    }
    .admin-auth-container .custom-control-label::before {
        background-color: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
</style>
</head>
<body class="@if($isRtl) rtl @endif admin-auth-body">

<div class="bg-shape-1"></div>
<div class="bg-shape-2"></div>

<div id="app" class="w-100 d-flex justify-content-center">
    <div class="admin-auth-container">
        @yield('content')
    </div>
</div>
<!-- General JS Scripts -->
<script src="/assets/admin/vendor/jquery/jquery-3.3.1.min.js"></script>
<script src="/assets/admin/vendor/poper/popper.min.js"></script>
<script src="/assets/admin/vendor/bootstrap/bootstrap.min.js"></script>
<script src="/assets/admin/vendor/nicescroll/jquery.nicescroll.min.js"></script>
<script src="/assets/admin/vendor/moment/moment.min.js"></script>
<script src="/assets/admin/js/stisla.js"></script>
<script src="/assets/admin/vendor/daterangepicker/daterangepicker.min.js"></script>
<script src="/assets/default/vendors/toast/jquery.toast.min.js"></script>

<script>
    (function () {
        "use strict";

        window.csrfToken = $('meta[name="csrf-token"]');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        window.adminPanelPrefix = '{{ getAdminPanelUrl() }}';

        @if(session()->has('toast'))
        $.toast({
            heading: '{{ session()->get('toast')['title'] ?? '' }}',
            text: '{{ session()->get('toast')['msg'] ?? '' }}',
            bgColor: '@if(session()->get('toast')['status'] == 'success') #43d477 @else #f63c3c @endif',
            textColor: 'white',
            hideAfter: 10000,
            position: 'bottom-right',
            icon: '{{ session()->get('toast')['status'] }}'
        });
        @endif
    })(jQuery);
</script>

<!-- Template JS File -->
<script src="/assets/admin/js/scripts.js"></script>
<script src="/assets/admin/js/custom.js"></script>

</body>
</html>
