@extends('admin.layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ $pageTitle }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}">{{ trans('admin/main.dashboard') }}</a></div>
                <div class="breadcrumb-item"><a href="{{ getAdminPanelUrl() }}/webinars/course_forums">{{ trans('update.course_forums') }}</a></div>
                <div class="breadcrumb-item"><a href="{{ getAdminPanelUrl() }}/webinars/{{ $course->id }}/forums">{{ trans('update.questions') }}</a></div>
                <div class="breadcrumb-item">{{ $pageTitle }}</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>{{ trans('update.question_title') }}: {{ $question->title }}</h4>
                        </div>
                        <div class="card-body">
                            <p>{!! nl2br(e($question->description)) !!}</p>
                        </div>
                    </div>
                    
                    <div class="card mt-3">
                        <div class="card-header">
                            @can('admin_course_question_forum_list')
                                <h4>{{ trans('public.answers') }}</h4>
                            @endcan
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped font-14">
                                    <tr>
                                        <th class="text-left">{{ trans('admin/main.user') }}</th>
                                        <th class="text-left">{{ trans('public.answer') }}</th>
                                        <th class="text-center">{{ trans('admin/main.status') }}</th>
                                        <th class="text-center">{{ trans('public.date') }}</th>
                                        <th class="text-right">{{ trans('admin/main.actions') }}</th>
                                    </tr>
                                    
                                    @foreach($answers as $answer)
                                        <tr>
                                            <td class="text-left">{{ $answer->user->full_name ?? '' }}</td>
                                            <td class="text-left" width="50%">
                                                {!! nl2br(e($answer->description)) !!}
                                            </td>
                                            <td class="text-center">
                                                @if($answer->resolved)
                                                    <span class="text-success">{{ trans('update.resolved') }}</span>
                                                @else
                                                    <span class="text-warning">{{ trans('admin/main.active') }}</span>
                                                @endif
                                            </td>
                                            <td class="text-center">{{ dateTimeFormat($answer->created_at, 'j M Y H:i') }}</td>
                                            
                                            <td class="text-right">
                                                @include('admin.includes.delete_button',[
                                                    'url' => getAdminPanelUrl("/webinars/{$course->id}/forums/{$question->id}/answers/{$answer->id}/delete"),
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

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
