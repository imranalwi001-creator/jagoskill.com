@extends('admin.layouts.app')

@push('styles_top')
    <link href="/assets/default/vendors/sortable/jquery-ui.min.css" rel="stylesheet"/>
@endpush

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ trans('update.featured_products') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}">{{trans('admin/main.dashboard')}}</a></div>
                <div class="breadcrumb-item">{{ trans('update.featured_products') }}</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <form action="{{ getAdminPanelUrl() }}/settings/main" method="post">
                                {{ csrf_field() }}
                                <input type="hidden" name="page" value="general">
                                <input type="hidden" name="name" value="store_featured_products_settings">
                                <input type="hidden" name="locale" value="{{ getDefaultLocale() }}">

                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label class="input-label">{{ trans('update.products') }}</label>
                                            <select name="value[products][]" class="form-control search-product-select2" multiple="multiple" data-placeholder="{{ trans('update.search_product') }}">
                                                @if(!empty($settingValues) and !empty($settingValues['products']))
                                                    @foreach($settingValues['products'] as $productId)
                                                        @php
                                                            $product = \App\Models\Product::find($productId);
                                                        @endphp
                                                        @if(!empty($product))
                                                            <option value="{{ $product->id }}" selected>{{ $product->title }}</option>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <button class="btn btn-primary">{{ trans('admin/main.save_change') }}</button>
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
