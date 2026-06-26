@extends('admin.auth.auth_layout')

@section('content')
    @php
        $siteGeneralSettings = getGeneralSettings();
    @endphp

    <div class="p-2 text-center">
        <img src="{{ $siteGeneralSettings['logo'] ?? '' }}" alt="logo" width="150" class="mb-4" style="filter: brightness(0) invert(1);">

        <h4 class="font-weight-normal mb-2">{{ trans('admin/main.welcome') }} <span class="font-weight-bold">{{ $siteGeneralSettings['site_name'] ?? '' }}</span></h4>

        <p class="mb-4" style="color: #cdd5e2;">{{ trans('auth.admin_tagline') }}</p>

        <form method="POST" action="{{ getAdminPanelUrl() }}/login" class="needs-validation text-left" novalidate="">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group mb-4">
                <label for="email">{{ trans('auth.email') }}</label>
                <input id="email" type="email" value="{{ old('email') }}" class="form-control  @error('email')  is-invalid @enderror"
                       name="email" tabindex="1"
                       required autofocus>
                @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="form-group mb-4">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <label for="password" class="control-label mb-0">{{ trans('auth.password') }}</label>
                    <a href="{{ getAdminPanelUrl() }}/forget-password" tabindex="5" style="font-size: 12px;">{{ trans('auth.forget_your_password') }}</a>
                </div>
                <input id="password" type="password" class="form-control  @error('password')  is-invalid @enderror"
                       name="password" tabindex="2" required>
                @error('password')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            @if(!empty(getGeneralSecuritySettings('captcha_for_admin_login')))
                @include('admin.includes.captcha_input')
            @endif

            <div class="form-group mb-4">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" name="remember" class="custom-control-input" tabindex="3"
                           id="remember-me">
                    <label class="custom-control-label"
                           for="remember-me">{{ trans('auth.remember_me') }}</label>
                </div>
            </div>

            <div class="form-group mb-0">
                <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                    {{ trans('auth.login') }}
                </button>
            </div>
        </form>
    </div>
@endsection
