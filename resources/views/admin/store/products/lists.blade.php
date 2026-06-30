@extends('admin.layouts.app')

@push('libraries_top')
@endpush

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
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card-statistic">
                        <div class="card-statistic__mask"></div>
                        <div class="card-statistic__wrap">
                            <div class="d-flex align-items-start justify-content-between">
                                <span class="text-gray-500 mt-8">{{ trans('update.total_physical_products') }}</span>
                                <div class="d-flex-center size-48 bg-primary-30 rounded-12">
                                    <x-iconsax-bul-box class="icons text-primary" width="24px" height="24px"/>
                                </div>
                            </div>
                            <h5 class="font-24 mt-12 line-height-1 text-black">{{ $totalPhysicalProducts ?? 0 }}</h5>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card-statistic">
                        <div class="card-statistic__mask"></div>
                        <div class="card-statistic__wrap">
                            <div class="d-flex align-items-start justify-content-between">
                                <span class="text-gray-500 mt-8">{{ trans('update.total_virtual_products') }}</span>
                                <div class="d-flex-center size-48 bg-warning-30 rounded-12">
                                    <x-iconsax-bul-document-download class="icons text-warning" width="24px" height="24px"/>
                                </div>
                            </div>
                            <h5 class="font-24 mt-12 line-height-1 text-black">{{ $totalVirtualProducts ?? 0 }}</h5>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card-statistic">
                        <div class="card-statistic__mask"></div>
                        <div class="card-statistic__wrap">
                            <div class="d-flex align-items-start justify-content-between">
                                <span class="text-gray-500 mt-8">{{ trans('update.total_sellers') }}</span>
                                <div class="d-flex-center size-48 bg-accent-30 rounded-12">
                                    <x-iconsax-bul-profile-2user class="icons text-accent" width="24px" height="24px"/>
                                </div>
                            </div>
                            <h5 class="font-24 mt-12 line-height-1 text-black">{{ $totalSellers ?? 0 }}</h5>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card-statistic">
                        <div class="card-statistic__mask"></div>
                        <div class="card-statistic__wrap">
                            <div class="d-flex align-items-start justify-content-between">
                                <span class="text-gray-500 mt-8">{{ trans('update.total_buyers') }}</span>
                                <div class="d-flex-center size-48 bg-success-30 rounded-12">
                                    <x-iconsax-bul-shop class="icons text-success" width="24px" height="24px"/>
                                </div>
                            </div>
                            <h5 class="font-24 mt-12 line-height-1 text-black">{{ $totalBuyers ?? 0 }}</h5>
                        </div>
                    </div>
                </div>
            </div>

            <section class="card mt-32">
                <div class="card-body pb-4">
                    <form method="get" class="mb-0">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="input-label">{{ trans('admin/main.search') }}</label>
                                    <input name="title" type="text" class="form-control" value="{{ request()->get('title') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="input-label">{{ trans('admin/main.start_date') }}</label>
                                    <div class="input-group">
                                        <input type="date" id="from" class="text-center form-control" name="from" value="{{ request()->get('from') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="input-label">{{ trans('admin/main.end_date') }}</label>
                                    <div class="input-group">
                                        <input type="date" id="to" class="text-center form-control" name="to" value="{{ request()->get('to') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="input-label">{{ trans('admin/main.filters') }}</label>
                                    <select name="sort" class="form-control populate">
                                        <option value="">{{ trans('admin/main.filter_type') }}</option>
                                        <option value="has_discount" @if(request()->get('sort') == 'has_discount') selected @endif>{{ trans('admin/main.discounted_classes') }}</option>
                                        <option value="sales_asc" @if(request()->get('sort') == 'sales_asc') selected @endif>{{ trans('admin/main.sales_ascending') }}</option>
                                        <option value="sales_desc" @if(request()->get('sort') == 'sales_desc') selected @endif>{{ trans('admin/main.sales_descending') }}</option>
                                        <option value="price_asc" @if(request()->get('sort') == 'price_asc') selected @endif>{{ trans('admin/main.Price_ascending') }}</option>
                                        <option value="price_desc" @if(request()->get('sort') == 'price_desc') selected @endif>{{ trans('admin/main.Price_descending') }}</option>
                                        <option value="income_asc" @if(request()->get('sort') == 'income_asc') selected @endif>{{ trans('admin/main.Income_ascending') }}</option>
                                        <option value="income_desc" @if(request()->get('sort') == 'income_desc') selected @endif>{{ trans('admin/main.Income_descending') }}</option>
                                        <option value="created_at_asc" @if(request()->get('sort') == 'created_at_asc') selected @endif>{{ trans('admin/main.create_date_ascending') }}</option>
                                        <option value="created_at_desc" @if(request()->get('sort') == 'created_at_desc') selected @endif>{{ trans('admin/main.create_date_descending') }}</option>
                                        <option value="updated_at_asc" @if(request()->get('sort') == 'updated_at_asc') selected @endif>{{ trans('admin/main.update_date_ascending') }}</option>
                                        <option value="updated_at_desc" @if(request()->get('sort') == 'updated_at_desc') selected @endif>{{ trans('admin/main.update_date_descending') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="input-label">{{ trans('admin/main.instructor') }}</label>
                                    <select name="creator_ids[]" multiple="multiple" class="form-control search-user-select2" data-placeholder="{{ trans('public.search_user') }}">
                                        @if(!empty($creators) and $creators->count() > 0)
                                            @foreach($creators as $creator)
                                                <option value="{{ $creator->id }}" selected>{{ $creator->full_name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="input-label">{{ trans('admin/main.category') }}</label>
                                    <select name="category_id" class="form-control">
                                        <option value="">{{ trans('admin/main.all_categories') }}</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" @if(request()->get('category_id') == $category->id) selected @endif>{{ $category->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="input-label">{{ trans('admin/main.status') }}</label>
                                    <select name="status" class="form-control">
                                        <option value="">{{ trans('admin/main.all_status') }}</option>
                                        <option value="active" @if(request()->get('status') === 'active') selected @endif>{{ trans('admin/main.active') }}</option>
                                        <option value="pending" @if(request()->get('status') === 'pending') selected @endif>{{ trans('admin/main.pending') }}</option>
                                        <option value="inactive" @if(request()->get('status') === 'inactive') selected @endif>{{ trans('admin/main.inactive') }}</option>
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
                        <div class="card-header">
                            @if(empty($inHouseProducts))
                                <a href="{{ getAdminPanelUrl() }}/store/products/excel?{{ http_build_query(request()->all()) }}" class="btn btn-primary">{{ trans('admin/main.export_excel') }}</a>
                            @endif
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped font-14">
                                    <tr>
                                        <th>{{ trans('admin/main.id') }}</th>
                                        <th class="text-left">{{ trans('admin/main.title') }}</th>
                                        <th class="text-left">{{ trans('admin/main.instructor') }}</th>
                                        <th>{{ trans('admin/main.price') }}</th>
                                        <th>{{ trans('admin/main.sales') }}</th>
                                        <th>{{ trans('admin/main.income') }}</th>
                                        <th>{{ trans('admin/main.inventory') }}</th>
                                        <th>{{ trans('admin/main.status') }}</th>
                                        <th width="120">{{ trans('admin/main.actions') }}</th>
                                    </tr>
                                    @foreach($products as $product)
                                        <tr>
                                            <td>{{ $product->id }}</td>
                                            <td class="text-left">
                                                <a href="{{ $product->getUrl() }}" target="_blank">{{ $product->title }}</a>
                                                <div class="text-primary mt-1">{{ $product->category->title ?? '' }}</div>
                                            </td>
                                            <td class="text-left">{{ $product->creator->full_name ?? '' }}</td>
                                            <td>{{ handlePrice($product->price) }}</td>
                                            <td>{{ $product->sales()->count() }}</td>
                                            <td>{{ handlePrice($product->sales()->sum('total_amount')) }}</td>
                                            <td>
                                                @if($product->type == 'physical')
                                                    {{ $product->getAvailability() }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                @if($product->status == 'active')
                                                    <span class="text-success">{{ trans('admin/main.active') }}</span>
                                                @elseif($product->status == 'pending')
                                                    <span class="text-warning">{{ trans('admin/main.pending') }}</span>
                                                @else
                                                    <span class="text-danger">{{ trans('admin/main.inactive') }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ getAdminPanelUrl() }}/store/products/{{ $product->id }}/edit" class="btn-transparent text-primary" data-toggle="tooltip" data-placement="top" title="{{ trans('admin/main.edit') }}">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                @include('admin.includes.delete_button',['url' => getAdminPanelUrl().'/store/products/'.$product->id.'/delete'])
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            {{ $products->appends(request()->input())->links('vendor.pagination.bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts_bottom')
@endpush
