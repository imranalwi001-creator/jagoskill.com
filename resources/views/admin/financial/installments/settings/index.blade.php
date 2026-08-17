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
                                    $installmentsSettings = $settings->where('name', \App\Models\Setting::$installmentsSettingsName)->first();
                                    $installmentsSettingsValues = !empty($installmentsSettings) ? $installmentsSettings->value : null;
                                    if(!empty($installmentsSettingsValues)) {
                                        $installmentsSettingsValues = json_decode($installmentsSettingsValues, true);
                                    }

                                    $installmentsTermsSettings = $settings->where('name', \App\Models\Setting::$installmentsTermsSettingsName)->first();
                                    $installmentsTermsSettingsValues = !empty($installmentsTermsSettings) ? $installmentsTermsSettings->value : null;
                                    if(!empty($installmentsTermsSettingsValues)) {
                                        $installmentsTermsSettingsValues = json_decode($installmentsTermsSettingsValues, true);
                                    }
                                @endphp
                                
                                <input type="hidden" name="name[]" value="{{ \App\Models\Setting::$installmentsSettingsName }}">
                                <input type="hidden" name="name[]" value="{{ \App\Models\Setting::$installmentsTermsSettingsName }}">

                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="form-group custom-switches-stacked">
                                            <label class="custom-switch pl-0">
                                                <input type="hidden" name="value[{{ \App\Models\Setting::$installmentsSettingsName }}][status]" value="0">
                                                <input type="checkbox" name="value[{{ \App\Models\Setting::$installmentsSettingsName }}][status]" id="statusSwitch" value="1" {{ (!empty($installmentsSettingsValues) && !empty($installmentsSettingsValues['status']) && $installmentsSettingsValues['status']) ? 'checked="checked"' : '' }} class="custom-switch-input"/>
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
                                            <textarea name="value[{{ \App\Models\Setting::$installmentsTermsSettingsName }}][terms]" class="summernote form-control" rows="10">{{ (!empty($installmentsTermsSettingsValues) && isset($installmentsTermsSettingsValues['terms'])) ? $installmentsTermsSettingsValues['terms'] : '' }}</textarea>
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
