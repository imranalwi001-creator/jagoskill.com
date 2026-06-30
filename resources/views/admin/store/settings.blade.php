@extends('admin.layouts.app')

@push('styles_top')
@endpush

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ trans('update.store_settings') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}">{{trans('admin/main.dashboard')}}</a></div>
                <div class="breadcrumb-item">{{ trans('update.store_settings') }}</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ getAdminPanelUrl() }}/store/settings" method="Post">
                                {{ csrf_field() }}

                                @if(!empty(getGeneralSettings('content_translate')))
                                    <div class="form-group">
                                        <label class="input-label">{{ trans('auth.language') }}</label>
                                        <select name="locale" class="form-control js-edit-content-locale">
                                            @foreach($userLanguages as $lang => $language)
                                                <option value="{{ $lang }}" @if(mb_strtolower(request()->get('locale', app()->getLocale())) == mb_strtolower($lang)) selected @endif>{{ $language }}</option>
                                            @endforeach
                                        </select>
                                        @error('locale')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                @else
                                    <input type="hidden" name="locale" value="{{ getDefaultLocale() }}">
                                @endif

                                <div class="form-group custom-switches-stacked">
                                    <label class="custom-switch pl-0">
                                        <input type="hidden" name="value[exchangeable]" value="0">
                                        <input type="checkbox" name="value[exchangeable]" id="exchangeableSwitch" value="1" {{ (!empty($itemValue) and !empty($itemValue['exchangeable']) and $itemValue['exchangeable'] == 1) ? 'checked="checked"' : '' }} class="custom-switch-input"/>
                                        <span class="custom-switch-indicator"></span>
                                        <label class="custom-switch-description mb-0 cursor-pointer" for="exchangeableSwitch">{{ trans('update.points_reward_exchangeable') }}</label>
                                    </label>
                                </div>

                                <div class="form-group js-exchangeable-unit-input {{ (!empty($itemValue) and !empty($itemValue['exchangeable']) and $itemValue['exchangeable'] == 1) ? '' : 'd-none' }}">
                                    <label>{{ trans('update.exchangeable_unit') }}</label>
                                    <input type="text" name="value[exchangeable_unit]" class="form-control @error('value.exchangeable_unit') is-invalid @enderror" value="{{ (!empty($itemValue) and !empty($itemValue['exchangeable_unit'])) ? $itemValue['exchangeable_unit'] : '' }}"/>
                                    @error('value.exchangeable_unit')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                    <p class="text-muted mt-1 text-small">{{ trans('update.exchangeable_unit_hint') }}</p>
                                </div>

                                <div class="mt-4">
                                    <button class="btn btn-primary">{{ trans('admin/main.save_change') }}</button>
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
    <script>
        (function ($) {
            "use strict";

            $('body').on('change', '#exchangeableSwitch', function () {
                if ($(this).is(':checked')) {
                    $('.js-exchangeable-unit-input').removeClass('d-none');
                } else {
                    $('.js-exchangeable-unit-input').addClass('d-none');
                }
            });

        })(jQuery);
    </script>
@endpush
