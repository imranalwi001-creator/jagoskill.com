@extends('admin.layouts.app')

@php
    $tabs = [
        'general' => trans('update.general'),
        'homepage' => trans('update.homepage'),
        'images' => trans('update.images'),
        'homepage_revolver' => trans('update.homepage_revolver'),
        'cta_section' => trans('update.cta_section'),
    ];

    $activeTab = $pageTab ?? 'general';
@endphp

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ $pageTitle }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}">{{ trans('admin/main.dashboard') }}</a></div>
                <div class="breadcrumb-item">{{ $pageTitle }}</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 col-lg-9">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">{{ trans('update.forum_settings') }}</h5>
                        </div>

                        <div class="card-body">
                            <ul class="nav nav-tabs mb-4" role="tablist">
                                @foreach($tabs as $tab => $label)
                                    <li class="nav-item">
                                        <a class="nav-link {{ $activeTab === $tab ? 'active' : '' }}"
                                           href="{{ getAdminPanelUrl('/forums/settings/' . $tab) }}{{ request()->has('locale') ? '?locale=' . request()->get('locale') : '' }}">
                                            {{ $label }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>

                            @includeIf("admin.forums.settings.tabs.{$activeTab}")
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-3">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">{{ trans('admin/main.actions') }}</h5>
                        </div>

                        <div class="card-body">
                            <a href="/forums" target="_blank" class="btn btn-primary btn-block mb-2">{{ trans('update.forums') }}</a>
                            <a href="{{ getAdminPanelUrl('/forums') }}" class="btn btn-outline-primary btn-block">{{ trans('admin/main.list') }}</a>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">{{ trans('admin/main.status') }}</h5>
                        </div>

                        <div class="card-body">
                            @php($forumEnabled = !empty(getForumsGeneralSettings('forums_status')))

                            @if($forumEnabled)
                                <div class="alert alert-success mb-0">{{ trans('update.forums') }} {{ trans('admin/main.active') }}</div>
                            @else
                                <div class="alert alert-warning mb-0">{{ trans('update.forums') }} {{ trans('admin/main.inactive') }}</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
