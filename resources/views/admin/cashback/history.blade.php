@extends('admin.layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ $pageTitle }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}">{{trans('admin/main.dashboard')}}</a></div>
                <div class="breadcrumb-item">{{ $pageTitle }}</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-lg-4 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>{{ trans('update.total_users') }}</h4>
                            </div>
                            <div class="card-body">
                                {{ $totalUsers }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-success">
                            <i class="fas fa-money-bill"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>{{ trans('update.total_purchase') }}</h4>
                            </div>
                            <div class="card-body">
                                {{ handlePrice($totalPurchase) }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-warning">
                            <i class="fas fa-coins"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>{{ trans('update.total_cashback') }}</h4>
                            </div>
                            <div class="card-body">
                                {{ handlePrice($totalCashback) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped font-14">
                                    <tr>
                                        <th>{{ trans('admin/main.user') }}</th>
                                        <th class="text-center">{{ trans('update.purchase_amount') }}</th>
                                        <th class="text-center">{{ trans('update.total_cashback') }}</th>
                                        <th class="text-center">{{ trans('update.last_cashback') }}</th>
                                    </tr>

                                    @foreach($transactions as $transaction)
                                        <tr>
                                            <td>
                                                @if(!empty($transaction->user))
                                                    <a href="{{ getAdminPanelUrl() }}/users/{{ $transaction->user_id }}/edit" target="_blank">{{ $transaction->user->full_name }}</a>
                                                @else
                                                    <span class="text-muted">{{ trans('update.guest') }}</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                {{ handlePrice($transaction->purchase_amount) }}
                                            </td>
                                            <td class="text-center text-success">
                                                {{ handlePrice($transaction->total_cashback) }}
                                            </td>
                                            <td class="text-center">
                                                {{ dateTimeFormat($transaction->last_cashback, 'j M Y H:i') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>

                            <div class="card-footer text-center">
                                {{ $transactions->appends(request()->input())->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
