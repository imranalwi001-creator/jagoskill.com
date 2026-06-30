@extends('admin.layouts.app')

@push('libraries_top')
@endpush

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ trans('update.orders_lists') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}">{{trans('admin/main.dashboard')}}</a></div>
                <div class="breadcrumb-item">{{ trans('update.orders_lists') }}</div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>{{trans('admin/main.total_sales')}}</h4>
                        </div>
                        <div class="card-body">
                            {{ $totalOrders['count'] }}
                        </div>
                        <div class="text-primary font-weight-bold font-14 mt-1">
                            {{ handlePrice($totalOrders['amount']) }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-success">
                        <i class="fas fa-check"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>{{trans('update.success_orders')}}</h4>
                        </div>
                        <div class="card-body">
                            {{ $successOrders['count'] }}
                        </div>
                        <div class="text-success font-weight-bold font-14 mt-1">
                            {{ handlePrice($successOrders['amount']) }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-danger">
                        <i class="fas fa-times"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>{{trans('update.canceled_orders')}}</h4>
                        </div>
                        <div class="card-body">
                            {{ $canceledOrders['count'] }}
                        </div>
                        <div class="text-danger font-weight-bold font-14 mt-1">
                            {{ handlePrice($canceledOrders['amount']) }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-warning">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>{{trans('update.waiting_orders')}}</h4>
                        </div>
                        <div class="card-body">
                            {{ $waitingOrders['count'] }}
                        </div>
                        <div class="text-warning font-weight-bold font-14 mt-1">
                            {{ handlePrice($waitingOrders['amount']) }}
                        </div>
                    </div>
                </div>
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
                                    <input name="item_title" type="text" class="form-control" value="{{ request()->get('item_title') }}">
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
                                    <label class="input-label">{{ trans('admin/main.status') }}</label>
                                    <select name="status" class="form-control">
                                        <option value="">{{ trans('admin/main.all_status') }}</option>
                                        <option value="success" @if(request()->get('status') == 'success') selected @endif>{{ trans('admin/main.success') }}</option>
                                        <option value="canceled" @if(request()->get('status') == 'canceled') selected @endif>{{ trans('admin/main.canceled') }}</option>
                                        <option value="waiting_delivery" @if(request()->get('status') == 'waiting_delivery') selected @endif>{{ trans('update.waiting_delivery') }}</option>
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
                                <h5 class="font-14 mb-0">{{ trans('update.orders_lists') }}</h5>
                                <p class="font-12 mt-4 mb-0 text-gray-500">{{ trans('update.manage_all_items_in_a_single_place') }}</p>
                            </div>
                            <div class="d-flex align-items-center gap-12">
                                <a href="{{ getAdminPanelUrl() }}/store/orders/export" class="btn btn-primary">{{ trans('admin/main.export_xls') }}</a>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table custom-table font-14">
                                    <tr>
                                        <th class="text-left">{{ trans('admin/main.product') }}</th>
                                        <th class="text-left">{{ trans('admin/main.seller') }}</th>
                                        <th class="text-left">{{ trans('admin/main.buyer') }}</th>
                                        <th class="text-center">{{ trans('admin/main.amount') }}</th>
                                        <th class="text-center">{{ trans('update.quantity') }}</th>
                                        <th class="text-center">{{ trans('admin/main.status') }}</th>
                                        <th class="text-center">{{ trans('admin/main.date') }}</th>
                                        <th>{{ trans('admin/main.action') }}</th>
                                    </tr>
                                    @foreach($orders as $order)
                                        <tr>
                                            <td class="text-left">
                                                @if(!empty($order->product))
                                                    <a href="{{ $order->product->getUrl() }}" target="_blank">{{ $order->product->title }}</a>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="text-left">
                                                @if(!empty($order->seller))
                                                    <a href="{{ $order->seller->getProfileUrl() }}" target="_blank">{{ $order->seller->full_name }}</a>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="text-left">
                                                @if(!empty($order->buyer))
                                                    <a href="{{ $order->buyer->getProfileUrl() }}" target="_blank">{{ $order->buyer->full_name }}</a>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if(!empty($order->sale))
                                                    {{ handlePrice($order->sale->total_amount) }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="text-center">{{ $order->quantity }}</td>
                                            <td class="text-center">
                                                @if($order->status == 'success')
                                                    <span class="text-success">{{ trans('admin/main.success') }}</span>
                                                @elseif($order->status == 'canceled')
                                                    <span class="text-danger">{{ trans('admin/main.canceled') }}</span>
                                                @elseif($order->status == 'waiting_delivery')
                                                    <span class="text-warning">{{ trans('update.waiting_delivery') }}</span>
                                                @else
                                                    <span class="text-dark">{{ trans('admin/main.'.$order->status) }}</span>
                                                @endif
                                            </td>
                                            <td class="text-center">{{ dateTimeFormat($order->created_at, 'j M Y H:i') }}</td>
                                            <td>
                                                <div class="btn-group dropdown table-actions position-relative">
                                                    <button type="button" class="btn-transparent dropdown-toggle" data-toggle="dropdown">
                                                        <i class="fa fa-ellipsis-v"></i>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a href="{{ getAdminPanelUrl() }}/store/orders/{{ $order->id }}/invoice" target="_blank" class="dropdown-item">{{ trans('admin/main.invoice') }}</a>
                                                        <a href="{{ getAdminPanelUrl() }}/store/orders/{{ $order->id }}/refund" class="dropdown-item text-danger delete-action" data-confirm-text="{{ trans('public.confirm_delete') }}">{{ trans('admin/main.refund') }}</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>

                        <div class="card-footer text-center">
                            {{ $orders->appends(request()->input())->links('vendor.pagination.bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts_bottom')
@endpush
