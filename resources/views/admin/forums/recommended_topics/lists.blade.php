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
                    <div><h5 class="font-14 mb-0">{{ trans('update.recommended_topics') }}</h5><p class="font-12 mt-4 mb-0 text-gray-500">{{ trans('update.manage_all_items_in_a_single_place') }}</p></div>
                    @can('admin_recommended_topics_create')<a href="{{ getAdminPanelUrl('/recommended-topics/create') }}" class="btn btn-primary">{{ trans('admin/main.new') }}</a>@endcan
                </div>
                <div class="card-body">
                    @if(!empty($recommendedTopics) and $recommendedTopics->count())
                        <div class="table-responsive">
                            <table class="table custom-table font-14">
                                <tr><th class="text-left">{{ trans('admin/main.title') }}</th><th>{{ trans('update.topics') }}</th><th>{{ trans('public.date') }}</th><th>{{ trans('admin/main.actions') }}</th></tr>
                                @foreach($recommendedTopics as $recommended)
                                    <tr class="text-center">
                                        <td class="text-left"><span class="font-weight-bold text-dark">{{ $recommended->title }}</span><span class="d-block font-12 text-gray-500 mt-4">{{ $recommended->subtitle }}</span></td>
                                        <td>{{ $recommended->topics->count() }}</td>
                                        <td>{{ dateTimeFormat($recommended->created_at, 'j M Y') }}</td>
                                        <td>@can('admin_recommended_topics_edit')<a href="{{ getAdminPanelUrl("/recommended-topics/{$recommended->id}/edit") }}" class="btn-transparent"><x-iconsax-lin-edit-2 class="icons text-gray-500" width="20px" height="20px"/></a>@endcan</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                        <div class="card-footer text-center">{{ $recommendedTopics->appends(request()->input())->links() }}</div>
                    @else
                        @include('admin.includes.no-result',['file_name' => 'comment.png','title' => trans('update.recommended_topics'),'hint' => trans('update.no_result_default_hint')])
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
