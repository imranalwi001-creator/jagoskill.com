@extends('admin.layouts.app')

@push('styles_top')
    <link rel="stylesheet" href="/assets/default/vendors/daterangepicker/daterangepicker.min.css">
@endpush

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ $pageTitle }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}">{{ trans('admin/main.dashboard') }}</a></div>
                <div class="breadcrumb-item"><a href="{{ getAdminPanelUrl() }}/store/discounts">{{ trans('admin/main.discounts') }}</a></div>
                <div class="breadcrumb-item">{{ $pageTitle }}</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-8 col-lg-6">
                            <form action="{{ getAdminPanelUrl() }}/store/discounts/{{ !empty($discount) ? $discount->id.'/update' : 'store' }}" method="Post">
                                {{ csrf_field() }}

                                <div class="form-group">
                                    <label class="input-label">{{ trans('update.product') }}</label>
                                    <select name="product_id" class="form-control search-product-select2 @error('product_id') is-invalid @enderror" data-placeholder="{{ trans('update.search_product') }}">
                                        @if(!empty($discount) and !empty($discount->product))
                                            <option value="{{ $discount->product->id }}" selected>{{ $discount->product->title }}</option>
                                        @endif
                                    </select>
                                    @error('product_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>{{ trans('admin/main.discount_percentage') }}</label>
                                    <input type="number" name="percent"
                                           class="form-control text-center @error('percent') is-invalid @enderror"
                                           value="{{ !empty($discount) ? $discount->percent : old('percent') }}"
                                           placeholder="0"/>
                                    @error('percent')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>{{ trans('admin/main.capacity') }}</label>
                                    <input type="number" name="count"
                                           class="form-control text-center @error('count') is-invalid @enderror"
                                           value="{{ !empty($discount) ? $discount->count : old('count') }}"
                                           placeholder="{{ trans('admin/main.discount_capacity_placeholder') }}"/>
                                    @error('count')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="input-label">{{ trans('admin/main.start_date') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="dateInputGroupPrepend">
                                                <i class="fa fa-calendar-alt"></i>
                                            </span>
                                        </div>
                                        <input type="text" name="start_date" class="form-control @error('start_date') is-invalid @enderror datetimepicker" aria-describedby="dateInputGroupPrepend" value="{{ !empty($discount) ? dateTimeFormat($discount->start_date, 'Y-m-d H:i', false) : old('start_date') }}"/>
                                        @error('start_date')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="input-label">{{ trans('admin/main.end_date') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="dateInputGroupPrepend">
                                                <i class="fa fa-calendar-alt"></i>
                                            </span>
                                        </div>
                                        <input type="text" name="end_date" class="form-control @error('end_date') is-invalid @enderror datetimepicker" aria-describedby="dateInputGroupPrepend" value="{{ !empty($discount) ? dateTimeFormat($discount->end_date, 'Y-m-d H:i', false) : old('end_date') }}"/>
                                        @error('end_date')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>{{ trans('admin/main.status') }}</label>
                                    <select name="status" class="form-control @error('status') is-invalid @enderror">
                                        <option value="active" {{ (!empty($discount) and $discount->status == 'active') ? 'selected' : '' }}>{{ trans('admin/main.active') }}</option>
                                        <option value="inactive" {{ (!empty($discount) and $discount->status == 'inactive') ? 'selected' : '' }}>{{ trans('admin/main.inactive') }}</option>
                                    </select>
                                    @error('status')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary">{{ trans('admin/main.save_change') }}</button>
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
@endpush
