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
                <div class="col-lg-3 col-md-6 col-12"><div class="card-statistic"><div class="card-statistic__wrap"><span class="text-gray-500">{{ trans('update.total_courses') }}</span><h5 class="font-24 mt-12 text-black">{{ $totalCourses }}</h5></div></div></div>
                <div class="col-lg-3 col-md-6 col-12"><div class="card-statistic"><div class="card-statistic__wrap"><span class="text-gray-500">{{ trans('update.released_courses') }}</span><h5 class="font-24 mt-12 text-black">{{ $releasedCourses }}</h5></div></div></div>
                <div class="col-lg-3 col-md-6 col-12"><div class="card-statistic"><div class="card-statistic__wrap"><span class="text-gray-500">{{ trans('update.not_released') }}</span><h5 class="font-24 mt-12 text-black">{{ $notReleased }}</h5></div></div></div>
                <div class="col-lg-3 col-md-6 col-12"><div class="card-statistic"><div class="card-statistic__wrap"><span class="text-gray-500">{{ trans('update.followers') }}</span><h5 class="font-24 mt-12 text-black">{{ $followers }}</h5></div></div></div>
            </div>

            <section class="card mt-32">
                <div class="card-body pb-4">
                    <form method="get" class="mb-0">
                        <div class="row">
                            <div class="col-md-3"><div class="form-group"><label class="input-label">{{ trans('admin/main.search') }}</label><input name="title" type="text" class="form-control" value="{{ request()->get('title') }}"></div></div>
                            <div class="col-md-3"><div class="form-group"><label class="input-label">{{ trans('admin/main.start_date') }}</label><input name="from" type="date" class="form-control text-center" value="{{ request()->get('from') }}"></div></div>
                            <div class="col-md-3"><div class="form-group"><label class="input-label">{{ trans('admin/main.end_date') }}</label><input name="to" type="date" class="form-control text-center" value="{{ request()->get('to') }}"></div></div>
                            <div class="col-md-3"><div class="form-group"><label class="input-label">{{ trans('admin/main.status') }}</label><select name="status" class="form-control"><option value="">{{ trans('admin/main.all') }}</option><option value="active" {{ request()->get('status') == 'active' ? 'selected' : '' }}>{{ trans('admin/main.active') }}</option><option value="pending" {{ request()->get('status') == 'pending' ? 'selected' : '' }}>{{ trans('admin/main.pending') }}</option><option value="draft" {{ request()->get('status') == 'draft' ? 'selected' : '' }}>{{ trans('admin/main.draft') }}</option></select></div></div>
                            <div class="col-md-3"><div class="form-group"><label class="input-label">{{ trans('admin/main.category') }}</label><select name="category_id" class="form-control"><option value="">{{ trans('admin/main.all') }}</option>@foreach($categories as $category)<option value="{{ $category->id }}" {{ request()->get('category_id') == $category->id ? 'selected' : '' }}>{{ $category->title }}</option>@endforeach</select></div></div>
                            <div class="col-md-3 d-flex align-items-center"><button type="submit" class="btn btn-primary btn-block btn-lg">{{ trans('admin/main.show_results') }}</button></div>
                        </div>
                    </form>
                </div>
            </section>

            <div class="card mt-32">
                <div class="card-header justify-content-between">
                    <div><h5 class="font-14 mb-0">{{ trans('update.upcoming_courses') }}</h5><p class="font-12 mt-4 mb-0 text-gray-500">{{ trans('update.manage_all_items_in_a_single_place') }}</p></div>
                    @can('admin_upcoming_courses_create')<a href="{{ getAdminPanelUrl('/upcoming_courses/create') }}" class="btn btn-primary">{{ trans('admin/main.new') }}</a>@endcan
                </div>
                <div class="card-body">
                    @if(!empty($upcomingCourses) and $upcomingCourses->count())
                        <div class="table-responsive">
                            <table class="table custom-table font-14">
                                <tr><th class="text-left">{{ trans('admin/main.course') }}</th><th>{{ trans('admin/main.instructor') }}</th><th>{{ trans('update.followers') }}</th><th>{{ trans('admin/main.status') }}</th><th>{{ trans('update.release_status') }}</th><th>{{ trans('admin/main.actions') }}</th></tr>
                                @foreach($upcomingCourses as $course)
                                    <tr class="text-center">
                                        <td class="text-left"><a href="{{ $course->getUrl() }}" target="_blank" class="text-dark font-weight-bold">{{ $course->title }}</a><span class="d-block font-12 text-gray-500 mt-4">{{ dateTimeFormat($course->created_at, 'j M Y') }}</span></td>
                                        <td>{{ !empty($course->teacher) ? $course->teacher->full_name : '-' }}</td>
                                        <td>{{ $course->followers_count ?? 0 }}</td>
                                        <td><span class="badge {{ $course->status == 'active' ? 'badge-primary' : 'badge-warning' }}">{{ trans('admin/main.'.$course->status) }}</span></td>
                                        <td>{{ !empty($course->webinar_id) ? trans('update.released') : trans('update.not_released') }}</td>
                                        <td>
                                            <div class="btn-group dropdown table-actions position-relative">
                                                <button type="button" class="btn-transparent dropdown-toggle" data-toggle="dropdown"><x-iconsax-lin-more class="icons text-gray-500" width="20px" height="20px"/></button>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    @can('admin_upcoming_courses_edit')<a href="{{ getAdminPanelUrl("/upcoming_courses/{$course->id}/edit") }}" class="dropdown-item d-flex align-items-center py-3 px-0 gap-4"><x-iconsax-lin-edit-2 class="icons text-gray-500" width="18px" height="18px"/><span class="text-gray-500 font-14">{{ trans('admin/main.edit') }}</span></a>@endcan
                                                    @can('admin_upcoming_courses_followers')<a href="{{ getAdminPanelUrl("/upcoming_courses/{$course->id}/followers") }}" class="dropdown-item d-flex align-items-center py-3 px-0 gap-4"><x-iconsax-lin-profile-2user class="icons text-gray-500" width="18px" height="18px"/><span class="text-gray-500 font-14">{{ trans('update.followers') }}</span></a>@endcan
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                        <div class="card-footer text-center">{{ $upcomingCourses->appends(request()->input())->links() }}</div>
                    @else
                        @include('admin.includes.no-result',['file_name' => 'webinar.png','title' => trans('update.upcoming_courses'),'hint' => trans('update.no_result_default_hint')])
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
