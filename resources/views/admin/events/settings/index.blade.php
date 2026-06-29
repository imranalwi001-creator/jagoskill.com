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
                <div class="col-12 col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">{{ trans('update.events_settings') }}</h5>
                        </div>

                        <div class="card-body">
                            <form action="{{ getAdminPanelUrl('/events/settings') }}" method="post">
                                {{ csrf_field() }}
                                <input type="hidden" name="page" value="general">
                                <input type="hidden" name="name" value="{{ \App\Models\Setting::$eventsSettingsName }}">

                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="form-group custom-switches-stacked">
                                            <label class="custom-switch pl-0 d-flex align-items-center">
                                                <input type="hidden" name="value[status]" value="0">
                                                <input type="checkbox" name="value[status]" id="eventsStatusSwitch" value="1" {{ (!empty($values['status'])) ? 'checked="checked"' : '' }} class="custom-switch-input"/>
                                                <span class="custom-switch-indicator"></span>
                                                <label class="custom-switch-description mb-0 cursor-pointer" for="eventsStatusSwitch">{{ trans('admin/main.active') }}</label>
                                            </label>
                                            <div class="font-12 text-gray-500 mt-1">{{ trans('update.events_setting_active_hint') }}</div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <div class="form-group custom-switches-stacked">
                                            <label class="custom-switch pl-0 d-flex align-items-center">
                                                <input type="hidden" name="value[qr_status]" value="0">
                                                <input type="checkbox" name="value[qr_status]" id="eventsQrStatusSwitch" value="1" {{ (!empty($values['qr_status'])) ? 'checked="checked"' : '' }} class="custom-switch-input"/>
                                                <span class="custom-switch-indicator"></span>
                                                <label class="custom-switch-description mb-0 cursor-pointer" for="eventsQrStatusSwitch">{{ trans('update.enable_qr') }}</label>
                                            </label>
                                            <div class="font-12 text-gray-500 mt-1">{{ trans('update.events_setting_qr_switch_hint') }}</div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <div class="form-group custom-switches-stacked">
                                            <label class="custom-switch pl-0 d-flex align-items-center">
                                                <input type="hidden" name="value[event_recent_reviews_status]" value="0">
                                                <input type="checkbox" name="value[event_recent_reviews_status]" id="eventRecentReviewsStatusSwitch" value="1" {{ (!empty($values['event_recent_reviews_status'])) ? 'checked="checked"' : '' }} class="custom-switch-input"/>
                                                <span class="custom-switch-indicator"></span>
                                                <label class="custom-switch-description mb-0 cursor-pointer" for="eventRecentReviewsStatusSwitch">{{ trans('update.event_recent_reviews') }}</label>
                                            </label>
                                            <div class="font-12 text-gray-500 mt-1">{{ trans('update.event_recent_reviews_status_hint') }}</div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label class="input-label">{{ trans('update.ticket_card_style') }}</label>
                                            <select name="value[ticket_card_style]" class="form-control">
                                                <option value="grid" {{ (($values['ticket_card_style'] ?? 'grid') == 'grid') ? 'selected' : '' }}>{{ trans('update.grid') }}</option>
                                                <option value="list" {{ (($values['ticket_card_style'] ?? 'grid') == 'list') ? 'selected' : '' }}>{{ trans('update.lists') }}</option>
                                            </select>
                                            <div class="font-12 text-gray-500 mt-1">{{ trans('update.events_setting_ticket_card_style_input_hint') }}</div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label class="input-label">{{ trans('update.number_of_characters_ticket_code') }}</label>
                                            <input type="number" min="6" max="32" name="value[number_of_characters_ticket_code]" value="{{ $values['number_of_characters_ticket_code'] ?? 10 }}" class="form-control">
                                            <div class="font-12 text-gray-500 mt-1">{{ trans('update.number_of_characters_ticket_code_input_hint') }}</div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label class="input-label">{{ trans('update.ticket_code_format') }}</label>
                                            <select name="value[ticket_code_format]" class="form-control">
                                                <option value="both" {{ (($values['ticket_code_format'] ?? 'both') == 'both') ? 'selected' : '' }}>{{ trans('public.all') }}</option>
                                                <option value="numerical" {{ (($values['ticket_code_format'] ?? 'both') == 'numerical') ? 'selected' : '' }}>{{ trans('update.numerical') }}</option>
                                                <option value="textual" {{ (($values['ticket_code_format'] ?? 'both') == 'textual') ? 'selected' : '' }}>{{ trans('update.textual') }}</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label class="input-label">{{ trans('update.tickets_default_icon') }}</label>
                                            <input type="text" name="value[tickets_default_icon]" value="{{ $values['tickets_default_icon'] ?? 'bul-triangle' }}" class="form-control" placeholder="bul-triangle">
                                            <div class="font-12 text-gray-500 mt-1">{{ trans('update.default_icon') }}</div>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary">{{ trans('admin/main.save_change') }}</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">{{ trans('admin/main.status') }}</h5>
                        </div>

                        <div class="card-body">
                            @if(!empty($values['status']))
                                <div class="alert alert-success mb-0">{{ trans('update.events') }} {{ trans('admin/main.active') }}</div>
                            @else
                                <div class="alert alert-warning mb-0">{{ trans('update.events') }} {{ trans('admin/main.inactive') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">{{ trans('admin/main.actions') }}</h5>
                        </div>

                        <div class="card-body">
                            <a href="/events" target="_blank" class="btn btn-primary btn-block mb-2">{{ trans('update.events') }}</a>
                            <a href="{{ getAdminPanelUrl('/events') }}" class="btn btn-outline-primary btn-block">{{ trans('admin/main.list') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
