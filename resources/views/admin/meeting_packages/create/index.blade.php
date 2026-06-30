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
                <div class="breadcrumb-item"><a href="{{ getAdminPanelUrl() }}/meeting-packages">{{ trans('update.meeting_packages') }}</a></div>
                <div class="breadcrumb-item">{{ $pageTitle }}</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ getAdminPanelUrl() }}/meeting-packages/{{ !empty($meetingPackage) ? $meetingPackage->id .'/update' : 'store' }}" method="post">
                                {{ csrf_field() }}
                                
                                @if(!empty($getLocale))
                                    <input type="hidden" name="locale" value="{{ $getLocale }}">
                                @endif

                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        
                                        @if(!empty($meetingPackage))
                                            <div class="form-group">
                                                <label>{{ trans('admin/main.language') }}</label>
                                                <select name="locale" class="form-control {{ !empty($meetingPackage) ? 'js-edit-content-locale' : '' }}">
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

                                        <div class="form-group">
                                            <label>{{ trans('admin/main.title') }}</label>
                                            <input type="text" name="title" value="{{ !empty($meetingPackage) ? $meetingPackage->title : old('title') }}" class="form-control  @error('title') is-invalid @enderror" placeholder=""/>
                                            @error('title')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="input-label">{{ trans('admin/main.creator') }}</label>
                                            <select name="creator_id" class="form-control search-user-select2"
                                                    data-placeholder="{{ trans('public.search_user') }}">

                                                @if(!empty($meetingPackage))
                                                    <option value="{{ $meetingPackage->creator->id }}" selected>{{ $meetingPackage->creator->full_name }}</option>
                                                @endif
                                            </select>
                                            @error('creator_id')
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        
                                        <div class="form-group mt-15">
                                            <label class="input-label">{{ trans('admin/main.icon') }}</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <button type="button" class="input-group-text admin-file-manager" data-input="icon" data-preview="holder">
                                                        <i class="fa fa-upload"></i>
                                                    </button>
                                                </div>
                                                <input type="text" name="icon" id="icon" value="{{ !empty($meetingPackage) ? $meetingPackage->icon : old('icon') }}" class="form-control @error('icon') is-invalid @enderror"/>
                                                <div class="input-group-append">
                                                    <button type="button" class="input-group-text admin-file-view" data-input="icon">
                                                        <i class="fa fa-eye"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>{{ trans('admin/main.price') }} ({{ $currency }})</label>
                                            <input type="number" name="price" value="{{ !empty($meetingPackage) ? $meetingPackage->price : old('price') }}" class="form-control @error('price') is-invalid @enderror"/>
                                            @error('price')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label>{{ trans('admin/main.discount') }} (%)</label>
                                            <input type="number" name="discount" value="{{ !empty($meetingPackage) ? $meetingPackage->discount : old('discount') }}" class="form-control @error('discount') is-invalid @enderror"/>
                                            @error('discount')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        
                                        <div class="form-group">
                                            <label>{{ trans('update.duration') }}</label>
                                            <input type="number" name="duration" value="{{ !empty($meetingPackage) ? $meetingPackage->duration : old('duration') }}" class="form-control @error('duration') is-invalid @enderror"/>
                                            @error('duration')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        
                                        <div class="form-group">
                                            <label>{{ trans('update.duration_type') }}</label>
                                            <select name="duration_type" class="form-control @error('duration_type') is-invalid @enderror">
                                                <option value="day" {{ (!empty($meetingPackage) and $meetingPackage->duration_type == 'day') ? 'selected' : '' }}>{{ trans('update.days') }}</option>
                                                <option value="month" {{ (!empty($meetingPackage) and $meetingPackage->duration_type == 'month') ? 'selected' : '' }}>{{ trans('update.months') }}</option>
                                                <option value="year" {{ (!empty($meetingPackage) and $meetingPackage->duration_type == 'year') ? 'selected' : '' }}>{{ trans('update.years') }}</option>
                                            </select>
                                            @error('duration_type')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        
                                        <div class="form-group">
                                            <label>{{ trans('update.sessions_count') }}</label>
                                            <input type="number" name="sessions" value="{{ !empty($meetingPackage) ? $meetingPackage->sessions : old('sessions') }}" class="form-control @error('sessions') is-invalid @enderror"/>
                                            @error('sessions')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        
                                        <div class="form-group">
                                            <label>{{ trans('update.session_duration') }} ({{ trans('admin/main.minute') }})</label>
                                            <input type="number" name="session_duration" value="{{ !empty($meetingPackage) ? $meetingPackage->session_duration : old('session_duration') }}" class="form-control @error('session_duration') is-invalid @enderror"/>
                                            @error('session_duration')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>

                                        <div class="form-group custom-switches-stacked mt-2">
                                            <label class="custom-switch pl-0">
                                                <input type="hidden" name="enable" value="0">
                                                <input type="checkbox" name="enable" id="enableSwitch" value="1" {{ (!empty($meetingPackage) and $meetingPackage->enable) ? 'checked="checked"' : '' }} class="custom-switch-input"/>
                                                <span class="custom-switch-indicator"></span>
                                                <label class="custom-switch-description mb-0 cursor-pointer" for="enableSwitch">{{ trans('admin/main.active') }}</label>
                                            </label>
                                        </div>

                                    </div>
                                </div>

                                <div class=" mt-4">
                                    <button class="btn btn-primary">{{ trans('admin/main.submit') }}</button>
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