@extends('admin.layouts.app')

@push('libraries_top')
@endpush

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ $pageTitle }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}">{{ trans('admin/main.dashboard') }}</a></div>
                <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}/store/products">{{ trans('update.store') }}</a></div>
                <div class="breadcrumb-item">{{ $pageTitle }}</div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="fas fa-key"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Lisensi</h4>
                        </div>
                        <div class="card-body">
                            {{ $totalLicenses }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-success">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Lisensi Aktif</h4>
                        </div>
                        <div class="card-body">
                            {{ $activeLicenses }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-danger">
                        <i class="fas fa-ban"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Dicabut (Revoked)</h4>
                        </div>
                        <div class="card-body">
                            {{ $revokedLicenses }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-info">
                        <i class="fas fa-globe"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Domain Teraktivasi</h4>
                        </div>
                        <div class="card-body">
                            {{ $totalActivations }}
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
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="input-label">{{ trans('admin/main.search') }}</label>
                                    <input name="search" type="text" class="form-control" value="{{ request()->get('search') }}" placeholder="Cari serial key, email, atau produk...">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="input-label">{{ trans('admin/main.status') }}</label>
                                    <select name="status" class="form-control">
                                        <option value="">Semua Status</option>
                                        <option value="active" {{ request()->get('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                                        <option value="inactive" {{ request()->get('status') == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                                        <option value="revoked" {{ request()->get('status') == 'revoked' ? 'selected' : '' }}>Dicabut (Revoked)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="input-label">{{ trans('admin/main.product') }}</label>
                                    <select name="product_id" class="form-control">
                                        <option value="">Semua Produk</option>
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}" {{ request()->get('product_id') == $product->id ? 'selected' : '' }}>{{ $product->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group mt-1">
                                    <label class="input-label mb-4"> </label>
                                    <button type="submit" class="btn btn-primary w-100">{{ trans('admin/main.show_results') }}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </section>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header justify-content-between">
                            <div>
                                <h5 class="font-14 mb-0">Daftar Serial Key & Lisensi Digital</h5>
                                <p class="font-12 mt-4 mb-0 text-gray-500">Pantau aktivasi domain, kuota instalasi, dan status validitas lisensi software / produk digital.</p>
                            </div>
                            <div class="d-flex align-items-center gap-12">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#generateLicenseModal">
                                    <i class="fa fa-plus mr-1"></i> Generate Lisensi Baru
                                </button>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table custom-table font-14">
                                    <thead>
                                        <tr>
                                            <th class="text-left">Serial Key</th>
                                            <th class="text-left">Produk Digital</th>
                                            <th class="text-left">Pemegang Lisensi</th>
                                            <th class="text-center">No. Order</th>
                                            <th class="text-center">Aktivasi Domain</th>
                                            <th class="text-center">Kedaluwarsa</th>
                                            <th class="text-center">{{ trans('admin/main.status') }}</th>
                                            <th class="text-center">{{ trans('admin/main.date') }}</th>
                                            <th class="text-right">{{ trans('admin/main.action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($licenses as $license)
                                            <tr>
                                                <td class="text-left font-weight-bold">
                                                    <code class="font-14 text-dark font-weight-bold bg-light px-2 py-1 rounded">{{ $license->license_key }}</code>
                                                </td>
                                                <td class="text-left">
                                                    @if(!empty($license->product))
                                                        <a href="{{ $license->product->getUrl() }}" target="_blank" class="font-weight-500">{{ $license->product->title }}</a>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td class="text-left">
                                                    @if(!empty($license->user))
                                                        <a href="{{ $license->user->getProfileUrl() }}" target="_blank" class="font-weight-500">{{ $license->user->full_name }}</a>
                                                        <span class="d-block font-12 text-gray-500">{{ $license->user->email }}</span>
                                                    @else
                                                        <span class="badge badge-secondary">Belum Di-assign</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if(!empty($license->product_order_id))
                                                        <span class="badge badge-light">#{{ $license->product_order_id }}</span>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-sm btn-outline-info view-activations-btn" data-license-id="{{ $license->id }}" data-key="{{ $license->license_key }}">
                                                        {{ $license->activation_count }} / {{ $license->max_activations == 0 ? '∞' : $license->max_activations }}
                                                    </button>
                                                </td>
                                                <td class="text-center font-12">
                                                    @if(!empty($license->expires_at))
                                                        {{ dateTimeFormat($license->expires_at, 'j M Y') }}
                                                    @else
                                                        <span class="badge badge-light text-success">Lifetime</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if($license->status == 'active')
                                                        <span class="badge badge-success">Aktif</span>
                                                    @elseif($license->status == 'revoked')
                                                        <span class="badge badge-danger">Dicabut</span>
                                                    @else
                                                        <span class="badge badge-warning">Nonaktif</span>
                                                    @endif
                                                </td>
                                                <td class="text-center font-12">
                                                    {{ dateTimeFormat($license->created_at, 'j M Y') }}
                                                </td>
                                                <td class="text-right">
                                                    <div class="btn-group dropdown table-actions position-relative">
                                                        <button type="button" class="btn-transparent dropdown-toggle" data-toggle="dropdown">
                                                            <i class="fa fa-ellipsis-v"></i>
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <button type="button" class="dropdown-item view-activations-btn" data-license-id="{{ $license->id }}" data-key="{{ $license->license_key }}">
                                                                <i class="fa fa-eye mr-2"></i> Detail Domain
                                                            </button>
                                                            <form action="{{ getAdminPanelUrl() }}/store/licenses/{{ $license->id }}/reset-activations" method="post" class="d-inline">
                                                                @csrf
                                                                <button type="submit" class="dropdown-item text-warning" onclick="return confirm('Apakah Anda yakin ingin mereset seluruh domain aktivasi untuk lisensi ini?');">
                                                                    <i class="fa fa-redo mr-2"></i> Reset Aktivasi
                                                                </button>
                                                            </form>
                                                            @if($license->status !== 'revoked')
                                                                <button type="button" class="dropdown-item text-danger js-change-status" data-id="{{ $license->id }}" data-status="revoked">
                                                                    <i class="fa fa-ban mr-2"></i> Cabut (Revoke)
                                                                </button>
                                                            @else
                                                                <button type="button" class="dropdown-item text-success js-change-status" data-id="{{ $license->id }}" data-status="active">
                                                                    <i class="fa fa-check mr-2"></i> Aktifkan Kembali
                                                                </button>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="9" class="text-center py-4 text-muted">Belum ada data lisensi produk digital.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="card-footer text-center">
                            {{ $licenses->appends(request()->input())->links('vendor.pagination.bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal Generate Lisensi -->
    <div class="modal fade" id="generateLicenseModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form action="{{ getAdminPanelUrl() }}/store/licenses/generate" method="post">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title font-16 font-weight-bold">Generate Lisensi Baru</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="input-label">Pilih Produk Digital <span class="text-danger">*</span></label>
                            <select name="product_id" class="form-control" required>
                                <option value="">-- Pilih Produk --</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="input-label">Jumlah Kunci <span class="text-danger">*</span></label>
                                    <input type="number" name="count" class="form-control" value="1" min="1" max="100" required>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="input-label">Maksimal Domain <span class="text-danger">*</span></label>
                                    <input type="number" name="max_activations" class="form-control" value="1" min="1" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="input-label">Masa Berlaku (Hari)</label>
                            <input type="number" name="days_valid" class="form-control" placeholder="Kosongkan untuk Lifetime">
                            <small class="text-muted">Contoh: 365 untuk lisensi tahunan.</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('admin/main.cancel') }}</button>
                        <button type="submit" class="btn btn-primary">Generate Sekarang</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Detail Aktivasi Domain -->
    <div class="modal fade" id="activationsModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-16 font-weight-bold">Domain Teraktivasi: <span id="modalLicenseKey" class="text-primary"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="activationsListContent" class="py-2">
                        <p class="text-center text-muted">Memuat data domain...</p>
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

        // View activations
        $('.view-activations-btn').on('click', function () {
            var licenseId = $(this).data('license-id');
            var licenseKey = $(this).data('key');
            $('#modalLicenseKey').text(licenseKey);
            $('#activationsListContent').html('<p class="text-center text-muted">Memuat data domain...</p>');
            $('#activationsModal').modal('show');

            $.get('{{ getAdminPanelUrl() }}/store/licenses/' + licenseId + '/activations', function (res) {
                if (res.code === 200) {
                    if (res.activations && res.activations.length > 0) {
                        var html = '<ul class="list-group">';
                        $.each(res.activations, function (i, item) {
                            var dateStr = new Date(item.activated_at * 1000).toLocaleDateString('id-ID', { year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' });
                            html += '<li class="list-group-item d-flex justify-content-between align-items-center">';
                            html += '<div><strong>' + (item.domain || item.machine_id || 'Unknown Host') + '</strong><br><small class="text-muted">IP: ' + (item.ip_address || '-') + '</small></div>';
                            html += '<span class="badge badge-light font-12">' + dateStr + '</span>';
                            html += '</li>';
                        });
                        html += '</ul>';
                        $('#activationsListContent').html(html);
                    } else {
                        $('#activationsListContent').html('<p class="text-center text-muted py-3">Belum ada domain atau mesin yang diaktivasi pada lisensi ini.</p>');
                    }
                }
            }).fail(function () {
                $('#activationsListContent').html('<p class="text-center text-danger py-3">Gagal mengambil data aktivasi.</p>');
            });
        });

        // Change status ajax
        $('.js-change-status').on('click', function () {
            var id = $(this).data('id');
            var status = $(this).data('status');
            var actionText = (status === 'revoked') ? 'mencabut (revoke)' : 'mengaktifkan kembali';

            if (confirm('Apakah Anda yakin ingin ' + actionText + ' lisensi ini?')) {
                $.post('{{ getAdminPanelUrl() }}/store/licenses/' + id + '/status', {
                    _token: '{{ csrf_token() }}',
                    status: status
                }, function (res) {
                    if (res.code === 200) {
                        location.reload();
                    }
                });
            }
        });

    })(jQuery);
</script>
@endpush
