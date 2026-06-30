@extends('admin.layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ $session->title }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}">{{ trans('admin/main.dashboard') }}</a></div>
                <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl('/attendances/history') }}">{{ trans('update.attendances_history') }}</a></div>
                <div class="breadcrumb-item">{{ $session->title }}</div>
            </div>
        </div>

        <div class="section-body">
            @include('admin.attendances.details.top_stats')
            @include('admin.attendances.details.filters')

            <div class="card mt-32">
                <div class="card-header justify-content-between">
                    <div>
                        <h5 class="font-14 mb-0">{{ $session->title }}</h5>
                        <p class="font-12 mt-4 mb-0 text-gray-500">{{ !empty($session->webinar) ? $session->webinar->title : '' }}</p>
                    </div>

                    @can('admin_attendances_history_export')
                        <a href="{{ getAdminPanelUrl("/attendances/{$session->id}/details/excel") }}?{{ http_build_query(request()->all()) }}" class="btn bg-white bg-hover-gray-100 border-gray-400 text-gray-500">{{ trans('admin/main.export_xls') }}</a>
                    @endcan
                </div>

                <div class="card-body">
                    @if(!empty($students) and $students->count())
                        <div class="table-responsive">
                            <table class="table custom-table font-14">
                                <tr><th class="text-left">{{ trans('admin/main.student') }}</th><th>{{ trans('update.joined_date') }}</th><th>{{ trans('update.attendance_status') }}</th><th>{{ trans('admin/main.actions') }}</th></tr>
                                @foreach($students as $student)
                                    @include('admin.attendances.details.table_items', ['student' => $student, 'session' => $session])
                                @endforeach
                            </table>
                        </div>
                        <div class="card-footer text-center">{{ $students->appends(request()->input())->links() }}</div>
                    @else
                        @include('admin.includes.no-result',['file_name' => 'student.png','title' => trans('admin/main.students'),'hint' => trans('update.no_result_default_hint')])
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
