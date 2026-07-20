@extends('admin.layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ $pageTitle }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}">{{trans('admin/main.dashboard')}}</a></div>
                <div class="breadcrumb-item">{{ $pageTitle}}</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-8 col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ getAdminPanelUrl('/rewards/settings') }}" method="post">
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
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                @else
                                    <input type="hidden" name="locale" value="{{ getDefaultLocale() }}">
                                @endif

                                <div class="form-group custom-switches-stacked">
                                    <label class="custom-switch pl-0">
                                        <input type="hidden" name="value[status]" value="0">
                                        <input type="checkbox" name="value[status]" id="statusSwitch" value="1" {{ (!empty($itemValue) and !empty($itemValue['status']) and $itemValue['status']) ? 'checked="checked"' : '' }} class="custom-switch-input"/>
                                        <span class="custom-switch-indicator"></span>
                                        <label class="custom-switch-description mb-0 cursor-pointer" for="statusSwitch">{{ trans('admin/main.active') }}</label>
                                    </label>
                                </div>

                                <div class="form-group custom-switches-stacked">
                                    <label class="custom-switch pl-0">
                                        <input type="hidden" name="value[exchangeable]" value="0">
                                        <input type="checkbox" name="value[exchangeable]" id="exchangeableSwitch" value="1" {{ (!empty($itemValue) and !empty($itemValue['exchangeable']) and $itemValue['exchangeable']) ? 'checked="checked"' : '' }} class="custom-switch-input"/>
                                        <span class="custom-switch-indicator"></span>
                                        <label class="custom-switch-description mb-0 cursor-pointer" for="exchangeableSwitch">{{ trans('update.exchangeable') }}</label>
                                    </label>
                                    <div class="text-muted text-small mt-1">{{ trans('update.exchangeable_hint') }}</div>
                                </div>

                                <div class="form-group">
                                    <label>{{ trans('update.exchangeable_unit') }}</label>
                                    <input type="number" name="value[exchangeable_unit]" class="form-control @error('value.exchangeable_unit') is-invalid @enderror" value="{{ (!empty($itemValue) and !empty($itemValue['exchangeable_unit'])) ? $itemValue['exchangeable_unit'] : old('value.exchangeable_unit') }}"/>
                                    @error('value.exchangeable_unit')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary">{{ trans('admin/main.save_change') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
