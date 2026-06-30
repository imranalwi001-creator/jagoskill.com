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
                <div class="col-lg-3 col-md-6 col-12"><div class="card-statistic"><div class="card-statistic__wrap"><span class="text-gray-500">{{ trans('update.forums') }}</span><h5 class="font-24 mt-12 text-black">{{ $totalForums }}</h5></div></div></div>
                <div class="col-lg-3 col-md-6 col-12"><div class="card-statistic"><div class="card-statistic__wrap"><span class="text-gray-500">{{ trans('update.topics') }}</span><h5 class="font-24 mt-12 text-black">{{ $totalTopics }}</h5></div></div></div>
                <div class="col-lg-3 col-md-6 col-12"><div class="card-statistic"><div class="card-statistic__wrap"><span class="text-gray-500">{{ trans('update.posts') }}</span><h5 class="font-24 mt-12 text-black">{{ $postsCount }}</h5></div></div></div>
                <div class="col-lg-3 col-md-6 col-12"><div class="card-statistic"><div class="card-statistic__wrap"><span class="text-gray-500">{{ trans('update.members') }}</span><h5 class="font-24 mt-12 text-black">{{ $membersCount }}</h5></div></div></div>
            </div>

            <div class="card mt-32">
                <div class="card-header justify-content-between">
                    <div><h5 class="font-14 mb-0">{{ trans('update.forums') }}</h5><p class="font-12 mt-4 mb-0 text-gray-500">{{ trans('update.manage_all_items_in_a_single_place') }}</p></div>
                    @can('admin_forum_create')<a href="{{ getAdminPanelUrl('/forums/create') }}" class="btn btn-primary">{{ trans('update.new_forum') }}</a>@endcan
                </div>
                <div class="card-body">
                    @if(!empty($forums) and $forums->count())
                        <div class="table-responsive">
                            <table class="table custom-table font-14">
                                <tr><th class="text-left">{{ trans('update.forum') }}</th><th>{{ trans('update.sub_forums') }}</th><th>{{ trans('update.topics') }}</th><th>{{ trans('update.posts') }}</th><th>{{ trans('admin/main.status') }}</th><th>{{ trans('admin/main.actions') }}</th></tr>
                                @foreach($forums as $forum)
                                    <tr class="text-center">
                                        <td class="text-left"><span class="text-dark font-weight-bold">{{ $forum->title }}</span><span class="d-block mt-4 font-12 text-gray-500">{{ $forum->description }}</span></td>
                                        <td>{{ $forum->subForums->count() }}</td>
                                        <td>{{ $forum->topics_count ?? 0 }}</td>
                                        <td>{{ $forum->posts_count ?? 0 }}</td>
                                        <td><span class="badge {{ $forum->status == 'active' ? 'badge-primary' : 'badge-warning' }}">{{ trans('admin/main.'.$forum->status) }}</span></td>
                                        <td>@can('admin_forum_edit')<a href="{{ getAdminPanelUrl("/forums/{$forum->id}/edit") }}" class="btn-transparent"><x-iconsax-lin-edit-2 class="icons text-gray-500" width="20px" height="20px"/></a>@endcan</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                        <div class="card-footer text-center">{{ $forums->appends(request()->input())->links() }}</div>
                    @else
                        @include('admin.includes.no-result',['file_name' => 'comment.png','title' => trans('update.forums'),'hint' => trans('update.no_result_default_hint')])
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
