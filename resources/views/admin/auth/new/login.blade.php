@extends('admin.auth.new.layout')

@php
    $siteGeneralSettings = getGeneralSettings();
@endphp

@section('content')
    <div class="text-left mb-4">
        <h1 class="font-28 font-weight-bold mb-2 text-white" style="font-family: 'Outfit', sans-serif;">{{ trans('admin/main.login') }}</h1>
        <p class="font-14 text-muted mb-0" style="font-family: 'Outfit', sans-serif;">{{ trans('update.login_to_your_account_and_manage_everything') }}</p>
    </div>

    <form method="POST" action="{{ getAdminPanelUrl("/login") }}" class="mt-4" novalidate>
        {{ csrf_field() }}

        <!-- Email Field -->
        <div class="auth-input-group">
            <label class="auth-label" for="admin_email">{{ trans('public.email') }}</label>
            <input id="admin_email" type="email" name="email" value="{{ old('email') }}" class="auth-input @error('email') is-invalid @enderror" autocomplete="email" required autofocus placeholder="name@jagoskill.com">

            @error('email')
            <div class="invalid-feedback d-block mt-1">
                {{ $message }}
            </div>
            @enderror
        </div>

        <!-- Password Field -->
        <div class="auth-input-group position-relative">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <label class="auth-label mb-0" for="admin_password">{{ trans('auth.password') }}</label>
                <a href="{{ getAdminPanelUrl("/forget-password") }}" class="admin-auth-forgot">{{ trans('auth.forget_your_password') }}</a>
            </div>
            <div class="position-relative">
                <input id="admin_password" name="password" type="password" class="auth-input @error('password') is-invalid @enderror" autocomplete="current-password" required placeholder="••••••••">

                <div class="password-input-visibility cursor-pointer size-24">
                    <x-iconsax-lin-eye-slash class="icons-eye-slash text-gray-400 d-none" width="24px" height="24px"/>
                    <x-iconsax-lin-eye class="icons-eye text-gray-400" width="24px" height="24px"/>
                </div>
            </div>

            @error('password')
            <div class="invalid-feedback d-block mt-1">
                {{ $message }}
            </div>
            @enderror
        </div>

        @if(!empty(getGeneralSecuritySettings('captcha_for_admin_login')))
            <div class="mt-4">
                @include('design_1.web.includes.captcha_input')
            </div>
        @endif

        <!-- Remember me checkbox -->
        <div class="auth-checkbox-group mt-3">
            <input type="checkbox" name="remember" id="rememberSwitch" class="auth-checkbox-input">
            <label class="auth-checkbox-label cursor-pointer" for="rememberSwitch">{{ trans('auth.remember_me') }}</label>
        </div>

        <button type="submit" class="btn btn-primary btn-xlg btn-block mt-4">{{ trans('auth.login') }}</button>
    </form>
@endsection
