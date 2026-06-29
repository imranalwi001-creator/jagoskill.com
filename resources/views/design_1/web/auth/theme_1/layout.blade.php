<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

@php
    $rtlLanguages = !empty($generalSettings['rtl_languages']) ? $generalSettings['rtl_languages'] : [];
    $isRtl = ((in_array(mb_strtoupper(app()->getLocale()), $rtlLanguages)) or (!empty($generalSettings['rtl_layout']) and $generalSettings['rtl_layout'] == 1));
@endphp

<head>
    @include('design_1.web.includes.metas')
    <title>{{ $pageTitle ?? '' }}{{ !empty($generalSettings['site_name']) ? (' | '.$generalSettings['site_name']) : '' }}</title>

    <link rel="stylesheet" href="/assets/design_1/css/app.min.css">
    <link rel="stylesheet" href="{{ getDesign1StylePath("auth/theme_1") }}">

    @if($isRtl)
        <link rel="stylesheet" href="/assets/design_1/css/rtl-app.min.css">
    @endif

    @stack('styles_top')
    @stack('scripts_top')
    <style>
        :root{
            --auth-ink:#142033;
            --auth-muted:#67758a;
            --auth-line:#dfe6ee;
            --auth-paper:#ffffff;
            --auth-soft:#f5f8fb;
            --auth-primary:#10998f;
            --auth-primary-dark:#087f78;
            --auth-primary-soft:#e7f7f5;
            --auth-accent:#f4a64a;
        }
        body.auth-premium-body{
            min-height: 100vh;
            overflow-x: hidden;
            color: var(--auth-ink);
            background:
                radial-gradient(circle at 12% 8%, rgba(16,153,143,.16), transparent 28rem),
                radial-gradient(circle at 90% 22%, rgba(244,166,74,.12), transparent 24rem),
                linear-gradient(135deg, #f7fbfb 0%, #edf6f5 100%);
        }
        .auth-shell{
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding-top: 40px;
            padding-bottom: 40px;
        }
        .auth-shell > .row{
            width: 100%;
        }
        .auth-home-link{
            position: absolute;
            top: 24px;
            left: 24px;
            z-index: 5;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            min-height: 46px;
            padding: 7px 16px 7px 8px;
            border-radius: 999px;
            color: var(--auth-ink);
            background:
                linear-gradient(135deg, rgba(255,255,255,.94), rgba(255,255,255,.74)) padding-box,
                linear-gradient(135deg, rgba(16,153,143,.72), rgba(244,166,74,.58)) border-box;
            border: 1px solid transparent;
            box-shadow: 0 16px 42px rgba(20,32,51,.12), inset 0 1px 0 rgba(255,255,255,.75);
            backdrop-filter: blur(14px);
            font-weight: 800;
            text-decoration: none;
            overflow: hidden;
            transition: transform .16s ease, box-shadow .16s ease, color .16s ease;
        }
        .auth-home-link:before{
            content:"";
            position: absolute;
            inset: 1px;
            border-radius: inherit;
            background: linear-gradient(120deg, rgba(255,255,255,.7), transparent 44%);
            pointer-events: none;
        }
        .auth-home-link:hover{
            color: var(--auth-primary-dark);
            text-decoration: none;
            transform: translateY(-2px);
            box-shadow: 0 20px 48px rgba(20,32,51,.16), 0 0 0 4px rgba(14,159,143,.12);
        }
        .auth-home-link__icon{
            position: relative;
            z-index: 1;
            width: 30px;
            height: 30px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            color: #fff;
            background: linear-gradient(135deg, var(--auth-primary), var(--auth-primary-dark));
            box-shadow: 0 8px 20px rgba(14,159,143,.22);
            line-height: 1;
            font-size: 17px;
        }
        .auth-home-link__text{
            position: relative;
            z-index: 1;
        }
        .auth-premium-card{
            background: rgba(255,255,255,.96);
            border-radius: 26px;
            border: 1px solid rgba(20,32,51,.08);
            box-shadow: 0 24px 80px rgba(20,32,51,.1);
            padding: 20px;
            overflow: hidden;
        }
        .auth-page-card{
            width: 100%;
            max-width: 960px;
            margin: 0 auto;
        }
        .auth-form-pane{
            padding: 18px 24px;
            min-width: 0;
        }
        .auth-eyebrow{
            color: var(--auth-primary-dark);
            letter-spacing: 0;
        }
        .modern-input-group{
            position: relative;
            margin-bottom: 18px;
        }
        .modern-input-group .form-group-label,
        .modern-input-group label{
            color: var(--auth-muted);
            font-weight: 700;
            font-size: 13px;
            margin-bottom: 8px;
            background: transparent !important;
            padding: 0;
        }
        .modern-input-group .form-control,
        .modern-input-group .register-mobile-form-group__input{
            min-height: 50px;
            border-radius: 14px !important;
            padding: 13px 16px !important;
            border: 1px solid var(--auth-line) !important;
            background: var(--auth-soft) !important;
            color: var(--auth-ink) !important;
            font-size: 15px !important;
            transition: border-color .16s ease, box-shadow .16s ease, background-color .16s ease !important;
            box-shadow: none !important;
        }
        .modern-input-group .password-field-input{
            padding-right: 50px !important;
        }
        .modern-input-group .password-field-wrapper{
            position: relative;
        }
        .modern-input-group .form-control:focus,
        .modern-input-group .register-mobile-form-group__input:focus{
            background: #fff !important;
            border-color: var(--auth-primary) !important;
            box-shadow: 0 0 0 4px rgba(14,159,143,.13) !important;
        }
        .modern-input-group .password-input-visibility{
            top: calc(50% + 14px);
            right: 14px;
            width: 30px !important;
            height: 30px !important;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            border: 1px solid rgba(16,153,143,.18);
            color: var(--auth-primary-dark) !important;
            background: rgba(255,255,255,.92);
            box-shadow: 0 8px 20px rgba(20,32,51,.08);
            transition: color .16s ease, background-color .16s ease, border-color .16s ease, box-shadow .16s ease;
        }
        .modern-input-group .password-field-wrapper .password-input-visibility{
            top: 50%;
        }
        .modern-input-group .password-input-visibility:hover{
            color: #fff !important;
            border-color: var(--auth-primary);
            background: linear-gradient(135deg, var(--auth-primary), var(--auth-primary-dark));
            box-shadow: 0 10px 22px rgba(16,153,143,.2);
        }
        .modern-input-group .password-input-visibility svg{
            width: 17px !important;
            height: 17px !important;
            color: currentColor !important;
            stroke: currentColor !important;
        }
        .rtl .modern-input-group .password-input-visibility{
            right: auto;
            left: 14px;
        }
        .rtl .modern-input-group .password-field-input{
            padding-right: 16px !important;
            padding-left: 50px !important;
        }
        .auth-method-switch{
            background: var(--auth-primary-soft);
            border: 1px solid rgba(20,32,51,.08);
            flex-wrap: wrap;
        }
        .auth-method-switch .auth-register-method-item{
            min-width: 0;
        }
        .auth-register-method-item input:checked + label{
            background: linear-gradient(135deg, var(--auth-primary), var(--auth-primary-dark)) !important;
            color: #fff !important;
            box-shadow: 0 10px 20px rgba(16,153,143,.18);
        }
        .modern-btn{
            min-height: 52px;
            border-radius: 14px !important;
            padding: 14px 16px !important;
            background: linear-gradient(135deg, var(--auth-primary), var(--auth-primary-dark)) !important;
            border: 0 !important;
            font-weight: 800 !important;
            font-size: 16px !important;
            letter-spacing: 0 !important;
            transition: transform .16s ease, box-shadow .16s ease !important;
        }
        .modern-btn:hover{
            transform: translateY(-2px) !important;
            box-shadow: 0 14px 26px rgba(14,159,143,.22) !important;
        }
        .auth-page-form-container{
            height: auto !important;
            max-height: clamp(320px, 44vh, 430px);
            overflow-y: auto;
            overflow-x: hidden;
            overscroll-behavior: contain;
            padding-right: 10px;
            scrollbar-width: thin;
            scrollbar-color: rgba(16,153,143,.74) rgba(231,247,245,.8);
        }
        .auth-page-form-container::-webkit-scrollbar{
            width: 6px;
        }
        .auth-page-form-container::-webkit-scrollbar-thumb{
            background: linear-gradient(180deg, var(--auth-primary), var(--auth-primary-dark));
            border-radius: 999px;
        }
        .auth-page-form-container::-webkit-scrollbar-track{
            background: rgba(231,247,245,.8);
            border-radius: 999px;
        }
        .auth-static-showcase{
            height: 100%;
            min-height: 548px;
            border-radius: 20px;
            overflow: hidden;
            background-color: var(--auth-primary-dark);
            background-size: cover;
            background-position: center;
            box-shadow: inset 0 1px 0 rgba(255,255,255,.18), 0 18px 44px rgba(8,127,120,.16);
        }
        .auth-static-showcase__overlay{
            height: 100%;
            min-height: inherit;
            padding: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            background:
                linear-gradient(180deg, rgba(8,127,120,.08), rgba(7,73,73,.88)),
                radial-gradient(circle at 78% 12%, rgba(244,166,74,.26), transparent 16rem),
                radial-gradient(circle at 12% 18%, rgba(255,255,255,.18), transparent 18rem),
                linear-gradient(135deg, rgba(16,153,143,.95), rgba(9,54,70,.96));
            color: #fff;
            text-align: center;
        }
        .auth-static-showcase__content{
            max-width: 420px;
            min-height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        .auth-static-showcase__image{
            min-height: auto;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 16px 8px;
        }
        .auth-static-showcase__image img{
            width: min(70%, 280px);
            max-height: 260px;
            object-fit: contain;
            filter: drop-shadow(0 24px 32px rgba(4,28,36,.24));
        }
        .auth-footer{
            margin-top: 18px;
            color: var(--auth-muted);
            font-size: 13px;
            text-align: center;
        }
        .auth-footer a{
            color: var(--auth-primary-dark);
            font-weight: 800;
            text-decoration: none;
        }
        .auth-footer a:hover{
            color: var(--auth-primary);
            text-decoration: none;
        }
        @media (max-width: 991px){
            .auth-shell{
                align-items: flex-start;
                flex-direction: column;
                min-height: auto;
                padding-top: 16px;
                padding-bottom: 24px;
            }
            .auth-home-link{
                position: relative;
                top: auto;
                left: auto;
                margin: 0 auto 14px;
            }
            .auth-premium-card{
                padding: 12px;
                border-radius: 20px;
            }
            .auth-form-pane{
                padding: 12px 10px 16px;
            }
            .auth-page-form-container{
                height: auto !important;
                max-height: min(520px, 56vh);
                overflow-y: auto;
                overflow-x: hidden;
                padding-right: 8px;
            }
            .auth-static-showcase{
                height: auto;
                min-height: 420px;
            }
            .auth-static-showcase__image{
                min-height: 220px;
            }
        }
        @media (max-width: 575px){
            .auth-shell.container{
                padding-left: 12px;
                padding-right: 12px;
            }
            .auth-page-card__mask{
                display: none;
            }
            .auth-premium-card{
                padding: 10px;
                border-radius: 18px;
            }
            .auth-form-pane{
                padding: 8px 4px 14px;
            }
            .auth-method-switch{
                gap: 6px !important;
            }
            .auth-method-switch .auth-register-method-item{
                flex: 1 1 100%;
            }
            .auth-method-switch .auth-register-method-item label{
                height: 42px;
            }
            .modern-input-group{
                margin-bottom: 16px;
            }
            .auth-page-form-container{
                max-height: min(480px, 54vh);
                padding-right: 6px;
            }
            .modern-input-group .form-control,
            .modern-input-group .register-mobile-form-group__input{
                min-height: 48px;
                font-size: 14px !important;
            }
            .modern-input-group .password-input-visibility{
                top: calc(50% + 13px);
            }
            .modern-input-group .password-field-wrapper .password-input-visibility{
                top: 50%;
            }
            .auth-static-showcase{
                min-height: 360px;
                border-radius: 16px;
            }
            .auth-static-showcase__overlay{
                padding: 24px;
            }
            .auth-static-showcase__image{
                min-height: 190px;
                padding-top: 8px;
            }
            .auth-static-showcase__image img{
                width: min(72%, 230px);
                max-height: 220px;
            }
            .modern-btn{
                min-height: 50px;
            }
        }
    </style>
</head>

<body class="auth-premium-body {{ $isRtl ? 'rtl' : '' }} light-mode">
<div id="app">
    <section class="auth-shell container position-relative">
        <a href="/" class="auth-home-link">
            <span class="auth-home-link__icon">&larr;</span>
            <span class="auth-home-link__text">{{ trans('navbar.home') }}</span>
        </a>

        <div class="row justify-content-center">
            <div class="col-12 col-lg-10">
                <div class="auth-page-card position-relative">
                    <div class="auth-page-card__mask"></div>

                    <div class="position-relative auth-premium-card z-index-2">
                        <div class="row align-items-stretch">
                            <div class="col-12 col-lg-6 auth-form-pane">
                                @yield("page_content")
                            </div>

                            <div class="col-12 col-lg-6 d-none d-lg-flex">
                                @include('design_1.web.auth.theme_1.includes.slider')
                            </div>
                        </div>
                    </div>

                    <footer class="auth-footer">
                        <div>{{ $generalSettings['site_name'] ?? config('app.name') }}</div>
                        <div><a href="/">{{ trans('navbar.home') }}</a> &middot; <a href="/contact">{{ trans('site.contact_us') }}</a></div>
                    </footer>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    var siteDomain = '{{ url('') }}';
    var deleteAlertTitle = '{{ trans('public.are_you_sure') }}';
    var deleteAlertHint = '{{ trans('public.deleteAlertHint') }}';
    var deleteAlertConfirm = '{{ trans('public.deleteAlertConfirm') }}';
    var deleteAlertCancel = '{{ trans('public.cancel') }}';
    var deleteAlertSuccess = '{{ trans('public.success') }}';
    var deleteAlertFail = '{{ trans('public.fail') }}';
    var deleteAlertFailHint = '{{ trans('public.deleteAlertFailHint') }}';
    var deleteAlertSuccessHint = '{{ trans('public.deleteAlertSuccessHint') }}';
    var forbiddenRequestToastTitleLang = '{{ trans('public.forbidden_request_toast_lang') }}';
    var forbiddenRequestToastMsgLang = '{{ trans('public.forbidden_request_toast_msg_lang') }}';
    var priceInvalidHintLang = '{{ trans('update.price_invalid_hint') }}';
    var clearLang = '{{ trans('clear') }}';
    var requestSuccessLang = '{{ trans('public.request_success') }}';
    var saveSuccessLang = '{{ trans('webinars.success_store') }}';
    var requestFailedLang = '{{ trans('public.request_failed') }}';
    var oopsLang = '{{ trans('update.oops') }}';
    var somethingWentWrongLang = '{{ trans('update.something_went_wrong') }}';
    var loadingDataPleaseWaitLang = '{{ trans('update.loading_data,_please_wait') }}';
    var deleteRequestLang = '{{ trans('update.delete_request') }}';
    var deleteRequestTitleLang = '{{ trans('update.delete_request_title') }}';
    var deleteRequestDescriptionLang = '{{ trans('update.delete_request_description') }}';
    var requestDetailsLang = '{{ trans('update.request_details') }}';
    var sendRequestLang = '{{ trans('update.send_request') }}';
    var closeLang = '{{ trans('public.close') }}';
    var generatedContentLang = '{{ trans('update.generated_content') }}';
    var copyLang = '{{ trans('public.copy') }}';
    var doneLang = '{{ trans('public.done') }}';
    var jsCurrentCurrency = '{{ $currency }}';
    var defaultLocale = '{{ getDefaultLocale() }}';
    var appLocale = '{{ app()->getLocale() }}';
    var themeColorsMode = {};
</script>

<script defer type="text/javascript" src="/assets/design_1/js/app.min.js"></script>
<script defer src="{{ getDesign1ScriptPath("auth_theme_1") }}"></script>

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

<script defer src="/assets/design_1/js/parts/general.min.js"></script>
</body>
</html>
