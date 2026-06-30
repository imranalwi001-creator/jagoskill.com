@extends('admin.layouts.app')

@push('styles_top')
    <link rel="stylesheet" href="/assets/default/vendors/daterangepicker/daterangepicker.min.css">
    <link rel="stylesheet" href="/assets/default/vendors/bootstrap-timepicker/bootstrap-timepicker.min.css">
    <link rel="stylesheet" href="/assets/default/vendors/bootstrap-tagsinput/bootstrap-tagsinput.min.css">
    <link rel="stylesheet" href="/assets/default/vendors/summernote/summernote-bs4.min.css">
    <link href="/assets/default/vendors/sortable/jquery-ui.min.css"/>
    <style>
        .bootstrap-timepicker-widget table td input {
            width: 35px !important;
        }
        .select2-container {
            z-index: 1212 !important;
        }
    </style>
@endpush

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ !empty($upcomingCourse) ? trans('admin/main.edit') : trans('admin/main.new') }} {{ trans('update.upcoming_course') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}">{{ trans('admin/main.dashboard') }}</a></div>
                <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}/upcoming_courses">{{ trans('update.upcoming_courses') }}</a></div>
                <div class="breadcrumb-item">{{ !empty($upcomingCourse) ? trans('admin/main.edit') : trans('admin/main.new') }}</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <!-- Nav Tabs -->
                            <ul class="nav nav-pills" id="upcomingCourseTabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="basic-tab" data-toggle="tab" href="#basic" role="tab">{{ trans('public.basic_information') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ empty($upcomingCourse) ? 'disabled' : '' }}" id="extra-tab" data-toggle="tab" href="#extra" role="tab">{{ trans('public.additional_information') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ empty($upcomingCourse) ? 'disabled' : '' }}" id="extra-desc-tab" data-toggle="tab" href="#extra-desc" role="tab">{{ trans('update.extra_descriptions') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ empty($upcomingCourse) ? 'disabled' : '' }}" id="faq-tab" data-toggle="tab" href="#faq" role="tab">{{ trans('public.faq') }}</a>
                                </li>
                            </ul>

                            <form action="{{ getAdminPanelUrl() }}/upcoming_courses/{{ !empty($upcomingCourse) ? $upcomingCourse->id.'/update' : 'store' }}" method="post" id="upcomingCourseForm" class="mt-4">
                                {{ csrf_field() }}

                                <div class="tab-content" id="upcomingCourseTabsContent">
                                    <!-- Tab 1: Basic Info -->
                                    <div class="tab-pane fade show active" id="basic" role="tabpanel">
                                        @include('admin.upcoming_courses.create.includes.basic_information')
                                    </div>

                                    @if(!empty($upcomingCourse))
                                        <!-- Tab 2: Additional Info -->
                                        <div class="tab-pane fade" id="extra" role="tabpanel">
                                            @include('admin.upcoming_courses.create.includes.additional_information')
                                        </div>

                                        <!-- Tab 3: Extra Descriptions -->
                                        <div class="tab-pane fade" id="extra-desc" role="tabpanel">
                                            @include('admin.upcoming_courses.create.includes.extraDescription')
                                        </div>

                                        <!-- Tab 4: FAQ -->
                                        <div class="tab-pane fade" id="faq" role="tabpanel">
                                            @include('admin.upcoming_courses.create.includes.faq')
                                        </div>
                                    @endif
                                </div>

                                <div class="text-right mt-4 col-12 col-md-8">
                                    <button type="submit" class="btn btn-primary">{{ trans('admin/main.submit') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts_bottom')
    <script src="/assets/default/vendors/daterangepicker/daterangepicker.min.js"></script>
    <script src="/assets/default/vendors/bootstrap-timepicker/bootstrap-timepicker.min.js"></script>
    <script src="/assets/default/vendors/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>
    <script src="/assets/default/vendors/summernote/summernote-bs4.min.js"></script>
    <script src="/assets/default/vendors/sortable/jquery-ui.min.js"></script>
    <script src="/assets/default/js/admin/webinar_create.min.js"></script>
@endpush
