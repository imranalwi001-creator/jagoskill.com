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
            <div class="row">
                <div class="col-lg-3 col-md-6 col-12"><div class="card-statistic"><div class="card-statistic__wrap"><span class="text-gray-500">{{ trans('update.assignments') }}</span><h5 class="font-24 mt-12 text-black">{{ $courseAssignmentsCount }}</h5></div></div></div>
                <div class="col-lg-3 col-md-6 col-12"><div class="card-statistic"><div class="card-statistic__wrap"><span class="text-gray-500">{{ trans('update.pending_review') }}</span><h5 class="font-24 mt-12 text-black">{{ $pendingReviewCount }}</h5></div></div></div>
                <div class="col-lg-3 col-md-6 col-12"><div class="card-statistic"><div class="card-statistic__wrap"><span class="text-gray-500">{{ trans('quiz.passed') }}</span><h5 class="font-24 mt-12 text-black">{{ $passedCount }}</h5></div></div></div>
                <div class="col-lg-3 col-md-6 col-12"><div class="card-statistic"><div class="card-statistic__wrap"><span class="text-gray-500">{{ trans('quiz.failed') }}</span><h5 class="font-24 mt-12 text-black">{{ $failedCount }}</h5></div></div></div>
            </div>

            <section class="card mt-32">
                <div class="card-body pb-4">
                    <form method="get" class="mb-0">
                        <div class="row">
                            <div class="col-md-3"><div class="form-group"><label class="input-label">{{ trans('admin/main.start_date') }}</label><input name="from" type="date" class="form-control text-center" value="{{ request()->get('from') }}"></div></div>
                            <div class="col-md-3"><div class="form-group"><label class="input-label">{{ trans('admin/main.end_date') }}</label><input name="to" type="date" class="form-control text-center" value="{{ request()->get('to') }}"></div></div>
                            <div class="col-md-3"><div class="form-group"><label class="input-label">{{ trans('admin/main.status') }}</label><select name="status" class="form-control"><option value="">{{ trans('admin/main.all') }}</option><option value="active" {{ request()->get('status') == 'active' ? 'selected' : '' }}>{{ trans('admin/main.active') }}</option><option value="inactive" {{ request()->get('status') == 'inactive' ? 'selected' : '' }}>{{ trans('admin/main.inactive') }}</option></select></div></div>
                            <div class="col-md-3 d-flex align-items-center"><button type="submit" class="btn btn-primary btn-block btn-lg">{{ trans('admin/main.show_results') }}</button></div>
                        </div>
                    </form>
                </div>
            </section>

            <div class="card mt-32">
                <div class="card-header"><div><h5 class="font-14 mb-0">{{ trans('update.assignments') }}</h5><p class="font-12 mt-4 mb-0 text-gray-500">{{ trans('update.manage_all_items_in_a_single_place') }}</p></div></div>
                <div class="card-body">
                    @if(!empty($assignments) and $assignments->count())
                        <div class="table-responsive">
                            <table class="table custom-table font-14">
                                <tr><th class="text-left">{{ trans('update.assignment') }}</th><th>{{ trans('admin/main.course') }}</th><th>{{ trans('update.pending_review') }}</th><th>{{ trans('admin/main.status') }}</th><th>{{ trans('admin/main.created_at') }}</th><th>{{ trans('admin/main.actions') }}</th></tr>
                                @foreach($assignments as $assignment)
                                    @php $pendingCount = $assignment->instructorAssignmentHistories->where('status', \App\Models\WebinarAssignmentHistory::$pending)->count(); @endphp
                                    <tr class="text-center">
                                        <td class="text-left"><span class="text-dark font-weight-bold">{{ $assignment->title }}</span></td>
                                        <td>{{ !empty($assignment->webinar) ? $assignment->webinar->title : '-' }}</td>
                                        <td>{{ $pendingCount }}</td>
                                        <td><span class="badge {{ $assignment->status == 'active' ? 'badge-primary' : 'badge-warning' }}">{{ trans('admin/main.'.$assignment->status) }}</span></td>
                                        <td>{{ dateTimeFormat($assignment->created_at, 'j M Y') }}</td>
                                        <td>@can('admin_webinar_assignments_students')<a href="{{ getAdminPanelUrl("/assignments/{$assignment->id}/students") }}" class="btn-transparent"><x-iconsax-lin-profile-2user class="icons text-gray-500" width="20px" height="20px"/></a>@endcan</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                        <div class="card-footer text-center">{{ $assignments->appends(request()->input())->links() }}</div>
                    @else
                        @include('admin.includes.no-result',['file_name' => 'webinar.png','title' => trans('update.assignments'),'hint' => trans('update.no_result_default_hint')])
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
