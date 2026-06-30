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
            <section class="card">
                <div class="card-body pb-4">
                    <form method="get" class="mb-0">
                        <div class="row">
                            <div class="col-md-3"><div class="form-group"><label class="input-label">{{ trans('admin/main.search') }}</label><input name="search" type="text" class="form-control" value="{{ request()->get('search') }}"></div></div>
                            <div class="col-md-3"><div class="form-group"><label class="input-label">{{ trans('admin/main.start_date') }}</label><input name="from" type="date" class="form-control text-center" value="{{ request()->get('from') }}"></div></div>
                            <div class="col-md-3"><div class="form-group"><label class="input-label">{{ trans('admin/main.end_date') }}</label><input name="to" type="date" class="form-control text-center" value="{{ request()->get('to') }}"></div></div>
                            <div class="col-md-3 d-flex align-items-center"><button type="submit" class="btn btn-primary btn-block btn-lg">{{ trans('admin/main.show_results') }}</button></div>
                        </div>
                    </form>
                </div>
            </section>

            <div class="card mt-32">
                <div class="card-header justify-content-between">
                    <div><h5 class="font-14 mb-0">{{ trans('update.course_notices') }}</h5><p class="font-12 mt-4 mb-0 text-gray-500">{{ trans('update.manage_all_items_in_a_single_place') }}</p></div>
                    @can('admin_course_noticeboards_send')<a href="{{ getAdminPanelUrl('/course-noticeboards/create') }}" class="btn btn-primary">{{ trans('panel.new_noticeboard') }}</a>@endcan
                </div>
                <div class="card-body">
                    @if(!empty($noticeboards) and $noticeboards->count())
                        <div class="table-responsive">
                            <table class="table custom-table font-14">
                                <tr><th class="text-left">{{ trans('admin/main.title') }}</th><th>{{ trans('admin/main.course') }}</th><th>{{ trans('admin/main.sender') }}</th><th>{{ trans('admin/main.color') }}</th><th>{{ trans('public.date') }}</th><th>{{ trans('admin/main.actions') }}</th></tr>
                                @foreach($noticeboards as $noticeboard)
                                    <tr class="text-center">
                                        <td class="text-left"><span class="text-dark font-weight-bold">{{ $noticeboard->title }}</span></td>
                                        <td>{{ !empty($noticeboard->webinar) ? $noticeboard->webinar->title : '-' }}</td>
                                        <td>{{ !empty($noticeboard->creator) ? $noticeboard->creator->full_name : '-' }}</td>
                                        <td><span class="d-inline-block rounded-circle" style="width: 16px; height: 16px; background: {{ $noticeboard->color }}"></span></td>
                                        <td>{{ dateTimeFormat($noticeboard->created_at, 'j M Y H:i') }}</td>
                                        <td>@can('admin_course_noticeboards_edit')<a href="{{ getAdminPanelUrl("/course-noticeboards/{$noticeboard->id}/edit") }}" class="btn-transparent"><x-iconsax-lin-edit-2 class="icons text-gray-500" width="20px" height="20px"/></a>@endcan</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                        <div class="card-footer text-center">{{ $noticeboards->appends(request()->input())->links() }}</div>
                    @else
                        @include('admin.includes.no-result',['file_name' => 'comment.png','title' => trans('update.course_notices'),'hint' => trans('update.no_result_default_hint')])
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
