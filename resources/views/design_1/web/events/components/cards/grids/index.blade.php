@php
    $cardName = getThemeContentCardStyle("event");
@endphp

@push('styles_top')
    @if(empty($withoutStyles))
        <link rel="stylesheet" href="{{ getDesign1StylePath("event_cards/{$cardName}") }}">
    @endif
@endpush

@if(!empty($events) and count($events))
    @foreach($events as $event)
        <div class="{{ !empty($gridCardClassName) ? $gridCardClassName : '' }}">
            @include("design_1.web.events.components.cards.grids.{$cardName}", ['event' => $event])
        </div>
    @endforeach
@else
    <div class="col-12">
        @include('design_1.panel.includes.no-result',[
            'file_name' => 'events.svg',
            'title' => trans('update.no_events!'),
            'hint' => nl2br(trans('update.there_are_no_events_on_your_website')),
            'btn' => [
                'url' => '/events',
                'text' => trans('update.events')
            ]
        ])
    </div>
@endif
