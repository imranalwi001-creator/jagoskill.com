@extends('admin.layouts.app')

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
            <div class="card">
                <div class="card-body">
                    @include('admin.includes.no-result',[
                        'file_name' => 'webinar.png',
                        'title' => $pageTitle,
                        'hint' => 'This feature is active. Use the list page and available actions to manage existing data safely.',
                        'btn' => [
                            'url' => url()->previous(),
                            'text' => trans('public.back'),
                        ],
                    ])
                </div>
            </div>
        </div>
    </section>
@endsection
