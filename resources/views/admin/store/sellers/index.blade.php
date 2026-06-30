@extends('admin.layouts.app')

@push('libraries_top')

@endpush

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ trans('update.products_sellers') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}">{{trans('admin/main.dashboard')}}</a></div>
                <div class="breadcrumb-item">{{ trans('update.products_sellers') }}</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    <form method="get" class="mb-0">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="input-label">{{ trans('admin/main.search') }}</label>
                                    <input type="text" class="form-control" name="full_name" value="{{ request()->get('full_name') }}">
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
                                    <label class="input-label">{{ trans('admin/main.user_group') }}</label>
                                    <select name="group_id" class="form-control">
                                        <option value="">{{ trans('admin/main.all_groups') }}</option>
                                        @foreach($userGroups as $userGroup)
                                            <option value="{{ $userGroup->id }}" @if(request()->get('group_id') == $userGroup->id) selected @endif>{{ $userGroup->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="input-label">{{ trans('admin/main.status') }}</label>
                                    <select name="status" class="form-control">
                                        <option value="">{{ trans('admin/main.all_status') }}</option>
                                        <option value="active" @if(request()->get('status') == 'active') selected @endif>{{ trans('admin/main.active') }}</option>
                                        <option value="pending" @if(request()->get('status') == 'pending') selected @endif>{{ trans('admin/main.pending') }}</option>
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
            </div>

            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="card">
                        <div class="card-header justify-content-between">
                            <div>
                                <h5 class="font-14 mb-0">{{ trans('update.products_sellers') }}</h5>
                                <p class="font-12 mt-4 mb-0 text-gray-500">{{ trans('update.manage_all_items_in_a_single_place') }}</p>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table custom-table font-14">
                                    <tr>
                                        <th>{{ trans('admin/main.user') }}</th>
                                        <th class="text-center">{{ trans('update.total_products') }}</th>
                                        <th class="text-center">{{ trans('update.physical_products') }}</th>
                                        <th class="text-center">{{ trans('update.virtual_products') }}</th>
                                        <th class="text-center">{{ trans('update.pending_orders') }}</th>
                                        <th class="text-center">{{ trans('admin/main.total_sales') }}</th>
                                        <th class="text-center">{{ trans('update.physical_sales') }}</th>
                                        <th class="text-center">{{ trans('update.virtual_sales') }}</th>
                                        <th class="text-center">{{ trans('admin/main.status') }}</th>
                                        <th>{{ trans('admin/main.action') }}</th>
                                    </tr>

                                    @foreach($users as $user)
                                        <tr>
                                            <td class="text-left">
                                                <div class="d-flex align-items-center">
                                                    <figure class="avatar mr-2">
                                                        <img src="{{ $user->getAvatar() }}" alt="{{ $user->full_name }}">
                                                    </figure>
                                                    <div class="media-body ml-1">
                                                        <div class="mt-0 mb-1 font-weight-bold">{{ $user->full_name }}</div>
                                                        <div class="text-primary text-small font-600-bold">{{ $user->mobile }}</div>
                                                    </div>
                                                </div>
                                            </td>

                                            <td class="text-center">{{ $user->virtual_products_count + $user->physical_products_count }}</td>
                                            <td class="text-center">{{ $user->physical_products_count }}</td>
                                            <td class="text-center">{{ $user->virtual_products_count }}</td>
                                            <td class="text-center">{{ $user->pending_orders_count }}</td>
                                            <td class="text-center">{{ handlePrice($user->total_sales) }}</td>
                                            <td class="text-center">{{ handlePrice($user->physical_products_sales) }}</td>
                                            <td class="text-center">{{ handlePrice($user->virtual_products_sales) }}</td>

                                            <td class="text-center">
                                                @if($user->status == 'active')
                                                    <span class="text-success">{{ trans('admin/main.active') }}</span>
                                                @elseif($user->status == 'pending')
                                                    <span class="text-warning">{{ trans('admin/main.pending') }}</span>
                                                @else
                                                    <span class="text-danger">{{ trans('admin/main.inactive') }}</span>
                                                @endif
                                            </td>

                                            <td>
                                                <div class="btn-group dropdown table-actions position-relative">
                                                    <button type="button" class="btn-transparent dropdown-toggle" data-toggle="dropdown">
                                                        <i class="fa fa-ellipsis-v"></i>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a href="{{ getAdminPanelUrl() }}/users/{{ $user->id }}/edit" class="dropdown-item">{{ trans('admin/main.edit') }}</a>
                                                        <a href="{{ getAdminPanelUrl() }}/users/{{ $user->id }}/delete" class="dropdown-item text-danger delete-action" data-confirm-text="{{ trans('public.confirm_delete') }}">{{ trans('admin/main.delete') }}</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>

                        <div class="card-footer text-center">
                            {{ $users->appends(request()->input())->links('vendor.pagination.bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
