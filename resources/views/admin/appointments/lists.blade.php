@extends('admin.layouts.app')

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
                                <span class="text-gray-500 mt-8">{{trans('admin/main.total_appointments')}}</span>
                                <div class="d-flex-center size-48 bg-primary-30 rounded-12">
                                    <i class="fa fa-calendar text-primary font-24"></i>
                                </div>
                            </div>
                            <h5 class="font-24 mt-12 line-height-1 text-black">{{ $totalAppointments }}</h5>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card-statistic">
                        <div class="card-statistic__mask"></div>
                        <div class="card-statistic__wrap">
                            <div class="d-flex align-items-start justify-content-between">
                                <span class="text-gray-500 mt-8">{{trans('admin/main.open_appointments')}}</span>
                                <div class="d-flex-center size-48 bg-warning-30 rounded-12">
                                    <i class="fa fa-clock text-warning font-24"></i>
                                </div>
                            </div>
                            <h5 class="font-24 mt-12 line-height-1 text-black">{{ $openAppointments }}</h5>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card-statistic">
                        <div class="card-statistic__mask"></div>
                        <div class="card-statistic__wrap">
                            <div class="d-flex align-items-start justify-content-between">
                                <span class="text-gray-500 mt-8">{{trans('admin/main.finished_appointments')}}</span>
                                <div class="d-flex-center size-48 bg-success-30 rounded-12">
                                    <i class="fa fa-check text-success font-24"></i>
                                </div>
                            </div>
                            <h5 class="font-24 mt-12 line-height-1 text-black">{{ $finishedAppointments }}</h5>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card-statistic">
                        <div class="card-statistic__mask"></div>
                        <div class="card-statistic__wrap">
                            <div class="d-flex align-items-start justify-content-between">
                                <span class="text-gray-500 mt-8">{{trans('admin/main.total_consultants')}}</span>
                                <div class="d-flex-center size-48 bg-info-30 rounded-12">
                                    <i class="fa fa-users text-info font-24"></i>
                                </div>
                            </div>
                            <h5 class="font-24 mt-12 line-height-1 text-black">{{ $totalConsultants }}</h5>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>{{ trans('admin/main.appointments') }}</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped font-14">
                                    <tr>
                                        <th class="text-left">{{ trans('admin/main.consultant') }}</th>
                                        <th class="text-left">{{ trans('admin/main.user') }}</th>
                                        <th class="text-center">{{ trans('admin/main.date') }} / {{ trans('admin/main.time') }}</th>
                                        <th class="text-center">{{ trans('admin/main.type') }}</th>
                                        <th class="text-center">{{ trans('admin/main.status') }}</th>
                                        <th class="text-right">{{ trans('admin/main.actions') }}</th>
                                    </tr>
                                    
                                    @foreach($appointments as $appointment)
                                        <tr>
                                            <td class="text-left">
                                                <span>{{ $appointment->meeting->creator->full_name ?? '' }}</span>
                                            </td>
                                            <td class="text-left">
                                                <span>{{ $appointment->user->full_name ?? '' }}</span>
                                            </td>
                                            <td class="text-center">
                                                <div>{{ $appointment->date }}</div>
                                                <div class="text-muted text-small">{{ $appointment->start_time }} - {{ $appointment->end_time }}</div>
                                            </td>
                                            <td class="text-center">
                                                <span>{{ $appointment->meeting_type == 'all' ? trans('public.all') : trans('update.'.$appointment->meeting_type) }}</span>
                                            </td>
                                            <td class="text-center">
                                                @if($appointment->status == 'open')
                                                    <span class="text-warning">{{ trans('admin/main.open') }}</span>
                                                @elseif($appointment->status == 'finished')
                                                    <span class="text-success">{{ trans('admin/main.finished') }}</span>
                                                @else
                                                    <span class="text-danger">{{ trans('admin/main.canceled') }}</span>
                                                @endif
                                            </td>
                                            <td class="text-right">
                                                @if($appointment->status == 'open' && !empty($appointment->link))
                                                    <a href="{{ getAdminPanelUrl() }}/appointments/{{ $appointment->id }}/join" target="_blank" class="btn-transparent text-primary" data-toggle="tooltip" data-placement="top" title="{{ trans('footer.join') }}">
                                                        <i class="fa fa-link"></i>
                                                    </a>
                                                @endif
                                                
                                                @if($appointment->status == 'open')
                                                    <a href="{{ getAdminPanelUrl() }}/appointments/{{ $appointment->id }}/send_reminder" class="btn-transparent text-info mx-1" data-toggle="tooltip" data-placement="top" title="{{ trans('update.send_reminder') }}">
                                                        <i class="fa fa-bell"></i>
                                                    </a>
                                                @endif
                                                
                                                <button type="button" data-id="{{ $appointment->id }}" class="btn-transparent text-primary mx-1 js-view-details" data-toggle="tooltip" data-placement="top" title="{{ trans('admin/main.details') }}">
                                                    <i class="fa fa-eye"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>

                        <div class="card-footer text-center">
                            {{ $appointments->appends(request()->input())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
