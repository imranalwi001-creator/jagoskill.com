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
                <div class="col-12 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            @can('admin_course_question_forum_list')
                                <h4>{{ trans('update.courses') }}</h4>
                            @endcan
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped font-14">
                                    <tr>
                                        <th class="text-left">{{ trans('admin/main.title') }}</th>
                                        <th class="text-left">{{ trans('admin/main.instructor') }}</th>
                                        <th class="text-center">{{ trans('update.questions') }}</th>
                                        <th class="text-right">{{ trans('admin/main.actions') }}</th>
                                    </tr>
                                    
                                    @foreach($webinars as $webinar)
                                        <tr>
                                            <td class="text-left">
                                                <a href="{{ $webinar->getUrl() }}" target="_blank">{{ $webinar->title }}</a>
                                            </td>
                                            <td class="text-left">{{ $webinar->teacher->full_name ?? '' }}</td>
                                            <td class="text-center">{{ $webinar->forums_count }}</td>
                                            
                                            <td class="text-right">
                                                <a href="{{ getAdminPanelUrl() }}/webinars/{{ $webinar->id }}/forums" class="btn-transparent text-primary" data-toggle="tooltip" data-placement="top" title="{{ trans('admin/main.forums') }}">
                                                    <i class="fa fa-comments"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>

                        <div class="card-footer text-center">
                            {{ $webinars->appends(request()->input())->links() }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
