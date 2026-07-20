@extends('admin.layouts.app')

@push('styles_top')
    <link rel="stylesheet" href="/assets/default/vendors/select2/select2.min.css">
    <link rel="stylesheet" href="/assets/default/vendors/daterangepicker/daterangepicker.min.css">
@endpush

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ $pageTitle }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}">{{trans('admin/main.dashboard')}}</a></div>
                <div class="breadcrumb-item"><a href="{{ getAdminPanelUrl() }}/cashback/rules">{{ trans('update.cashback_rules') }}</a></div>
                <div class="breadcrumb-item">{{ $pageTitle}}</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12">
                    <form action="{{ getAdminPanelUrl('/cashback/rules/' . (!empty($rule) ? $rule->id . '/update' : 'store')) }}" method="post">
                        {{ csrf_field() }}

                        <ul class="nav nav-pills" id="myTab3" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="basic-tab" data-toggle="tab" href="#basic" role="tab" aria-controls="basic" aria-selected="true">{{ trans('admin/main.basic_information') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="target-tab" data-toggle="tab" href="#target" role="tab" aria-controls="target" aria-selected="false">{{ trans('update.target_products') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="payment-tab" data-toggle="tab" href="#payment" role="tab" aria-controls="payment" aria-selected="false">{{ trans('admin/main.payment') }}</a>
                            </li>
                        </ul>

                        <div class="tab-content" id="myTabContent2">
                            <div class="tab-pane mt-3 fade show active" id="basic" role="tabpanel" aria-labelledby="basic-tab">
                                @include('admin.cashback.rules.create.includes.basic_information')
                            </div>
                            
                            <div class="tab-pane mt-3 fade" id="target" role="tabpanel" aria-labelledby="target-tab">
                                @include('admin.cashback.rules.create.includes.target_products')
                            </div>

                            <div class="tab-pane mt-3 fade" id="payment" role="tabpanel" aria-labelledby="payment-tab">
                                @include('admin.cashback.rules.create.includes.payment')
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
@endpush
