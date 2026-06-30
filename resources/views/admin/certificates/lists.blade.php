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
                            <div class="col-md-3"><div class="form-group"><label class="input-label">{{ trans('quiz.quiz') }}</label><input name="quiz_title" type="text" class="form-control" value="{{ request()->get('quiz_title') }}"></div></div>
                            <div class="col-md-3"><div class="form-group"><label class="input-label">{{ trans('admin/main.student') }}</label><select name="student_ids[]" multiple class="form-control search-user-select2" data-search-option="just_student_role">@if(!empty($students)) @foreach($students as $student) <option value="{{ $student->id }}" selected>{{ $student->full_name }}</option> @endforeach @endif</select></div></div>
                            <div class="col-md-3"><div class="form-group"><label class="input-label">{{ trans('admin/main.instructor') }}</label><select name="teacher_ids[]" multiple class="form-control search-user-select2" data-search-option="just_teacher_role">@if(!empty($teachers)) @foreach($teachers as $teacher) <option value="{{ $teacher->id }}" selected>{{ $teacher->full_name }}</option> @endforeach @endif</select></div></div>
                            <div class="col-md-3 d-flex align-items-center"><button type="submit" class="btn btn-primary btn-block btn-lg">{{ trans('admin/main.show_results') }}</button></div>
                        </div>
                    </form>
                </div>
            </section>

            <div class="card mt-32">
                <div class="card-header justify-content-between">
                    <div><h5 class="font-14 mb-0">{{ trans('admin/main.certificates') }}</h5><p class="font-12 mt-4 mb-0 text-gray-500">{{ trans('update.manage_all_items_in_a_single_place') }}</p></div>
                    @can('admin_certificate_export')<a href="{{ getAdminPanelUrl('/certificates/excel') }}?{{ http_build_query(request()->all()) }}" class="btn bg-white bg-hover-gray-100 border-gray-400 text-gray-500">{{ trans('admin/main.export_xls') }}</a>@endcan
                </div>
                <div class="card-body">
                    @if(!empty($certificates) and $certificates->count())
                        <div class="table-responsive">
                            <table class="table custom-table font-14">
                                <tr><th>{{ trans('public.certificate_id') }}</th><th class="text-left">{{ trans('quiz.quiz') }}</th><th>{{ trans('admin/main.course') }}</th><th>{{ trans('admin/main.student') }}</th><th>{{ trans('quiz.grade') }}</th><th>{{ trans('public.date') }}</th><th>{{ trans('admin/main.actions') }}</th></tr>
                                @foreach($certificates as $certificate)
                                    <tr class="text-center">
                                        <td>{{ $certificate->id }}</td>
                                        <td class="text-left">{{ !empty($certificate->quiz) ? $certificate->quiz->title : '-' }}</td>
                                        <td>{{ (!empty($certificate->quiz) and !empty($certificate->quiz->webinar)) ? $certificate->quiz->webinar->title : '-' }}</td>
                                        <td>{{ !empty($certificate->student) ? $certificate->student->full_name : '-' }}</td>
                                        <td>{{ !empty($certificate->quizzesResult) ? $certificate->quizzesResult->user_grade : '-' }}</td>
                                        <td>{{ dateTimeFormat($certificate->created_at, 'j M Y') }}</td>
                                        <td><a href="{{ getAdminPanelUrl("/certificates/{$certificate->id}/download") }}" target="_blank" class="btn-transparent"><x-iconsax-lin-import-2 class="icons text-gray-500" width="20px" height="20px"/></a></td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                        <div class="card-footer text-center">{{ $certificates->appends(request()->input())->links() }}</div>
                    @else
                        @include('admin.includes.no-result',['file_name' => 'cert.png','title' => trans('admin/main.certificates'),'hint' => trans('update.no_result_default_hint')])
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
