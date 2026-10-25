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
                                                        <button type="button" class="dropdown-item view-fulfillment-btn text-primary" data-order-id="{{ $order->id }}">
                                                            <i class="fa fa-key mr-2"></i> Detail Digital & Lisensi
                                                        </button>
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

    <!-- Modal Detail Fulfillment Digital & Lisensi -->
    <div class="modal fade" id="fulfillmentModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-16 font-weight-bold">Fulfillment & Lisensi: Order <span id="modalOrderId" class="text-primary"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="fulfillmentModalBody">
                        <p class="text-center text-muted py-3">Memuat detail fulfillment...</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('admin/main.close') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts_bottom')
<script>
    (function ($) {
        "use strict";

        $('.view-fulfillment-btn').on('click', function () {
            var orderId = $(this).data('order-id');
            $('#modalOrderId').text('#' + orderId);
            $('#fulfillmentModalBody').html('<p class="text-center text-muted py-3">Memuat detail fulfillment...</p>');
            $('#fulfillmentModal').modal('show');

            $.get('{{ getAdminPanelUrl() }}/store/orders/' + orderId + '/fulfillment', function (res) {
                if (res.code === 200) {
                    var order = res.order;
                    var html = '';

                    // License Card
                    html += '<div class="card bg-light mb-3">';
                    html += '<div class="card-body p-3">';
                    html += '<h6 class="font-14 font-weight-bold text-dark mb-2"><i class="fa fa-key mr-2 text-warning"></i>Serial Key / Lisensi Digital</h6>';

                    if (order.license) {
                        html += '<div class="d-flex justify-content-between align-items-center mb-2">';
                        html += '<div><code>' + order.license.key + '</code></div>';
                        html += '<span class="badge badge-' + (order.license.status === 'active' ? 'success' : 'danger') + '">' + order.license.status.toUpperCase() + '</span>';
                        html += '</div>';
                        html += '<div class="font-12 text-muted mb-2">';
                        html += 'Aktivasi: <strong>' + order.license.activation_count + ' / ' + order.license.max_activations + '</strong> | Kedaluwarsa: <strong>' + order.license.expires_at + '</strong>';
                        html += '</div>';

                        if (order.license.activations && order.license.activations.length > 0) {
                            html += '<div class="mt-2 pt-2 border-top"><strong class="font-12">Domain Aktif:</strong><ul class="font-12 text-muted pl-3 mb-0">';
                            $.each(order.license.activations, function (i, act) {
                                html += '<li>' + (act.domain || act.machine_id) + ' (IP: ' + (act.ip_address || '-') + ')</li>';
                            });
                            html += '</ul></div>';
                        }
                    } else {
                        html += '<p class="font-12 text-muted mb-0">Pesanan ini belum memiliki serial key atau tidak membutuhkan aktivasi lisensi.</p>';
                    }
                    html += '</div></div>';

                    // Downloads Card
                    html += '<div class="card bg-light">';
                    html += '<div class="card-body p-3">';
                    html += '<div class="d-flex justify-content-between align-items-center mb-2">';
                    html += '<h6 class="font-14 font-weight-bold text-dark mb-0"><i class="fa fa-download mr-2 text-info"></i>Riwayat Unduhan Berkas</h6>';
                    html += '<form action="{{ getAdminPanelUrl() }}/store/orders/' + order.id + '/reset-downloads" method="post" class="d-inline" onsubmit="return confirm(\'Reset riwayat unduhan pembeli ini agar kuota kembali utuh?\');">';
                    html += '<input type="hidden" name="_token" value="{{ csrf_token() }}">';
                    html += '<button type="submit" class="btn btn-sm btn-outline-danger font-12 py-1"><i class="fa fa-redo mr-1"></i>Reset Kuota Unduh</button>';
                    html += '</form>';
                    html += '</div>';

                    html += '<p class="font-12 text-muted mb-2">Total Unduhan Tercatat: <strong>' + order.total_downloads + ' kali</strong></p>';

                    if (order.download_logs && order.download_logs.length > 0) {
                        html += '<div class="table-responsive" style="max-height: 180px; overflow-y: auto;">';
                        html += '<table class="table table-sm font-12 mb-0">';
                        html += '<thead><tr><th>File</th><th>IP Address</th><th>Waktu Unduh</th></tr></thead>';
                        html += '<tbody>';
                        $.each(order.download_logs, function (i, log) {
                            html += '<tr><td>' + log.file_title + '</td><td>' + (log.ip_address || '-') + '</td><td>' + log.downloaded_at + '</td></tr>';
                        });
                        html += '</tbody></table></div>';
                    } else {
                        html += '<p class="font-12 text-muted mb-0">Pembeli belum pernah mengunduh berkas produk ini.</p>';
                    }
                    html += '</div></div>';

                    $('#fulfillmentModalBody').html(html);
                }
            }).fail(function () {
                $('#fulfillmentModalBody').html('<p class="text-center text-danger py-3">Gagal memuat detail fulfillment.</p>');
            });
        });

    })(jQuery);
</script>
@endpush
