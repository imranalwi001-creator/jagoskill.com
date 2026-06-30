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
            <div class="card">
                <div class="card-header"><h5 class="font-14 mb-0">{{ trans('update.attendances_settings') }}</h5></div>
                <div class="card-body">
                    <form action="{{ getAdminPanelUrl('/attendances/settings/store') }}" method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="name" value="{{ \App\Models\Setting::$attendanceSettingsName }}">
                        <input type="hidden" name="locale" value="{{ $selectedLocale }}">

                        <div class="form-group custom-switches-stacked">
                            <label class="custom-switch pl-0">
                                <input type="hidden" name="value[status]" value="0">
                                <input type="checkbox" name="value[status]" value="1" class="custom-switch-input" {{ !empty($settingValues['status']) ? 'checked' : '' }}>
                                <span class="custom-switch-indicator"></span>
                                <span class="custom-switch-description mb-0 cursor-pointer">{{ trans('admin/main.active') }}</span>
                            </label>
                        </div>

                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">{{ trans('admin/main.save_change') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
