@extends('admin.layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ $pageTitle }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}">{{ trans('admin/main.dashboard') }}</a></div>
                <div class="breadcrumb-item"><a href="{{ getAdminPanelUrl('/events') }}">{{ trans('update.events') }}</a></div>
                <div class="breadcrumb-item">{{ trans('update.sold_tickets') }}</div>
            </div>
        </div>

        <div class="section-body">
            @include('admin.events.sold_tickets.filters')

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header justify-content-between">
                            <div>
                                <h5 class="font-14 mb-0">{{ trans('update.sold_tickets') }}</h5>
                                <p class="font-12 mt-4 mb-0 text-gray-500">{{ trans('update.event_sold_tickets_no_result_hint') }}</p>
                            </div>

                            <a href="{{ getAdminPanelUrl('/events') }}" class="btn btn-outline-primary">
                                <x-iconsax-lin-ticket class="icons text-primary" width="18px" height="18px"/>
                                <span class="ml-4 font-12">{{ trans('update.events') }}</span>
                            </a>
                        </div>

                        <div class="card-body">
                            @if(!empty($purchasedTickets) and $purchasedTickets->count())
                                <div class="table-responsive">
                                    <table class="table custom-table font-14">
                                        <tr>
                                            @if(empty($selectedEvent))
                                                <th class="text-left">{{ trans('update.events') }}</th>
                                            @endif
                                            <th class="text-left">{{ trans('update.participant') }}</th>
                                            <th>{{ trans('update.ticket_types') }}</th>
                                            <th>{{ trans('public.paid_amount') }}</th>
                                            <th>{{ trans('update.ticket_code') }}</th>
                                            <th>{{ trans('update.purchase_date') }}</th>
                                            <th>{{ trans('admin/main.actions') }}</th>
                                        </tr>

                                        @foreach($purchasedTickets as $purchasedTicket)
                                            @include('admin.events.sold_tickets.table_items', [
                                                'purchasedTicket' => $purchasedTicket,
                                                'selectedEvent' => $selectedEvent,
                                            ])
                                        @endforeach
                                    </table>
                                </div>

                                <div class="card-footer text-center">
                                    {{ $purchasedTickets->appends(request()->input())->links() }}
                                </div>
                            @else
                                @include('admin.includes.no-result',[
                                    'file_name' => 'ticket.png',
                                    'title' => trans('update.event_sold_tickets_no_result'),
                                    'hint' => trans('update.event_sold_tickets_no_result_hint'),
                                    'btn' => [
                                        'url' => getAdminPanelUrl('/events'),
                                        'text' => trans('update.events'),
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
