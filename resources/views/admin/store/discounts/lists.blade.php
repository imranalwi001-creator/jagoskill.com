@extends('admin.layouts.app')

@push('libraries_top')
@endpush

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ trans('admin/main.discounts') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}">{{trans('admin/main.dashboard')}}</a></div>
                <div class="breadcrumb-item">{{ trans('admin/main.discounts') }}</div>
            </div>
        </div>

        <div class="section-body">
            <section class="card">
                <div class="card-body">
                    <form method="get" class="mb-0">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="input-label">{{ trans('admin/main.search') }}</label>
                                    <input name="name" type="text" class="form-control" value="{{ request()->get('name') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="input-label">{{ trans('admin/main.start_date') }}</label>
                                    <div class="input-group">
                                        <input type="date" id="from" class="text-center form-control" name="from" value="{{ request()->get('from') }}" placeholder="Start Date">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="input-label">{{ trans('admin/main.end_date') }}</label>
                                    <div class="input-group">
                                        <input type="date" id="to" class="text-center form-control" name="to" value="{{ request()->get('to') }}" placeholder="End Date">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="input-label">{{ trans('update.product') }}</label>
                                    <select name="product_ids[]" multiple="multiple" class="form-control search-product-select2" data-placeholder="{{ trans('update.search_product') }}">
                                        @if(!empty($products) and $products->count() > 0)
                                            @foreach($products as $product)
                                                <option value="{{ $product->id }}" selected>{{ $product->title }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="input-label">{{ trans('admin/main.status') }}</label>
                                    <select name="status" class="form-control">
                                        <option value="">{{ trans('admin/main.all_status') }}</option>
                                        <option value="active" @if(request()->get('status') == 'active') selected @endif>{{ trans('admin/main.active') }}</option>
                                        <option value="inactive" @if(request()->get('status') == 'inactive') selected @endif>{{ trans('admin/main.inactive') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mt-1">
                                    <label class="input-label mb-4"> </label>
                                    <input type="submit" class="text-center btn btn-primary w-100" value="{{ trans('admin/main.show_results') }}">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </section>

            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="card">
                        <div class="card-header justify-content-between">
                            <div>
                                <h5 class="font-14 mb-0">{{ $pageTitle }}</h5>
                                <p class="font-12 mt-4 mb-0 text-gray-500">{{ trans('update.manage_all_items_in_a_single_place') }}</p>
                            </div>
                            <div class="d-flex align-items-center gap-12">
                                <a href="{{ getAdminPanelUrl() }}/store/discounts/create" class="btn btn-primary">
                                    <i class="fa fa-plus"></i>
                                    <span class="ml-4">{{ trans('admin/main.new') }}</span>
                                </a>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table custom-table font-14">
                                    <tr>
                                        <th class="text-left">{{ trans('update.product') }}</th>
                                        <th>{{ trans('admin/main.discount_percentage') }}</th>
                                        <th>{{ trans('admin/main.capacity') }}</th>
                                        <th>{{ trans('admin/main.start_date') }}</th>
                                        <th>{{ trans('admin/main.end_date') }}</th>
                                        <th>{{ trans('admin/main.status') }}</th>
                                        <th>{{ trans('admin/main.action') }}</th>
                                    </tr>
                                    @foreach($discounts as $discount)
                                        <tr>
                                            <td class="text-left">
                                                @if(!empty($discount->product))
                                                    <a href="{{ $discount->product->getUrl() }}" target="_blank">{{ $discount->product->title }}</a>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>{{ $discount->percent }}%</td>
                                            <td>{{ $discount->count ?? trans('update.unlimited') }}</td>
                                            <td>{{ dateTimeFormat($discount->start_date, 'Y/m/d H:i:s') }}</td>
                                            <td>{{ dateTimeFormat($discount->end_date, 'Y/m/d H:i:s') }}</td>
                                            <td>
                                                <span class="text-{{ ($discount->status == 'active') ? 'success' : 'danger' }}">
                                                    {{ trans('admin/main.'.$discount->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group dropdown table-actions position-relative">
                                                    <button type="button" class="btn-transparent dropdown-toggle" data-toggle="dropdown">
                                                        <i class="fa fa-ellipsis-v"></i>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a href="{{ getAdminPanelUrl() }}/store/discounts/{{ $discount->id }}/edit" class="dropdown-item">{{ trans('admin/main.edit') }}</a>
                                                        <a href="{{ getAdminPanelUrl() }}/store/discounts/{{ $discount->id }}/delete" class="dropdown-item text-danger delete-action" data-confirm-text="{{ trans('public.confirm_delete') }}">{{ trans('admin/main.delete') }}</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>

                        <div class="card-footer text-center">
                            {{ $discounts->appends(request()->input())->links('vendor.pagination.bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts_bottom')
@endpush
