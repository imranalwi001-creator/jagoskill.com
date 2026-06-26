@extends('admin.auth.new.layout')

@php
    $siteGeneralSettings = getGeneralSettings();
@endphp

@section('content')
    <div class="d-flex-center flex-column text-center">
        <div class="mb-16">
            <img src="{{ $siteGeneralSettings['logo'] ?? '' }}" alt="logo" class="admin-auth-logo" width="150" height="58" loading="eager" decoding="async">
        </div>

        <h1 class="font-24 mt-12 mb-8">{{ trans('update.welcome_back_to_site!', ['site' => $siteGeneralSettings['site_name'] ?? '']) }}</h1>
        <p class="font-14 admin-auth-muted mb-0">{{ trans('update.login_to_your_account_and_manage_everything') }}</p>
    </div>

    <form method="POST" action="{{ getAdminPanelUrl("/login") }}" class="mt-28" novalidate>
        {{ csrf_field() }}

        <div class="form-group mb-4">
            <label class="form-group-label" for="admin_email">{{ trans('public.email') }}</label>
            <input id="admin_email" type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" autocomplete="email" required autofocus>

            @error('email')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="form-group position-relative mb-4">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <label class="form-group-label mb-0" for="admin_password">{{ trans('auth.password') }}</label>
                <a href="{{ getAdminPanelUrl("/forget-password") }}" class="admin-auth-forgot">{{ trans('auth.forget_your_password') }}</a>
            </div>
            <input id="admin_password" name="password" type="password" class="form-control @error('password') is-invalid @enderror" autocomplete="current-password" required>

            <div class="password-input-visibility cursor-pointer size-24">
                <x-iconsax-lin-eye-slash class="icons-eye-slash text-gray-400 d-none" width="24px" height="24px"/>
                <x-iconsax-lin-eye class="icons-eye text-gray-400 " width="24px" height="24px"/>
            </div>

            @error('password')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>

        @if(!empty(getGeneralSecuritySettings('captcha_for_admin_login')))
            <div class="mt-28 ">
                @include('design_1.web.includes.captcha_input')
            </div>
        @endif


        <div class="custom-control custom-checkbox mt-20 admin-auth-muted">
            <input type="checkbox" name="remember" id="rememberSwitch" class="custom-control-input">
            <label class="custom-control__label cursor-pointer" for="rememberSwitch">{{ trans('auth.remember_me') }}</label>
        </div>

        <button type="submit" class="btn btn-primary btn-xlg btn-block mt-24">{{ trans('auth.login') }}</button>
    </form>
@endsection
