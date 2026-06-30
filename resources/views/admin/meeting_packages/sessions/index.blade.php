@extends('admin.layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ $pageTitle }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}">{{trans('admin/main.dashboard')}}</a></div>
                <div class="breadcrumb-item"><a href="{{ getAdminPanelUrl() }}/meeting-packages">{{ trans('update.meeting_packages') }}</a></div>
                <div class="breadcrumb-item"><a href="{{ getAdminPanelUrl() }}/meeting-packages/sold">{{ trans('update.sold_packages') }}</a></div>
                <div class="breadcrumb-item">{{ $pageTitle }}</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>{{ $meetingPackage->title ?? '' }} ({{ $meetingPackageSold->user->full_name ?? '' }})</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped font-14">
                                    <tr>
                                        <th class="text-left">#</th>
                                        <th class="text-left">{{ trans('admin/main.title') }}</th>
                                        <th class="text-center">{{ trans('admin/main.date') }}</th>
                                        <th class="text-center">{{ trans('admin/main.duration') }}</th>
                                        <th class="text-center">{{ trans('admin/main.status') }}</th>
                                    </tr>
                                    
                                    @foreach($sessions as $session)
                                        <tr>
                                            <td class="text-left">
                                                <span>{{ $session->number_row ?? '' }}</span>
                                            </td>
                                            <td class="text-left">
                                                <span>{{ $session->title ?? trans('update.session') . ' ' . ($session->number_row ?? '') }}</span>
                                            </td>
                                            <td class="text-center">
                                                @if(!empty($session->date))
                                                    {{ dateTimeFormat($session->date, 'j M Y H:i') }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <span>{{ $session->duration ?? $meetingPackage->session_duration ?? 0 }} {{ trans('admin/main.minute') }}</span>
                                            </td>
                                            <td class="text-center">
                                                @if($session->status == 'open')
                                                    <span class="text-warning">{{ trans('admin/main.open') }}</span>
                                                @elseif($session->status == 'finished')
                                                    <span class="text-success">{{ trans('admin/main.finished') }}</span>
                                                @else
                                                    <span class="text-danger">{{ trans('admin/main.canceled') }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>

                        <div class="card-footer text-center">
                            {{ $sessions->appends(request()->input())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection