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
            @include('admin.attendances.history.top_stats')
            @include('admin.attendances.history.filters')

            <div class="card mt-32">
                <div class="card-header justify-content-between">
                    <div>
                        <h5 class="font-14 mb-0">{{ trans('update.attendances_history') }}</h5>
                        <p class="font-12 mt-4 mb-0 text-gray-500">{{ trans('update.manage_all_items_in_a_single_place') }}</p>
                    </div>

                    @can('admin_attendances_history_export')
                        <a href="{{ getAdminPanelUrl('/attendances/history/excel') }}?{{ http_build_query(request()->all()) }}" class="btn bg-white bg-hover-gray-100 border-gray-400 text-gray-500">
                            <x-iconsax-lin-import-2 class="icons text-gray-500" width="18px" height="18px"/>
                            <span class="ml-4 font-12">{{ trans('admin/main.export_xls') }}</span>
                        </a>
                    @endcan
                </div>

                <div class="card-body">
                    @if(!empty($sessions) and $sessions->count())
                        <div class="table-responsive">
                            <table class="table custom-table font-14">
                                <tr>
                                    <th class="text-left">{{ trans('admin/main.session') }}</th>
                                    <th class="text-left">{{ trans('admin/main.instructor') }}</th>
                                    <th>{{ trans('admin/main.start_date') }}</th>
                                    <th>{{ trans('update.source') }}</th>
                                    <th>{{ trans('quiz.students') }}</th>
                                    <th>{{ trans('update.present') }}</th>
                                    <th>{{ trans('update.late') }}</th>
                                    <th>{{ trans('update.absent') }}</th>
                                    <th>{{ trans('admin/main.actions') }}</th>
                                </tr>

                                @foreach($sessions as $session)
                                    @include('admin.attendances.history.table_items', ['session' => $session])
                                @endforeach
                            </table>
                        </div>

                        <div class="card-footer text-center">
                            {{ $sessions->appends(request()->input())->links() }}
                        </div>
                    @else
                        @include('admin.includes.no-result',[
                            'file_name' => 'meeting.png',
                            'title' => trans('update.attendances_history'),
                            'hint' => trans('update.no_result_default_hint'),
                        ])
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
