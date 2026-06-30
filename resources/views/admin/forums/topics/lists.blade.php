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
                            <div class="col-md-9"><div class="form-group"><label class="input-label">{{ trans('admin/main.search') }}</label><input name="search" type="text" class="form-control" value="{{ request()->get('search') }}"></div></div>
                            <div class="col-md-3 d-flex align-items-center"><button type="submit" class="btn btn-primary btn-block btn-lg">{{ trans('admin/main.show_results') }}</button></div>
                        </div>
                    </form>
                </div>
            </section>

            <div class="card mt-32">
                <div class="card-header justify-content-between">
                    <div><h5 class="font-14 mb-0">{{ trans('update.topics') }}</h5><p class="font-12 mt-4 mb-0 text-gray-500">{{ trans('update.manage_all_items_in_a_single_place') }}</p></div>
                    @can('admin_forum_topics_create')<a href="{{ getAdminPanelUrl('/forums/topics/create') }}" class="btn btn-primary">{{ trans('update.create_new_topic') }}</a>@endcan
                </div>
                <div class="card-body">
                    @if(!empty($topics) and $topics->count())
                        <div class="table-responsive">
                            <table class="table custom-table font-14">
                                <tr><th class="text-left">{{ trans('update.topic') }}</th><th>{{ trans('admin/main.creator') }}</th><th>{{ trans('update.posts') }}</th><th>{{ trans('update.last_post') }}</th><th>{{ trans('public.date') }}</th></tr>
                                @foreach($topics as $topic)
                                    <tr class="text-center">
                                        <td class="text-left"><span class="text-dark font-weight-bold">{{ $topic->title }}</span><span class="d-block mt-4 font-12 text-gray-500">{{ \Illuminate\Support\Str::limit(strip_tags($topic->description), 90) }}</span></td>
                                        <td>{{ !empty($topic->creator) ? $topic->creator->full_name : '-' }}</td>
                                        <td>{{ $topic->posts_count ?? 0 }}</td>
                                        <td>{{ !empty($topic->lastPost) ? dateTimeFormat($topic->lastPost->created_at, 'j M Y H:i') : '-' }}</td>
                                        <td>{{ dateTimeFormat($topic->created_at, 'j M Y') }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                        <div class="card-footer text-center">{{ $topics->appends(request()->input())->links() }}</div>
                    @else
                        @include('admin.includes.no-result',['file_name' => 'comment.png','title' => trans('update.topics'),'hint' => trans('update.no_result_default_hint')])
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
