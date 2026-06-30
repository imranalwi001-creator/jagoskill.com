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
            <div class="card">
                <div class="card-header justify-content-between">
                    <div><h5 class="font-14 mb-0">{{ trans('admin/main.templates') }}</h5><p class="font-12 mt-4 mb-0 text-gray-500">{{ trans('update.manage_all_items_in_a_single_place') }}</p></div>
                    @can('admin_certificate_template_create')<a href="{{ getAdminPanelUrl('/certificates/templates/new') }}" class="btn btn-primary">{{ trans('admin/main.new_template') }}</a>@endcan
                </div>
                <div class="card-body">
                    @if(!empty($templates) and $templates->count())
                        <div class="table-responsive">
                            <table class="table custom-table font-14">
                                <tr><th class="text-left">{{ trans('admin/main.title') }}</th><th>{{ trans('admin/main.type') }}</th><th>{{ trans('admin/main.status') }}</th><th>{{ trans('public.date') }}</th><th>{{ trans('admin/main.actions') }}</th></tr>
                                @foreach($templates as $template)
                                    <tr class="text-center">
                                        <td class="text-left">{{ $template->title }}</td>
                                        <td>{{ trans('admin/main.'.$template->type) }}</td>
                                        <td><span class="badge {{ !empty($template->status) ? 'badge-primary' : 'badge-warning' }}">{{ !empty($template->status) ? trans('admin/main.active') : trans('admin/main.inactive') }}</span></td>
                                        <td>{{ dateTimeFormat($template->created_at, 'j M Y') }}</td>
                                        <td>@can('admin_certificate_template_edit')<a href="{{ getAdminPanelUrl("/certificates/templates/{$template->id}/edit") }}" class="btn-transparent"><x-iconsax-lin-edit-2 class="icons text-gray-500" width="20px" height="20px"/></a>@endcan</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                        <div class="card-footer text-center">{{ $templates->appends(request()->input())->links() }}</div>
                    @else
                        @include('admin.includes.no-result',['file_name' => 'cert.png','title' => trans('admin/main.templates'),'hint' => trans('update.no_result_default_hint')])
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
