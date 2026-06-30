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
                <div class="breadcrumb-item"><a href="{{ getAdminPanelUrl() }}/meeting-packages">{{ trans('update.meeting_packages') }}</a></div>
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
                                <span class="text-gray-500 mt-8">{{trans('update.total_sold_packages')}}</span>
                                <div class="d-flex-center size-48 bg-primary-30 rounded-12">
                                    <i class="fa fa-shopping-cart text-primary font-24"></i>
                                </div>
                            </div>
                            <h5 class="font-24 mt-12 line-height-1 text-black">{{ $totalSoldPackages ?? 0 }}</h5>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card-statistic">
                        <div class="card-statistic__mask"></div>
                        <div class="card-statistic__wrap">
                            <div class="d-flex align-items-start justify-content-between">
                                <span class="text-gray-500 mt-8">{{trans('update.sales_amount')}}</span>
                                <div class="d-flex-center size-48 bg-info-30 rounded-12">
                                    <i class="fa fa-money-bill text-info font-24"></i>
                                </div>
                            </div>
                            <h5 class="font-24 mt-12 line-height-1 text-black">{{ handlePrice($salesAmount ?? 0) }}</h5>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card-statistic">
                        <div class="card-statistic__mask"></div>
                        <div class="card-statistic__wrap">
                            <div class="d-flex align-items-start justify-content-between">
                                <span class="text-gray-500 mt-8">{{trans('admin/main.open')}}</span>
                                <div class="d-flex-center size-48 bg-warning-30 rounded-12">
                                    <i class="fa fa-clock text-warning font-24"></i>
                                </div>
                            </div>
                            <h5 class="font-24 mt-12 line-height-1 text-black">{{ $openPackages ?? 0 }}</h5>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card-statistic">
                        <div class="card-statistic__mask"></div>
                        <div class="card-statistic__wrap">
                            <div class="d-flex align-items-start justify-content-between">
                                <span class="text-gray-500 mt-8">{{trans('admin/main.finished')}}</span>
                                <div class="d-flex-center size-48 bg-success-30 rounded-12">
                                    <i class="fa fa-check text-success font-24"></i>
                                </div>
                            </div>
                            <h5 class="font-24 mt-12 line-height-1 text-black">{{ $finishedPackages ?? 0 }}</h5>
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
                                        <th class="text-left">{{ trans('admin/main.title') }}</th>
                                        <th class="text-left">{{ trans('admin/main.creator') }}</th>
                                        <th class="text-left">{{ trans('admin/main.student') }}</th>
                                        <th class="text-center">{{ trans('update.remained_sessions') }}</th>
                                        <th class="text-center">{{ trans('admin/main.status') }}</th>
                                        <th class="text-center">{{ trans('admin/main.date') }}</th>
                                        <th class="text-right">{{ trans('admin/main.actions') }}</th>
                                    </tr>
                                    
                                    @foreach($meetingPackagesSold as $sold)
                                        <tr>
                                            <td class="text-left">
                                                <span>{{ $sold->meetingPackage->title ?? '' }}</span>
                                            </td>
                                            <td class="text-left">
                                                <span>{{ $sold->meetingPackage->creator->full_name ?? '' }}</span>
                                            </td>
                                            <td class="text-left">
                                                <span>{{ $sold->user->full_name ?? '' }}</span>
                                            </td>
                                            <td class="text-center">{{ $sold->remained_sessions_count ?? 0 }}</td>
                                            
                                            <td class="text-center">
                                                @if($sold->status == 'open')
                                                    <span class="text-warning">{{ trans('admin/main.open') }}</span>
                                                @elseif($sold->status == 'finished')
                                                    <span class="text-success">{{ trans('admin/main.finished') }}</span>
                                                @else
                                                    <span class="text-danger">{{ trans('admin/main.canceled') }}</span>
                                                @endif
                                            </td>
                                            <td class="text-center">{{ dateTimeFormat($sold->created_at, 'j M Y') }}</td>
                                            
                                            <td class="text-right">
                                                @can('admin_meeting_packages_sold')
                                                    <a href="{{ getAdminPanelUrl() }}/meeting-packages/sold/{{ $sold->id }}/sessions" class="btn-transparent text-primary" data-toggle="tooltip" data-placement="top" title="{{ trans('update.sessions') }}">
                                                        <i class="fa fa-calendar"></i>
                                                    </a>
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>

                        <div class="card-footer text-center">
                            {{ $meetingPackagesSold->appends(request()->input())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection