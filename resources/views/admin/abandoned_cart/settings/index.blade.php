@extends('admin.layouts.app')

@push('styles_top')
    <link rel="stylesheet" href="/assets/default/vendors/select2/select2.min.css">
@endpush

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
                <div class="col-12 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            
                            @php
                                $itemValue = (!empty($setting) and !empty($setting->value)) ? json_decode($setting->value, true) : [];
                            @endphp

                            <form action="{{ getAdminPanelUrl() }}/settings/abandoned_cart_settings" method="post">
                                {{ csrf_field() }}
                                <input type="hidden" name="page" value="general">

                                <div class="row">
                                    <div class="col-12 col-md-6">
                                    
                                        <div class="form-group custom-switches-stacked mb-4">
                                            <label class="custom-switch pl-0">
                                                <input type="hidden" name="value[status]" value="0">
                                                <input type="checkbox" name="value[status]" id="statusSwitch" value="1"
                                                       {{ (!empty($itemValue) and !empty($itemValue['status']) and $itemValue['status']) ? 'checked="checked"' : '' }} class="custom-switch-input"/>
                                                <span class="custom-switch-indicator"></span>
                                                <label class="custom-switch-description mb-0 cursor-pointer"
                                                       for="statusSwitch">{{ trans('admin/main.active') }}</label>
                                            </label>
                                            <div class="text-muted text-small mt-1">{{ trans('update.abandoned_cart_setting_status_hint') }}</div>
                                        </div>

                                        <div class="form-group custom-switches-stacked mb-4">
                                            <label class="custom-switch pl-0">
                                                <input type="hidden" name="value[reset_cart_items]" value="0">
                                                <input type="checkbox" name="value[reset_cart_items]" id="reset_cart_itemsSwitch" value="1"
                                                       {{ (!empty($itemValue) and !empty($itemValue['reset_cart_items']) and $itemValue['reset_cart_items']) ? 'checked="checked"' : '' }} class="custom-switch-input"/>
                                                <span class="custom-switch-indicator"></span>
                                                <label class="custom-switch-description mb-0 cursor-pointer"
                                                       for="reset_cart_itemsSwitch">{{ trans('update.reset_cart_items') ?? 'Reset Cart Items' }}</label>
                                            </label>
                                            <div class="text-muted text-small mt-1">{{ trans('update.abandoned_cart_setting_reset_cart_items_hint') }}</div>
                                        </div>

                                        <div class="form-group js-reset-hours-field {{ (!empty($itemValue) and !empty($itemValue['reset_cart_items']) and $itemValue['reset_cart_items']) ? '' : 'd-none' }}">
                                            <label>{{ trans('update.reset_hours') ?? 'Reset Hours' }}</label>
                                            <input type="number" name="value[reset_hours]" value="{{ (!empty($itemValue) and !empty($itemValue['reset_hours'])) ? $itemValue['reset_hours'] : '' }}" class="form-control"/>
                                            <div class="text-muted text-small mt-1">{{ trans('update.abandoned_cart_setting_reset_hours_hint') }}</div>
                                        </div>
                                        
                                        <div class="form-group mt-4">
                                            <label>{{ trans('update.abandoned_cart_reminder_template') ?? 'Reminder Template' }}</label>
                                            <select name="value[reminder_template_id]" class="form-control select2">
                                                <option value="" selected disabled>{{ trans('admin/main.select') }}</option>
                                                @foreach($notificationTemplates as $template)
                                                    <option value="{{ $template->id }}" {{ (!empty($itemValue) and !empty($itemValue['reminder_template_id']) and $itemValue['reminder_template_id'] == $template->id) ? 'selected' : '' }}>{{ $template->title }}</option>
                                                @endforeach
                                            </select>
                                            <div class="text-muted text-small mt-1">{{ trans('update.abandoned_cart_reminder_template_hint') }}</div>
                                        </div>

                                        <div class="form-group mt-4">
                                            <label>{{ trans('update.abandoned_cart_coupon') ?? 'Coupon' }}</label>
                                            <select name="value[discount_id]" class="form-control select2">
                                                <option value="" selected disabled>{{ trans('admin/main.select') }}</option>
                                                @foreach($discounts as $discount)
                                                    <option value="{{ $discount->id }}" {{ (!empty($itemValue) and !empty($itemValue['discount_id']) and $itemValue['discount_id'] == $discount->id) ? 'selected' : '' }}>{{ $discount->title }}</option>
                                                @endforeach
                                            </select>
                                            <div class="text-muted text-small mt-1">{{ trans('update.abandoned_cart_coupon_hint') }}</div>
                                        </div>

                                        <div class="form-group mt-4">
                                            <label>{{ trans('update.abandoned_cart_coupon_template') ?? 'Coupon Template' }}</label>
                                            <select name="value[coupon_template_id]" class="form-control select2">
                                                <option value="" selected disabled>{{ trans('admin/main.select') }}</option>
                                                @foreach($notificationTemplates as $template)
                                                    <option value="{{ $template->id }}" {{ (!empty($itemValue) and !empty($itemValue['coupon_template_id']) and $itemValue['coupon_template_id'] == $template->id) ? 'selected' : '' }}>{{ $template->title }}</option>
                                                @endforeach
                                            </select>
                                            <div class="text-muted text-small mt-1">{{ trans('update.abandoned_cart_coupon_template_hint') }}</div>
                                        </div>

                                        <button type="submit" class="btn btn-primary mt-4">{{ trans('admin/main.save_change') }}</button>
                                    </div>
                                </div>
                            </form>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts_bottom')
    <script src="/assets/default/vendors/select2/select2.min.js"></script>
    <script src="/assets/admin/js/parts/abandoned_cart_settings.min.js"></script>
@endpush
