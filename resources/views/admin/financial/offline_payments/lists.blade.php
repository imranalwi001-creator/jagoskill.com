@extends('admin.layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ $pageTitle }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}">{{trans('admin/main.dashboard')}}</a></div>
                <div class="breadcrumb-item">{{ trans('admin/main.offline_payments') }}</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-warning">
                            <i class="fas fa-hourglass-start"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Pending</h4>
                            </div>
                            <div class="card-body">
                                {{ \App\Models\OfflinePayment::where('status', \App\Models\OfflinePayment::$waiting)->count() }}
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
                                <h4>Total Approved</h4>
                            </div>
                            <div class="card-body">
                                {{ \App\Models\OfflinePayment::where('status', \App\Models\OfflinePayment::$approved)->count() }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-danger">
                            <i class="fas fa-times-circle"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Rejected</h4>
                            </div>
                            <div class="card-body">
                                {{ \App\Models\OfflinePayment::where('status', \App\Models\OfflinePayment::$reject)->count() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <section class="card">
                <div class="card-body">
                    <form method="get" class="mb-0">
                        <input type="hidden" name="page_type" value="{{ $pageType }}">

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="input-label">{{ trans('admin/main.search') }}</label>
                                    <input type="text" class="form-control text-center" name="search" value="{{ request()->get('search') }}" placeholder="Search User or Ref ID">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="input-label">{{ trans('admin/main.start_date') }}</label>
                                    <div class="input-group">
                                        <input type="date" id="fsdate" class="text-center form-control" name="from" value="{{ request()->get('from') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="input-label">{{ trans('admin/main.end_date') }}</label>
                                    <div class="input-group">
                                        <input type="date" id="lsdate" class="text-center form-control" name="to" value="{{ request()->get('to') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="input-label">{{ trans('admin/main.role') }}</label>
                                    <select name="role_id" class="form-control populate">
                                        <option value="">{{ trans('admin/main.all_roles') }}</option>
                                        @foreach($roles as $role)
                                            <option value="{{ $role->id }}" @if($role->id == request()->get('role_id')) selected @endif>{{ $role->caption }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="input-label">{{ trans('admin/main.bank') }}</label>
                                    <select name="account_type" class="form-control populate">
                                        <option value="">{{ trans('admin/main.all_banks') }}</option>
                                        @foreach($offlineBanks as $offlineBank)
                                            <option value="{{ $offlineBank->id }}" @if(request()->get('account_type') == $offlineBank->id) selected @endif>{{ $offlineBank->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="input-label">Sort By</label>
                                    <select name="sort" class="form-control populate">
                                        <option value="">Default</option>
                                        <option value="amount_asc" @if(request()->get('sort') == 'amount_asc') selected @endif>Amount Ascending</option>
                                        <option value="amount_desc" @if(request()->get('sort') == 'amount_desc') selected @endif>Amount Descending</option>
                                        <option value="created_at_asc" @if(request()->get('sort') == 'created_at_asc') selected @endif>Date Ascending</option>
                                        <option value="created_at_desc" @if(request()->get('sort') == 'created_at_desc') selected @endif>Date Descending</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 d-flex align-items-center justify-content-end">
                                <button type="submit" class="btn btn-primary mr-10 px-24"><i class="fas fa-filter"></i> Apply Filters</button>
                                <a href="/admin/financial/offline_payments?page_type={{ $pageType }}" class="btn btn-danger px-24"><i class="fas fa-redo"></i> Reset</a>
                            </div>
                        </div>
                    </form>
                </div>
            </section>

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <ul class="nav nav-pills">
                        <li class="nav-item">
                            <a class="nav-link @if($pageType == 'requests') active @endif" href="/admin/financial/offline_payments?page_type=requests">Pending Requests</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if($pageType == 'history') active @endif" href="/admin/financial/offline_payments?page_type=history">History</a>
                        </li>
                    </ul>
                    <a href="/admin/financial/offline_payments/excel?page_type={{ $pageType }}" class="btn btn-success"><i class="fas fa-file-excel"></i> Export Excel</a>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped font-14">
                            <thead>
                            <tr>
                                <th>User</th>
                                <th>Order ID</th>
                                <th>USD Amount</th>
                                <th>IDR Amount (QRIS)</th>
                                <th>Reference Code</th>
                                <th>Bank Account</th>
                                <th>Receipt / Attachment</th>
                                <th>Submission Date</th>
                                <th>Status</th>
                                <th class="text-right">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($offlinePayments as $offlinePayment)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <figure class="avatar mr-10 avatar-sm">
                                                <img src="{{ $offlinePayment->user->getAvatar() }}" alt="{{ $offlinePayment->user->full_name }}">
                                            </figure>
                                            <div>
                                                <span class="d-block font-weight-bold text-dark">{{ $offlinePayment->user->full_name }}</span>
                                                <span class="d-block font-12 text-gray-500">{{ $offlinePayment->user->email }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if(!empty($offlinePayment->order_id))
                                            <span class="badge badge-outline-dark">#{{ $offlinePayment->order_id }}</span>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="font-weight-bold text-success">
                                        {{ handlePrice($offlinePayment->amount) }}
                                    </td>
                                    <td class="font-weight-bold text-primary">
                                        @php
                                            $uniqueCodeVal = (int) $offlinePayment->reference_number;
                                            $totalIdrVal = convert_to_idr($offlinePayment->amount) + $uniqueCodeVal;
                                        @endphp
                                        Rp {{ number_format($totalIdrVal, 0, ',', '.') }}
                                    </td>
                                    <td>
                                        <span class="font-weight-600 text-dark">{{ $offlinePayment->reference_number }}</span>
                                    </td>
                                    <td>
                                        {{ $offlinePayment->offlineBank->title ?? 'N/A' }}
                                    </td>
                                    <td>
                                        @if(!empty($offlinePayment->attachment))
                                            <a href="{{ $offlinePayment->attachment }}" target="_blank" class="btn btn-outline-info btn-sm"><i class="fas fa-file-image"></i> View Receipt</a>
                                        @else
                                            <span class="text-gray-400">No upload</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ dateTimeFormat($offlinePayment->pay_date, 'j M Y, H:i') }}
                                    </td>
                                    <td>
                                        @if($offlinePayment->status == \App\Models\OfflinePayment::$waiting)
                                            <span class="badge badge-warning">Pending</span>
                                        @elseif($offlinePayment->status == \App\Models\OfflinePayment::$approved)
                                            <span class="badge badge-success">Approved</span>
                                        @else
                                            <span class="badge badge-danger">Rejected</span>
                                        @endif
                                    </td>
                                    <td class="text-right">
                                        <div class="dropdown d-inline">
                                            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Manage
                                            </button>
                                            <div class="dropdown-menu">
                                                @if(!empty($offlinePayment->order_id))
                                                    <a class="dropdown-item" href="/admin/financial/offline_payments/{{ $offlinePayment->id }}/cartItems"><i class="fas fa-shopping-cart mr-2"></i> View Cart Items</a>
                                                @endif
                                                @if($offlinePayment->status == \App\Models\OfflinePayment::$waiting)
                                                    <a class="dropdown-item text-success" href="/admin/financial/offline_payments/{{ $offlinePayment->id }}/approved" onclick="return confirm('Are you sure you want to approve this payment request?')"><i class="fas fa-check mr-2"></i> Approve Payment</a>
                                                    <a class="dropdown-item text-danger" href="/admin/financial/offline_payments/{{ $offlinePayment->id }}/reject" onclick="return confirm('Are you sure you want to reject this payment request?')"><i class="fas fa-times mr-2"></i> Reject Payment</a>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center text-gray-500 py-30">
                                        No offline payment records found.
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer text-center">
                    {{ $offlinePayments->appends(request()->input())->links() }}
                </div>
            </div>
        </div>
    </section>
@endsection
