@extends('admin.layouts.app')

@push('styles_top')
    <link rel="stylesheet" href="/assets/default/vendors/summernote/summernote-bs4.min.css">
@endpush

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ $pageTitle }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}">{{trans('admin/main.dashboard')}}</a></div>
                <div class="breadcrumb-item">{{ $pageTitle }}</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ getAdminPanelUrl() }}/settings/general/store" method="post">
                                {{ csrf_field() }}
                                <input type="hidden" name="page" value="general">
                                
                                @if(!empty(getGeneralSettings('content_translate')))
                                    <div class="form-group col-12 col-md-6">
                                        <label class="input-label">{{ trans('auth.language') }}</label>
                                        <select name="locale" class="form-control js-edit-content-locale">
                                            @foreach($userLanguages ?? getUserLanguagesLists() as $lang => $language)
                                                <option value="{{ $lang }}" @if(mb_strtolower(request()->get('locale', app()->getLocale())) == mb_strtolower($lang)) selected @endif>{{ $language }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @else
                                    <input type="hidden" name="locale" value="{{ getDefaultLocale() }}">
                                @endif

                                @php
                                    $bonusSettings = $settings->where('name', \App\Models\Setting::$registrationBonusSettingsName)->first();
                                    $bonusSettingsValues = !empty($bonusSettings) ? $bonusSettings->value : null;
                                    if(!empty($bonusSettingsValues)) {
                                        $bonusSettingsValues = json_decode($bonusSettingsValues, true);
                                    }

                                    $bonusTermsSettings = $settings->where('name', \App\Models\Setting::$registrationBonusTermsSettingsName)->first();
                                    $bonusTermsSettingsValues = !empty($bonusTermsSettings) ? $bonusTermsSettings->value : null;
                                    if(!empty($bonusTermsSettingsValues)) {
                                        $bonusTermsSettingsValues = json_decode($bonusTermsSettingsValues, true);
                                    }
                                @endphp
                                
                                <input type="hidden" name="name[]" value="{{ \App\Models\Setting::$registrationBonusSettingsName }}">
                                <input type="hidden" name="name[]" value="{{ \App\Models\Setting::$registrationBonusTermsSettingsName }}">

                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="form-group custom-switches-stacked">
                                            <label class="custom-switch pl-0">
                                                <input type="hidden" name="value[{{ \App\Models\Setting::$registrationBonusSettingsName }}][status]" value="0">
                                                <input type="checkbox" name="value[{{ \App\Models\Setting::$registrationBonusSettingsName }}][status]" id="statusSwitch" value="1" {{ (!empty($bonusSettingsValues) && !empty($bonusSettingsValues['status']) && $bonusSettingsValues['status']) ? 'checked="checked"' : '' }} class="custom-switch-input"/>
                                                <span class="custom-switch-indicator"></span>
                                                <label class="custom-switch-description mb-0 cursor-pointer" for="statusSwitch">{{ trans('admin/main.active') }}</label>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>{{ trans('update.terms_and_conditions') }}</label>
                                            <textarea name="value[{{ \App\Models\Setting::$registrationBonusTermsSettingsName }}][terms]" class="summernote form-control" rows="10">{{ !empty($bonusTermsSettingsValues) ? $bonusTermsSettingsValues['terms'] : '' }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary">{{ trans('admin/main.submit') }}</button>
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
    <script src="/assets/default/vendors/summernote/summernote-bs4.min.js"></script>
@endpush
