@extends('admin.layouts.app')

@push('styles_top')
    <link rel="stylesheet" href="/assets/default/vendors/select2/select2.min.css">
    <link rel="stylesheet" href="/assets/default/vendors/daterangepicker/daterangepicker.min.css">
    <link rel="stylesheet" href="/assets/default/vendors/sortable/jquery-ui.min.css">
@endpush

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ $pageTitle }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}">{{trans('admin/main.dashboard')}}</a></div>
                <div class="breadcrumb-item"><a href="{{ getAdminPanelUrl() }}/forms">{{ trans('update.forms') }}</a></div>
                <div class="breadcrumb-item">{{ $pageTitle}}</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12">
                    <form action="{{ getAdminPanelUrl('/forms/' . (!empty($form) ? $form->id . '/update' : 'store')) }}" method="post">
                        {{ csrf_field() }}

                        <ul class="nav nav-pills" id="myTab3" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="basic-tab" data-toggle="tab" href="#basic" role="tab" aria-controls="basic" aria-selected="true">{{ trans('admin/main.basic_information') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="fields-tab" data-toggle="tab" href="#fields" role="tab" aria-controls="fields" aria-selected="false">{{ trans('update.form_fields') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="welcome-tab" data-toggle="tab" href="#welcome" role="tab" aria-controls="welcome" aria-selected="false">{{ trans('update.welcome_message') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="thankyou-tab" data-toggle="tab" href="#thankyou" role="tab" aria-controls="thankyou" aria-selected="false">{{ trans('update.thank_you_message') }}</a>
                            </li>
                        </ul>

                        <div class="tab-content" id="myTabContent2">
                            <div class="tab-pane mt-3 fade show active" id="basic" role="tabpanel" aria-labelledby="basic-tab">
                                @include('admin.forms.create.includes.basic_information')
                            </div>
                            
                            <div class="tab-pane mt-3 fade" id="fields" role="tabpanel" aria-labelledby="fields-tab">
                                @include('admin.forms.create.includes.form_fields')
                            </div>

                            <div class="tab-pane mt-3 fade" id="welcome" role="tabpanel" aria-labelledby="welcome-tab">
                                @include('admin.forms.create.includes.welcome_message')
                            </div>

                            <div class="tab-pane mt-3 fade" id="thankyou" role="tabpanel" aria-labelledby="thankyou-tab">
                                @include('admin.forms.create.includes.tank_you_message')
                            </div>
                        </div>

                        <div class="mt-4">
                            <button class="btn btn-primary">{{ trans('admin/main.submit') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts_bottom')
    <script src="/assets/default/vendors/select2/select2.min.js"></script>
    <script src="/assets/default/vendors/daterangepicker/daterangepicker.min.js"></script>
    <script src="/assets/default/vendors/sortable/jquery-ui.min.js"></script>
@endpush
