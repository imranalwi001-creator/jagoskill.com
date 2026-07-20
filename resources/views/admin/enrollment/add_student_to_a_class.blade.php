@extends('admin.layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ $pageTitle }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}">{{trans('admin/main.dashboard')}}</a>
                </div>
                <div class="breadcrumb-item">{{ $pageTitle}}</div>
            </div>
        </div>

        <div class="section-body">

            <div class="row">
                <div class="col-12 col-md-8 col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ getAdminPanelUrl() }}/enrollments/store" method="post">
                                {{ csrf_field() }}

                                <div class="form-group">
                                    <label class="input-label">{{ trans('admin/main.student') }}</label>
                                    <select name="user_id" class="form-control search-user-select2" data-search-option="just_student_role" data-placeholder="{{ trans('public.search_user') }}">
                                    </select>
                                    @error('user_id')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="input-label">{{ trans('admin/main.class') }} ({{ trans('admin/main.course') }})</label>
                                    <select name="webinar_id" class="form-control search-webinar-select2" data-placeholder="{{ trans('admin/main.search_webinar') }}">
                                    </select>
                                    @error('webinar_id')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label class="input-label">{{ trans('update.bundle') }}</label>
                                    <select name="bundle_id" class="form-control search-bundle-select2" data-placeholder="{{ trans('update.search_bundle') }}">
                                    </select>
                                    @error('bundle_id')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="input-label">{{ trans('update.product') }}</label>
                                    <select name="product_id" class="form-control search-product-select2" data-placeholder="{{ trans('update.search_product') }}">
                                    </select>
                                    @error('product_id')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class=" mt-4">
                                    <button class="btn btn-primary">{{ trans('admin/main.submit') }}</button>
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

@endpush
