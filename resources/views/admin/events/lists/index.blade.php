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
            @include('admin.events.lists.top_stats')

            @include('admin.events.lists.filters')

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header justify-content-between">
                            <div>
                                <h5 class="font-14 mb-0">{{ trans('update.events') }}</h5>
                                <p class="font-12 mt-4 mb-0 text-gray-500">{{ trans('update.manage_all_events_in_a_single_place') }}</p>
                            </div>

                            @can('admin_events_create')
                                <a href="{{ getAdminPanelUrl('/events/create') }}" class="btn btn-primary">
                                    <x-iconsax-lin-add class="icons text-white" width="18px" height="18px"/>
                                    <span class="ml-4 font-12">{{ trans('update.new_event') }}</span>
                                </a>
                            @endcan
                        </div>

                        <div class="card-body">
                            @if(!empty($events) and $events->count())
                                <div class="table-responsive">
                                    <table class="table custom-table font-14">
                                        <tr>
                                            <th class="text-left">{{ trans('update.events') }}</th>
                                            <th class="text-left">{{ trans('public.instructor') }}</th>
                                            <th>{{ trans('update.event_type') }}</th>
                                            <th>{{ trans('public.price') }}</th>
                                            <th>{{ trans('public.capacity') }}</th>
                                            <th>{{ trans('update.sold_tickets') }}</th>
                                            <th>{{ trans('admin/main.start_date') }}</th>
                                            <th>{{ trans('admin/main.created_at') }}</th>
                                            <th>{{ trans('admin/main.status') }}</th>
                                            <th>{{ trans('admin/main.actions') }}</th>
                                        </tr>

                                        @foreach($events as $event)
                                            @include('admin.events.lists.table_items', ['event' => $event])
                                        @endforeach
                                    </table>
                                </div>

                                <div class="card-footer text-center">
                                    {{ $events->appends(request()->input())->links() }}
                                </div>
                            @else
                                @include('admin.includes.no-result',[
                                    'file_name' => 'ticket.png',
                                    'title' => trans('update.no_events!'),
                                    'hint' => trans('update.there_are_no_events_on_your_website'),
                                    'btn' => [
                                        'url' => getAdminPanelUrl('/events/create'),
                                        'text' => trans('update.new_event'),
                                    ],
                                ])
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
