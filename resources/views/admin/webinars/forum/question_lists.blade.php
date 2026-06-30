@extends('admin.layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ $pageTitle }} ({{ $webinar->title }})</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}">{{ trans('admin/main.dashboard') }}</a></div>
                <div class="breadcrumb-item"><a href="{{ getAdminPanelUrl() }}/webinars/course_forums">{{ trans('update.course_forums') }}</a></div>
                <div class="breadcrumb-item">{{ $pageTitle }}</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="card-statistic">
                        <div class="card-statistic__mask"></div>
                        <div class="card-statistic__wrap">
                            <div class="d-flex align-items-start justify-content-between">
                                <span class="text-gray-500 mt-8">{{trans('update.total_questions')}}</span>
                                <div class="d-flex-center size-48 bg-primary-30 rounded-12">
                                    <i class="fa fa-question-circle text-primary"></i>
                                </div>
                            </div>
                            <h5 class="font-24 mt-12 line-height-1 text-black">{{ $totalQuestions }}</h5>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="card-statistic">
                        <div class="card-statistic__mask"></div>
                        <div class="card-statistic__wrap">
                            <div class="d-flex align-items-start justify-content-between">
                                <span class="text-gray-500 mt-8">{{trans('update.resolved_questions')}}</span>
                                <div class="d-flex-center size-48 bg-success-30 rounded-12">
                                    <i class="fa fa-check-circle text-success"></i>
                                </div>
                            </div>
                            <h5 class="font-24 mt-12 line-height-1 text-black">{{ $resolvedCount }}</h5>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="card-statistic">
                        <div class="card-statistic__mask"></div>
                        <div class="card-statistic__wrap">
                            <div class="d-flex align-items-start justify-content-between">
                                <span class="text-gray-500 mt-8">{{trans('update.not_resolved_questions')}}</span>
                                <div class="d-flex-center size-48 bg-warning-30 rounded-12">
                                    <i class="fa fa-times-circle text-warning"></i>
                                </div>
                            </div>
                            <h5 class="font-24 mt-12 line-height-1 text-black">{{ $notResolvedCount }}</h5>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            @can('admin_course_question_forum_list')
                                <h4>{{ trans('update.questions') }}</h4>
                            @endcan
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped font-14">
                                    <tr>
                                        <th class="text-left">{{ trans('admin/main.title') }}</th>
                                        <th class="text-left">{{ trans('admin/main.user') }}</th>
                                        <th class="text-center">{{ trans('public.answers') }}</th>
                                        <th class="text-center">{{ trans('admin/main.status') }}</th>
                                        <th class="text-center">{{ trans('public.date') }}</th>
                                        <th class="text-right">{{ trans('admin/main.actions') }}</th>
                                    </tr>
                                    
                                    @foreach($forums as $forum)
                                        <tr>
                                            <td class="text-left">
                                                <span>{{ $forum->title }}</span>
                                            </td>
                                            <td class="text-left">{{ $forum->user->full_name ?? '' }}</td>
                                            <td class="text-center">{{ $forum->answers_count }}</td>
                                            <td class="text-center">
                                                @if($forum->pin)
                                                    <span class="text-primary">{{ trans('update.pinned') }}</span><br>
                                                @endif
                                                @if($forum->resolved)
                                                    <span class="text-success">{{ trans('update.resolved') }}</span>
                                                @else
                                                    <span class="text-warning">{{ trans('update.not_resolved') }}</span>
                                                @endif
                                            </td>
                                            <td class="text-center">{{ dateTimeFormat($forum->created_at, 'j M Y') }}</td>
                                            
                                            <td class="text-right">
                                                <a href="{{ getAdminPanelUrl() }}/webinars/{{ $webinar->id }}/forums/{{ $forum->id }}/answers" class="btn-transparent text-primary" data-toggle="tooltip" data-placement="top" title="{{ trans('public.answers') }}">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                
                                                @include('admin.includes.delete_button',[
                                                    'url' => getAdminPanelUrl("/webinars/{$webinar->id}/forums/{$forum->id}/delete"),
                                                    'btnClass' => 'btn-sm btn-transparent text-primary mt-1',
                                                    'btnIcon' => 'trash',
                                                    'iconType' => 'lin',
                                                    'iconClass' => 'text-danger',
                                                ])
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>

                        <div class="card-footer text-center">
                            {{ $forums->appends(request()->input())->links() }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
