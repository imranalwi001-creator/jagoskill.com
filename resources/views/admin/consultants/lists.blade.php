@extends('admin.layouts.app')

@push('libraries_top')

@endpush

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ $pageTitle }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}">{{trans('admin/main.dashboard')}}</a>
                </div>
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
                                <span class="text-gray-500 mt-8">{{trans('admin/main.total_consultants')}}</span>
                                <div class="d-flex-center size-48 bg-primary-30 rounded-12">
                                    <i class="fa fa-users text-primary font-24"></i>
                                </div>
                            </div>
                            <h5 class="font-24 mt-12 line-height-1 text-black">{{ $totalConsultants }}</h5>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card-statistic">
                        <div class="card-statistic__mask"></div>
                        <div class="card-statistic__wrap">
                            <div class="d-flex align-items-start justify-content-between">
                                <span class="text-gray-500 mt-8">{{trans('admin/main.available_consultants')}}</span>
                                <div class="d-flex-center size-48 bg-success-30 rounded-12">
                                    <i class="fa fa-user-check text-success font-24"></i>
                                </div>
                            </div>
                            <h5 class="font-24 mt-12 line-height-1 text-black">{{ $availableConsultants }}</h5>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card-statistic">
                        <div class="card-statistic__mask"></div>
                        <div class="card-statistic__wrap">
                            <div class="d-flex align-items-start justify-content-between">
                                <span class="text-gray-500 mt-8">{{trans('admin/main.unavailable_consultants')}}</span>
                                <div class="d-flex-center size-48 bg-danger-30 rounded-12">
                                    <i class="fa fa-user-times text-danger font-24"></i>
                                </div>
                            </div>
                            <h5 class="font-24 mt-12 line-height-1 text-black">{{ $unavailableConsultants }}</h5>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card-statistic">
                        <div class="card-statistic__mask"></div>
                        <div class="card-statistic__wrap">
                            <div class="d-flex align-items-start justify-content-between">
                                <span class="text-gray-500 mt-8">{{trans('admin/main.consultants_without_appointment')}}</span>
                                <div class="d-flex-center size-48 bg-warning-30 rounded-12">
                                    <i class="fa fa-user-clock text-warning font-24"></i>
                                </div>
                            </div>
                            <h5 class="font-24 mt-12 line-height-1 text-black">{{ $consultantsWithoutAppointment }}</h5>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>{{ trans('admin/main.consultants') }}</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped font-14">
                                    <tr>
                                        <th class="text-left">{{ trans('admin/main.name') }}</th>
                                        <th class="text-center">{{ trans('admin/main.appointments') }}</th>
                                        <th class="text-center">{{ trans('admin/main.sales_amount') }}</th>
                                        <th class="text-center">{{ trans('admin/main.status') }}</th>
                                        <th class="text-right">{{ trans('admin/main.actions') }}</th>
                                    </tr>
                                    
                                    @foreach($consultants as $consultant)
                                        <tr>
                                            <td class="text-left">
                                                <a href="{{ $consultant->getProfileUrl() }}" target="_blank">
                                                    {{ $consultant->full_name }}
                                                </a>
                                                <div class="text-small text-muted">{{ $consultant->role_name }}</div>
                                            </td>
                                            <td class="text-center">{{ $consultant->sales_count }}</td>
                                            <td class="text-center">{{ handlePrice($consultant->sales_amount ?? 0) }}</td>
                                            <td class="text-center">
                                                @if($consultant->disabled)
                                                    <span class="text-danger">{{ trans('admin/main.unavailable') }}</span>
                                                @else
                                                    <span class="text-success">{{ trans('admin/main.available') }}</span>
                                                @endif
                                            </td>
                                            <td class="text-right">
                                                <a href="{{ getAdminPanelUrl() }}/users/{{ $consultant->id }}/edit" class="btn-transparent text-primary" data-toggle="tooltip" data-placement="top" title="{{ trans('admin/main.edit') }}">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>

                        <div class="card-footer text-center">
                            {{ $consultants->appends(request()->input())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
