@extends('admin.layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ $pageTitle }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}">{{ trans('admin/main.dashboard') }}</a></div>
                <div class="breadcrumb-item">{{ $pageTitle }}</div>
            </div>
        </div>

        <div class="section-body">
            <section class="card mt-32">
                <div class="card-body pb-4">
                    <form method="get" class="mb-0">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="input-label">{{ trans('admin/main.search') }}</label>
                                    <input name="search" type="text" class="form-control" value="{{ request()->get('search') }}" placeholder="{{ trans('update.search_in_live_sessions') }}">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="input-label">{{ trans('admin/main.start_date') }}</label>
                                    <input type="date" class="text-center form-control" name="from" value="{{ request()->get('from') }}">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="input-label">{{ trans('admin/main.end_date') }}</label>
                                    <input type="date" class="text-center form-control" name="to" value="{{ request()->get('to') }}">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="input-label">{{ trans('admin/main.filters') }}</label>
                                    <select name="sort" data-plugin-selectTwo class="form-control populate">
                                        <option value="session_start_date_desc" {{ request()->get('sort', 'session_start_date_desc') == 'session_start_date_desc' ? 'selected' : '' }}>{{ trans('update.session_start_date_desc') }}</option>
                                        <option value="session_start_date_asc" {{ request()->get('sort') == 'session_start_date_asc' ? 'selected' : '' }}>{{ trans('update.session_start_date_asc') }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3 d-flex align-items-center">
                                <button type="submit" class="btn btn-primary btn-block btn-lg">{{ trans('admin/main.show_results') }}</button>
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
                                <h5 class="font-14 mb-0">{{ trans('update.agora_history') }}</h5>
                                <p class="font-12 mt-4 mb-0 text-gray-500">{{ trans('update.live_sessions_history') }}</p>
                            </div>

                            <a href="{{ getAdminPanelUrl('/agora_history/excel') }}?{{ http_build_query(request()->all()) }}" class="btn bg-white bg-hover-gray-100 border-gray-400 text-gray-500">
                                <x-iconsax-lin-import-2 class="icons text-gray-500" width="18px" height="18px"/>
                                <span class="ml-4 font-12">{{ trans('admin/main.export_xls') }}</span>
                            </a>
                        </div>

                        <div class="card-body">
                            @if(!empty($agoraHistories) and $agoraHistories->count())
                                <div class="table-responsive">
                                    <table class="table custom-table font-14">
                                        <tr>
                                            <th class="text-left">{{ trans('admin/main.course') }}</th>
                                            <th class="text-left">{{ trans('admin/main.session') }}</th>
                                            <th>{{ trans('update.session_duration') }}</th>
                                            <th>{{ trans('admin/main.start_date') }}</th>
                                            <th>{{ trans('admin/main.end_date') }}</th>
                                            <th>{{ trans('update.meeting_duration') }}</th>
                                        </tr>

                                        @foreach($agoraHistories as $agoraHistory)
                                            @php
                                                $session = $agoraHistory->session;
                                                $webinar = !empty($session) ? $session->webinar : null;
                                                $meetingDuration = (!empty($agoraHistory->end_at) and !empty($agoraHistory->start_at)) ? (($agoraHistory->end_at - $agoraHistory->start_at) / 60) : 0;
                                            @endphp

                                            <tr class="text-center">
                                                <td class="text-left">
                                                    @if(!empty($webinar))
                                                        <a href="{{ $webinar->getUrl() }}" target="_blank" class="text-dark">{{ $webinar->title }}</a>
                                                    @else
                                                        <span class="text-gray-500">-</span>
                                                    @endif
                                                </td>

                                                <td class="text-left">
                                                    <span class="text-dark">{{ !empty($session) ? $session->title : '-' }}</span>
                                                </td>

                                                <td>{{ !empty($session) ? convertMinutesToHourAndMinute($session->duration) : '-' }}</td>
                                                <td>{{ !empty($agoraHistory->start_at) ? dateTimeFormat($agoraHistory->start_at, 'j M Y | H:i') : '-' }}</td>
                                                <td>{{ !empty($agoraHistory->end_at) ? dateTimeFormat($agoraHistory->end_at, 'j M Y | H:i') : '-' }}</td>
                                                <td>{{ convertMinutesToHourAndMinute($meetingDuration) }}</td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>

                                <div class="card-footer text-center">
                                    {{ $agoraHistories->appends(request()->input())->links() }}
                                </div>
                            @else
                                @include('admin.includes.no-result',[
                                    'file_name' => 'meeting.png',
                                    'title' => trans('update.agora_history'),
                                    'hint' => trans('update.live_sessions_history'),
                                    'btn' => [
                                        'url' => getAdminPanelUrl('/webinars?type=webinar'),
                                        'text' => trans('admin/main.live_classes'),
                                    ],
                                ])
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
