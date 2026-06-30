@extends('admin.layouts.app')

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
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="card-statistic"><div class="card-statistic__wrap"><span class="text-gray-500">{{ trans('update.total_bundles') }}</span><h5 class="font-24 mt-12 text-black">{{ $totalBundles }}</h5></div></div>
                </div>
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="card-statistic"><div class="card-statistic__wrap"><span class="text-gray-500">{{ trans('update.pending_bundles') }}</span><h5 class="font-24 mt-12 text-black">{{ $totalPendingBundles }}</h5></div></div>
                </div>
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="card-statistic"><div class="card-statistic__wrap"><span class="text-gray-500">{{ trans('admin/main.sales') }}</span><h5 class="font-24 mt-12 text-black">{{ handlePrice($totalSales->total_amount ?? 0) }}</h5></div></div>
                </div>
            </div>

            <section class="card mt-32">
                <div class="card-body pb-4">
                    <form method="get" class="mb-0">
                        <div class="row">
                            <div class="col-md-3"><div class="form-group"><label class="input-label">{{ trans('admin/main.search') }}</label><input name="title" type="text" class="form-control" value="{{ request()->get('title') }}"></div></div>
                            <div class="col-md-3"><div class="form-group"><label class="input-label">{{ trans('admin/main.start_date') }}</label><input name="from" type="date" class="form-control text-center" value="{{ request()->get('from') }}"></div></div>
                            <div class="col-md-3"><div class="form-group"><label class="input-label">{{ trans('admin/main.end_date') }}</label><input name="to" type="date" class="form-control text-center" value="{{ request()->get('to') }}"></div></div>
                            <div class="col-md-3"><div class="form-group"><label class="input-label">{{ trans('admin/main.status') }}</label><select name="status" class="form-control"><option value="">{{ trans('admin/main.all') }}</option>@foreach([\App\Models\Bundle::$active, \App\Models\Bundle::$pending, \App\Models\Bundle::$isDraft] as $status)<option value="{{ $status }}" {{ request()->get('status') == $status ? 'selected' : '' }}>{{ trans('admin/main.'.$status) }}</option>@endforeach</select></div></div>
                            <div class="col-md-3"><div class="form-group"><label class="input-label">{{ trans('admin/main.category') }}</label><select name="category_id" class="form-control"><option value="">{{ trans('admin/main.all') }}</option>@foreach($categories as $category)<option value="{{ $category->id }}" {{ request()->get('category_id') == $category->id ? 'selected' : '' }}>{{ $category->title }}</option>@endforeach</select></div></div>
                            <div class="col-md-3 d-flex align-items-center"><button type="submit" class="btn btn-primary btn-block btn-lg">{{ trans('admin/main.show_results') }}</button></div>
                        </div>
                    </form>
                </div>
            </section>

            <div class="card mt-32">
                <div class="card-header justify-content-between">
                    <div><h5 class="font-14 mb-0">{{ trans('update.bundles') }}</h5><p class="font-12 mt-4 mb-0 text-gray-500">{{ trans('update.manage_all_items_in_a_single_place') }}</p></div>
                    @can('admin_bundles_create')<a href="{{ getAdminPanelUrl('/bundles/create') }}" class="btn btn-primary">{{ trans('admin/main.new') }}</a>@endcan
                </div>
                <div class="card-body">
                    @if(!empty($bundles) and $bundles->count())
                        <div class="table-responsive">
                            <table class="table custom-table font-14">
                                <tr><th class="text-left">{{ trans('update.bundle') }}</th><th>{{ trans('admin/main.instructor') }}</th><th>{{ trans('admin/main.category') }}</th><th>{{ trans('product.courses') }}</th><th>{{ trans('admin/main.sales') }}</th><th>{{ trans('admin/main.status') }}</th><th>{{ trans('admin/main.actions') }}</th></tr>
                                @foreach($bundles as $bundle)
                                    <tr class="text-center">
                                        <td class="text-left"><a href="{{ $bundle->getUrl() }}" target="_blank" class="text-dark font-weight-bold">{{ $bundle->title }}</a><span class="d-block font-12 text-gray-500 mt-4">{{ dateTimeFormat($bundle->created_at, 'j M Y') }}</span></td>
                                        <td>{{ !empty($bundle->teacher) ? $bundle->teacher->full_name : '-' }}</td>
                                        <td>{{ !empty($bundle->category) ? $bundle->category->title : '-' }}</td>
                                        <td>{{ $bundle->bundle_webinars_count ?? 0 }}</td>
                                        <td>{{ handlePrice($bundle->sales->sum('total_amount') ?? 0) }}</td>
                                        <td><span class="badge {{ $bundle->status == 'active' ? 'badge-primary' : 'badge-warning' }}">{{ trans('admin/main.'.$bundle->status) }}</span></td>
                                        <td>
                                            <div class="btn-group dropdown table-actions position-relative">
                                                <button type="button" class="btn-transparent dropdown-toggle" data-toggle="dropdown"><x-iconsax-lin-more class="icons text-gray-500" width="20px" height="20px"/></button>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    @can('admin_bundles_edit')<a href="{{ getAdminPanelUrl("/bundles/{$bundle->id}/edit") }}" class="dropdown-item d-flex align-items-center py-3 px-0 gap-4"><x-iconsax-lin-edit-2 class="icons text-gray-500" width="18px" height="18px"/><span class="text-gray-500 font-14">{{ trans('admin/main.edit') }}</span></a>@endcan
                                                    @can('admin_bundles_students')<a href="{{ getAdminPanelUrl("/bundles/{$bundle->id}/students") }}" class="dropdown-item d-flex align-items-center py-3 px-0 gap-4"><x-iconsax-lin-profile-2user class="icons text-gray-500" width="18px" height="18px"/><span class="text-gray-500 font-14">{{ trans('admin/main.students') }}</span></a>@endcan
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                        <div class="card-footer text-center">{{ $bundles->appends(request()->input())->links() }}</div>
                    @else
                        @include('admin.includes.no-result',['file_name' => 'webinar.png','title' => trans('update.bundles'),'hint' => trans('update.no_result_default_hint')])
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
