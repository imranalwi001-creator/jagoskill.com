@extends('admin.layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ $pageTitle }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}">{{ trans('admin/main.dashboard') }}</a></div>
                <div class="breadcrumb-item"><a href="{{ getAdminPanelUrl('/events') }}">{{ trans('update.events') }}</a></div>
                <div class="breadcrumb-item">{{ $pageTitle }}</div>
            </div>
        </div>

        <div class="section-body">
            <form method="post" action="{{ getAdminPanelUrl('/events/' . (!empty($event) ? $event->id . '/update' : 'store')) }}" enctype="multipart/form-data">
                {{ csrf_field() }}

                <div class="row">
                    <div class="col-12 col-lg-9">
                        <div class="card">
                            <div class="card-body">
                                @include('admin.events.create.includes.basic_information')
                                @include('admin.events.create.includes.additional_information')
                                @include('admin.events.create.includes.categories')
                            </div>
                        </div>

                        @if(!empty($event))
                            @include('admin.events.create.includes.tickets')
                            @include('admin.events.create.includes.speakers')
                            @include('admin.events.create.includes.prerequisites')
                            @include('admin.events.create.includes.faqs')
                            @include('admin.events.create.includes.extra_descriptions')
                        @endif
                    </div>

                    <div class="col-12 col-lg-3">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">{{ trans('admin/main.actions') }}</h5>
                            </div>

                            <div class="card-body">
                                <button type="submit" class="btn btn-primary btn-block mb-2">{{ trans('admin/main.save_change') }}</button>
                                <a href="{{ getAdminPanelUrl('/events') }}" class="btn btn-outline-primary btn-block">{{ trans('admin/main.list') }}</a>

                                @if(!empty($event))
                                    <a href="{{ $event->getUrl() }}" target="_blank" class="btn btn-outline-secondary btn-block mt-2">{{ trans('public.view') }}</a>
                                @endif
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">{{ trans('admin/main.status') }}</h5>
                            </div>

                            <div class="card-body">
                                <select name="status" class="form-control">
                                    @foreach(['publish', 'draft', 'pending', 'unpublish'] as $status)
                                        <option value="{{ $status }}" {{ ((!empty($event) ? $event->status : 'publish') == $status) ? 'selected' : '' }}>{{ trans("admin/main.{$status}") }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection

@push('scripts_bottom')
    <script src="/assets/design_1/js/panel/create_webinar.min.js"></script>
    <script src="/assets/design_1/js/panel/create_event.min.js"></script>
@endpush
