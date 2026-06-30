@extends('admin.layouts.app')

@push('styles_top')
    <link rel="stylesheet" href="/assets/default/vendors/daterangepicker/daterangepicker.min.css">
    <link rel="stylesheet" href="/assets/default/vendors/bootstrap-tagsinput/bootstrap-tagsinput.min.css">
    <link rel="stylesheet" href="/assets/vendors/summernote/summernote-bs4.min.css">
    <link href="/assets/default/vendors/sortable/jquery-ui.min.css" rel="stylesheet">
@endpush

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ $pageTitle }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}">{{ trans('admin/main.dashboard') }}</a></div>
                <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}/store/products">{{ trans('update.products') }}</a></div>
                <div class="breadcrumb-item">{{ $pageTitle }}</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form method="post" action="{{ getAdminPanelUrl() }}/store/products/{{ !empty($product) ? $product->id.'/update' : 'store' }}" id="productForm" class="product-form" enctype="multipart/form-data">
                                {{ csrf_field() }}

                                @include('admin.store.products.create.basic_information')
                                @include('admin.store.products.create.extra_information')
                                @include('admin.store.products.create.image_and_files')
                                @include('admin.store.products.create.category_and_specification')

                                <div class="mt-20 mb-20">
                                    <button type="submit" class="btn btn-sm btn-primary">{{ trans('public.save') }}</button>

                                    @if(!empty($product))
                                        <button class="btn btn-sm btn-danger ml-10 delete-action" data-confirm-text="{{ trans('public.confirm_delete') }}" type="button" data-action="{{ getAdminPanelUrl() }}/store/products/{{ $product->id }}/delete">{{ trans('public.delete') }}</button>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('admin.store.products.create.modals.file_modal')
    @include('admin.store.products.create.modals.file_description_modal')
    @include('admin.store.products.create.relatedProducts.related_product_modal')

@endsection

@push('scripts_bottom')
    <script>
        var saveSuccessLang = '{{ trans('webinars.success_store') }}';
    </script>
    <script src="/assets/default/vendors/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>
    <script src="/assets/vendors/summernote/summernote-bs4.min.js"></script>
    <script src="/assets/default/vendors/sortable/jquery-ui.min.js"></script>
@endpush
