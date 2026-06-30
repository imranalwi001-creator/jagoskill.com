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
                <div class="col-lg-3 col-md-6 col-12"><div class="card-statistic"><div class="card-statistic__wrap"><span class="text-gray-500">{{ trans('quiz.quizzes') }}</span><h5 class="font-24 mt-12 text-black">{{ $totalQuizzes }}</h5></div></div></div>
                <div class="col-lg-3 col-md-6 col-12"><div class="card-statistic"><div class="card-statistic__wrap"><span class="text-gray-500">{{ trans('admin/main.active') }}</span><h5 class="font-24 mt-12 text-black">{{ $totalActiveQuizzes }}</h5></div></div></div>
                <div class="col-lg-3 col-md-6 col-12"><div class="card-statistic"><div class="card-statistic__wrap"><span class="text-gray-500">{{ trans('quiz.students') }}</span><h5 class="font-24 mt-12 text-black">{{ $totalStudents }}</h5></div></div></div>
                <div class="col-lg-3 col-md-6 col-12"><div class="card-statistic"><div class="card-statistic__wrap"><span class="text-gray-500">{{ trans('quiz.passed') }}</span><h5 class="font-24 mt-12 text-black">{{ $totalPassedStudents }}</h5></div></div></div>
            </div>

            <section class="card mt-32">
                <div class="card-body pb-4">
                    <form method="get" class="mb-0">
                        <div class="row">
                            <div class="col-md-3"><div class="form-group"><label class="input-label">{{ trans('admin/main.search') }}</label><input name="title" type="text" class="form-control" value="{{ request()->get('title') }}"></div></div>
                            <div class="col-md-3"><div class="form-group"><label class="input-label">{{ trans('admin/main.start_date') }}</label><input name="from" type="date" class="form-control text-center" value="{{ request()->get('from') }}"></div></div>
                            <div class="col-md-3"><div class="form-group"><label class="input-label">{{ trans('admin/main.end_date') }}</label><input name="to" type="date" class="form-control text-center" value="{{ request()->get('to') }}"></div></div>
                            <div class="col-md-3"><div class="form-group"><label class="input-label">{{ trans('admin/main.status') }}</label><select name="status" class="form-control"><option value="">{{ trans('admin/main.all') }}</option><option value="active" {{ request()->get('status') == 'active' ? 'selected' : '' }}>{{ trans('admin/main.active') }}</option><option value="inactive" {{ request()->get('status') == 'inactive' ? 'selected' : '' }}>{{ trans('admin/main.inactive') }}</option></select></div></div>
                            <div class="col-md-3 d-flex align-items-center"><button type="submit" class="btn btn-primary btn-block btn-lg">{{ trans('admin/main.show_results') }}</button></div>
                        </div>
                    </form>
                </div>
            </section>

            <div class="card mt-32">
                <div class="card-header justify-content-between">
                    <div><h5 class="font-14 mb-0">{{ trans('quiz.quizzes') }}</h5><p class="font-12 mt-4 mb-0 text-gray-500">{{ trans('update.manage_all_items_in_a_single_place') }}</p></div>
                    @can('admin_quizzes_create')<a href="{{ getAdminPanelUrl('/quizzes/create') }}" class="btn btn-primary">{{ trans('quiz.new_quiz') }}</a>@endcan
                </div>
                <div class="card-body">
                    @if(!empty($quizzes) and $quizzes->count())
                        <div class="table-responsive">
                            <table class="table custom-table font-14">
                                <tr><th class="text-left">{{ trans('quiz.quiz') }}</th><th>{{ trans('admin/main.course') }}</th><th>{{ trans('admin/main.instructor') }}</th><th>{{ trans('quiz.questions') }}</th><th>{{ trans('quiz.results') }}</th><th>{{ trans('quiz.certificate') }}</th><th>{{ trans('admin/main.status') }}</th><th>{{ trans('admin/main.actions') }}</th></tr>
                                @foreach($quizzes as $quiz)
                                    <tr class="text-center">
                                        <td class="text-left"><span class="text-dark font-weight-bold">{{ $quiz->title }}</span><span class="d-block font-12 text-gray-500 mt-4">{{ dateTimeFormat($quiz->created_at, 'j M Y') }}</span></td>
                                        <td>{{ !empty($quiz->webinar) ? $quiz->webinar->title : '-' }}</td>
                                        <td>{{ !empty($quiz->teacher) ? $quiz->teacher->full_name : '-' }}</td>
                                        <td>{{ $quiz->quizQuestions->count() }}</td>
                                        <td>{{ $quiz->quizResults->count() }}</td>
                                        <td>{{ !empty($quiz->certificate) ? trans('admin/main.yes') : trans('admin/main.no') }}</td>
                                        <td><span class="badge {{ $quiz->status == 'active' ? 'badge-primary' : 'badge-warning' }}">{{ trans('admin/main.'.$quiz->status) }}</span></td>
                                        <td>@can('admin_quizzes_edit')<a href="{{ getAdminPanelUrl("/quizzes/{$quiz->id}/edit") }}" class="btn-transparent"><x-iconsax-lin-edit-2 class="icons text-gray-500" width="20px" height="20px"/></a>@endcan</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                        <div class="card-footer text-center">{{ $quizzes->appends(request()->input())->links() }}</div>
                    @else
                        @include('admin.includes.no-result',['file_name' => 'quiz.png','title' => trans('quiz.quizzes'),'hint' => trans('update.no_result_default_hint')])
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
