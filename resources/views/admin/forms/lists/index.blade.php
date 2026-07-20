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
                        <div class="card-header">
                            @can('admin_forms_create')
                                <a href="{{ getAdminPanelUrl() }}/forms/create" class="btn btn-success">{{ trans('admin/main.add_new') }}</a>
                            @endcan
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped font-14">
                                    <tr>
                                        <th>{{ trans('admin/main.title') }}</th>
                                        <th class="text-center">{{ trans('update.fields') }}</th>
                                        <th class="text-center">{{ trans('update.submissions') }}</th>
                                        <th class="text-center">{{ trans('update.users') }}</th>
                                        <th class="text-center">{{ trans('admin/main.start_date') }}</th>
                                        <th class="text-center">{{ trans('admin/main.end_date') }}</th>
                                        <th class="text-center">{{ trans('admin/main.status') }}</th>
                                        <th>{{ trans('admin/main.actions') }}</th>
                                    </tr>

                                    @foreach($forms as $form)
                                        <tr>
                                            <td>
                                                <span class="d-block font-weight-bold">{{ $form->title }}</span>
                                            </td>
                                            <td class="text-center">{{ $form->fields_count }}</td>
                                            <td class="text-center">{{ $form->submissions_count }}</td>
                                            <td class="text-center">{{ $form->users_count }}</td>
                                            <td class="text-center">
                                                {{ !empty($form->start_date) ? dateTimeFormat($form->start_date, 'j M Y') : '-' }}
                                            </td>
                                            <td class="text-center">
                                                {{ !empty($form->end_date) ? dateTimeFormat($form->end_date, 'j M Y') : '-' }}
                                            </td>
                                            <td class="text-center">
                                                @if($form->enable)
                                                    <span class="text-success">{{ trans('admin/main.active') }}</span>
                                                @else
                                                    <span class="text-danger">{{ trans('admin/main.inactive') }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @can('admin_forms_submissions')
                                                    <a href="{{ getAdminPanelUrl() }}/forms/{{ $form->id }}/submissions" class="btn-transparent btn-sm text-primary mr-1" data-toggle="tooltip" data-placement="top" title="{{ trans('update.submissions') }}">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                @endcan
                                                @can('admin_forms_edit')
                                                    <a href="{{ getAdminPanelUrl() }}/forms/{{ $form->id }}/edit" class="btn-transparent btn-sm text-primary mr-1" data-toggle="tooltip" data-placement="top" title="{{ trans('admin/main.edit') }}">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                @endcan
                                                @can('admin_forms_delete')
                                                    @include('admin.includes.delete_button',['url' => getAdminPanelUrl('/forms/'.$form->id.'/delete') , 'btnClass' => ''])
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>

                            <div class="card-footer text-center">
                                {{ $forms->appends(request()->input())->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
