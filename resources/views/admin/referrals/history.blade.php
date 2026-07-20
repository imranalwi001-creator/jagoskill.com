@extends('admin.layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ $pageTitle }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}">{{trans('admin/main.dashboard')}}</a></div>
                <div class="breadcrumb-item">{{ $pageTitle}}</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>{{ trans('update.affiliate_users') }}</h4>
                            </div>
                            <div class="card-body">
                                {{ $affiliateUsersCount ?? 0 }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-success">
                            <i class="fas fa-wallet"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>{{ trans('update.total_affiliate_amount') }}</h4>
                            </div>
                            <div class="card-body">
                                {{ handlePrice($allAffiliateAmounts ?? 0) }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-warning">
                            <i class="fas fa-chart-pie"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>{{ trans('update.total_affiliate_commission') }}</h4>
                            </div>
                            <div class="card-body">
                                {{ handlePrice($allAffiliateCommissionAmounts ?? 0) }}
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
                                        <th class="text-center">{{ trans('update.affiliate_user') }}</th>
                                        <th class="text-center">{{ trans('admin/main.amount') }}</th>
                                        <th class="text-center">{{ trans('update.commission') }}</th>
                                        <th class="text-center">{{ trans('admin/main.created_at') }}</th>
                                    </tr>

                                    @if(!empty($affiliates))
                                        @foreach($affiliates as $affiliate)
                                            <tr>
                                                <td>
                                                    @if(!empty($affiliate->referredUser))
                                                        <div class="d-flex align-items-center">
                                                            <img src="{{ $affiliate->referredUser->getAvatar() }}" width="40" alt="{{ $affiliate->referredUser->full_name }}" class="rounded-circle mr-2">
                                                            <div class="d-flex flex-column">
                                                                <span class="font-weight-bold">{{ $affiliate->referredUser->full_name }}</span>
                                                                <span class="text-muted font-12">{{ $affiliate->referredUser->email }}</span>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <span class="text-danger">{{ trans('update.user_deleted') }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(!empty($affiliate->affiliateUser))
                                                        <div class="d-flex align-items-center">
                                                            <img src="{{ $affiliate->affiliateUser->getAvatar() }}" width="40" alt="{{ $affiliate->affiliateUser->full_name }}" class="rounded-circle mr-2">
                                                            <div class="d-flex flex-column">
                                                                <span class="font-weight-bold">{{ $affiliate->affiliateUser->full_name }}</span>
                                                                <span class="text-muted font-12">{{ $affiliate->affiliateUser->email }}</span>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <span class="text-danger">{{ trans('update.user_deleted') }}</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">{{ handlePrice($affiliate->amount) }}</td>
                                                <td class="text-center">{{ handlePrice($affiliate->commission ?? 0) }}</td>
                                                <td class="text-center">{{ dateTimeFormat($affiliate->created_at, 'j M Y H:i') }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </table>
                            </div>
                        </div>

                        <div class="card-footer text-center">
                            @if(!empty($affiliates) and method_exists($affiliates, 'links'))
                                {{ $affiliates->appends(request()->input())->links() }}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
