@extends('admin.layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ $pageTitle }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}">{{trans('admin/main.dashboard')}}</a></div>
                <div class="breadcrumb-item"><a href="{{ getAdminPanelUrl() }}/financial/registration-packages">{{ trans('update.registration_packages') }}</a></div>
                <div class="breadcrumb-item">{{ $pageTitle}}</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-box"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>{{ trans('admin/main.total_sales') }}</h4>
                            </div>
                            <div class="card-body">
                                {{ $sales->total() }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-success">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>{{ trans('admin/main.instructors') }}</h4>
                            </div>
                            <div class="card-body">
                                {{ $totalBuyInstructorsPackages ?? 0 }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-warning">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>{{ trans('admin/main.organizations') }}</h4>
                            </div>
                            <div class="card-body">
                                {{ $totalBuyOrganizationPackages ?? 0 }}
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
                                        <th class="text-center">{{ trans('admin/main.package') }}</th>
                                        <th class="text-center">{{ trans('admin/main.role') }}</th>
                                        <th class="text-center">{{ trans('admin/main.amount') }}</th>
                                        <th class="text-center">{{ trans('admin/main.created_at') }}</th>
                                    </tr>

                                    @if(!empty($sales))
                                        @foreach($sales as $sale)
                                            <tr>
                                                <td>
                                                    @if(!empty($sale->buyer))
                                                        <div class="d-flex align-items-center">
                                                            <img src="{{ $sale->buyer->getAvatar() }}" width="40" alt="{{ $sale->buyer->full_name }}" class="rounded-circle mr-2">
                                                            <div class="d-flex flex-column">
                                                                <span class="font-weight-bold">{{ $sale->buyer->full_name }}</span>
                                                                <span class="text-muted font-12">{{ $sale->buyer->email }}</span>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <span class="text-danger">{{ trans('update.user_deleted') }}</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if(!empty($sale->registrationPackage))
                                                        {{ $sale->registrationPackage->title }}
                                                    @else
                                                        <span class="text-danger">{{ trans('admin/main.deleted') }}</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if(!empty($sale->registrationPackage))
                                                        {{ trans('update.' . $sale->registrationPackage->role) }}
                                                    @endif
                                                </td>
                                                <td class="text-center">{{ handlePrice($sale->total_amount) }}</td>
                                                <td class="text-center">{{ dateTimeFormat($sale->created_at, 'j M Y H:i') }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </table>
                            </div>
                        </div>

                        <div class="card-footer text-center">
                            @if(!empty($sales) and method_exists($sales, 'links'))
                                {{ $sales->appends(request()->input())->links() }}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
