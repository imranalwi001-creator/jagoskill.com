@extends('admin.layouts.app')

@push('styles_top')
    <link rel="stylesheet" href="/assets/default/vendors/select2/select2.min.css">
@endpush

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ $pageTitle }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}">{{trans('admin/main.dashboard')}}</a></div>
                <div class="breadcrumb-item"><a href="{{ getAdminPanelUrl() }}/purchase-notifications">{{ trans('update.purchase_notifications') }}</a></div>
                <div class="breadcrumb-item">{{ $pageTitle}}</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-8 col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ getAdminPanelUrl('/purchase-notifications/' . (!empty($notification) ? $notification->id . '/update' : 'store')) }}" method="post">
                                {{ csrf_field() }}

                                <div class="form-group">
                                    <label>{{ trans('admin/main.title') }}</label>
                                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ !empty($notification) ? $notification->title : old('title') }}"/>
                                    @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>{{ trans('admin/main.type') }}</label>
                                    <select name="type" class="form-control @error('type') is-invalid @enderror">
                                        <option value="fake" {{ (!empty($notification) and $notification->type == 'fake') ? 'selected' : '' }}>{{ trans('update.fake') }}</option>
                                        <option value="real" {{ (!empty($notification) and $notification->type == 'real') ? 'selected' : '' }}>{{ trans('update.real') }}</option>
                                    </select>
                                    @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label>{{ trans('update.users') }} ({{ trans('update.comma_separated') }})</label>
                                    <textarea name="users" class="form-control @error('users') is-invalid @enderror" rows="3">{{ !empty($notification) ? implode(',', $notification->users ?? []) : old('users') }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label>{{ trans('update.times') }} ({{ trans('update.comma_separated') }})</label>
                                    <textarea name="times" class="form-control @error('times') is-invalid @enderror" rows="3">{{ !empty($notification) ? implode(',', $notification->times ?? []) : old('times') }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label>{{ trans('update.contents') }}</label>
                                    <textarea name="contents[]" class="form-control @error('contents') is-invalid @enderror" rows="3">{{ !empty($notification) ? implode(',', $notification->contents ?? []) : old('contents') }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label>{{ trans('update.popup_title') }}</label>
                                    <input type="text" name="popup_title" class="form-control @error('popup_title') is-invalid @enderror" value="{{ !empty($notification) ? $notification->popup_title : old('popup_title') }}"/>
                                </div>

                                <div class="form-group">
                                    <label>{{ trans('update.popup_subtitle') }}</label>
                                    <input type="text" name="popup_subtitle" class="form-control @error('popup_subtitle') is-invalid @enderror" value="{{ !empty($notification) ? $notification->popup_subtitle : old('popup_subtitle') }}"/>
                                </div>

                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>{{ trans('update.popup_duration') }} ({{ trans('admin/main.second') }})</label>
                                            <input type="number" name="popup_duration" class="form-control @error('popup_duration') is-invalid @enderror" value="{{ !empty($notification) ? $notification->popup_duration : old('popup_duration', 5) }}"/>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>{{ trans('update.popup_delay') }} ({{ trans('admin/main.second') }})</label>
                                            <input type="number" name="popup_delay" class="form-control @error('popup_delay') is-invalid @enderror" value="{{ !empty($notification) ? $notification->popup_delay : old('popup_delay', 5) }}"/>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label>{{ trans('update.display_time') }}</label>
                                    <input type="number" name="display_time" class="form-control @error('display_time') is-invalid @enderror" value="{{ !empty($notification) ? $notification->display_time : old('display_time', 10) }}"/>
                                </div>

                                <div class="form-group custom-switches-stacked">
                                    <label class="custom-switch pl-0">
                                        <input type="hidden" name="status" value="inactive">
                                        <input type="checkbox" name="status" id="statusSwitch" value="active" {{ (!empty($notification) and $notification->status == 'active') ? 'checked="checked"' : '' }} class="custom-switch-input"/>
                                        <span class="custom-switch-indicator"></span>
                                        <label class="custom-switch-description mb-0 cursor-pointer" for="statusSwitch">{{ trans('admin/main.active') }}</label>
                                    </label>
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
    <script src="/assets/default/vendors/select2/select2.min.js"></script>
@endpush
