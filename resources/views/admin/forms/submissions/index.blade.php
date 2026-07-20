@extends('admin.layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ $pageTitle }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}">{{trans('admin/main.dashboard')}}</a></div>
                <div class="breadcrumb-item">{{ $pageTitle }}</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped font-14">
                                    <tr>
                                        <th>{{ trans('admin/main.form') }}</th>
                                        <th>{{ trans('admin/main.user') }}</th>
                                        <th class="text-center">{{ trans('admin/main.created_at') }}</th>
                                        <th>{{ trans('admin/main.actions') }}</th>
                                    </tr>

                                    @foreach($submissions as $submission)
                                        <tr>
                                            <td>
                                                @if(!empty($submission->form))
                                                    <span class="d-block font-weight-bold">{{ $submission->form->title }}</span>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                @if(!empty($submission->user))
                                                    <a href="{{ getAdminPanelUrl() }}/users/{{ $submission->user_id }}/edit" target="_blank">{{ $submission->user->full_name }}</a>
                                                @else
                                                    <span class="text-muted">{{ trans('update.guest') }}</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                {{ dateTimeFormat($submission->created_at, 'j M Y H:i') }}
                                            </td>
                                            <td>
                                                @can('admin_forms_submissions')
                                                    <a href="{{ getAdminPanelUrl() }}/forms/submissions/{{ $submission->id }}/details" class="btn-transparent btn-sm text-primary mr-1" data-toggle="tooltip" data-placement="top" title="{{ trans('admin/main.show') }}">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                @endcan
                                                @can('admin_forms_submissions_delete')
                                                    @include('admin.includes.delete_button',['url' => getAdminPanelUrl('/forms/submissions/'.$submission->id.'/delete') , 'btnClass' => ''])
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>

                            <div class="card-footer text-center">
                                {{ $submissions->appends(request()->input())->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
