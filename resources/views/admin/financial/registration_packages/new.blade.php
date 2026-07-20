@extends('admin.layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ $pageTitle }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}">{{trans('admin/main.dashboard')}}</a></div>
                <div class="breadcrumb-item"><a href="{{ getAdminPanelUrl() }}/financial/registration-packages">{{ trans('update.registration_packages') }}</a></div>
                <div class="breadcrumb-item">{{ $pageTitle}}</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-8 col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ getAdminPanelUrl('/financial/registration-packages/' . (!empty($package) ? $package->id . '/update' : 'store')) }}" method="post">
                                {{ csrf_field() }}

                                @if(!empty(getGeneralSettings('content_translate')))
                                    <div class="form-group">
                                        <label class="input-label">{{ trans('auth.language') }}</label>
                                        <select name="locale" class="form-control {{ !empty($package) ? 'js-edit-content-locale' : '' }}">
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

                                <div class="form-group">
                                    <label>{{ trans('admin/main.title') }}</label>
                                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ !empty($package) ? $package->title : old('title') }}"/>
                                    @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>{{ trans('admin/main.role') }}</label>
                                    <select name="role" class="form-control @error('role') is-invalid @enderror">
                                        <option value="instructors" {{ (!empty($package) and $package->role == 'instructors') ? 'selected' : '' }}>{{ trans('admin/main.instructors') }}</option>
                                        <option value="organizations" {{ (!empty($package) and $package->role == 'organizations') ? 'selected' : '' }}>{{ trans('admin/main.organizations') }}</option>
                                    </select>
                                    @error('role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>{{ trans('public.days') }}</label>
                                    <input type="number" name="days" class="form-control @error('days') is-invalid @enderror" value="{{ !empty($package) ? $package->days : old('days') }}"/>
                                    @error('days')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>{{ trans('admin/main.price') }}</label>
                                    <input type="text" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ !empty($package) ? $package->price : old('price') }}"/>
                                    @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
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
                                        <input type="text" name="icon" id="icon" value="{{ !empty($package) ? $package->icon : old('icon') }}" class="form-control @error('icon') is-invalid @enderror"/>
                                        <div class="input-group-append">
                                            <button type="button" class="input-group-text admin-file-view" data-input="icon">
                                                <i class="fa fa-eye"></i>
                                            </button>
                                        </div>
                                        @error('icon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label>{{ trans('admin/main.description') }}</label>
                                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="5">{{ !empty($package) ? $package->description : old('description') }}</textarea>
                                    @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <h5 class="mt-4 mb-3">{{ trans('update.features') }}</h5>

                                <div class="form-group">
                                    <label>{{ trans('update.instructors_count') }}</label>
                                    <input type="number" name="instructors_count" class="form-control @error('instructors_count') is-invalid @enderror" value="{{ !empty($package) ? $package->instructors_count : old('instructors_count') }}"/>
                                </div>

                                <div class="form-group">
                                    <label>{{ trans('update.students_count') }}</label>
                                    <input type="number" name="students_count" class="form-control @error('students_count') is-invalid @enderror" value="{{ !empty($package) ? $package->students_count : old('students_count') }}"/>
                                </div>

                                <div class="form-group">
                                    <label>{{ trans('update.courses_capacity') }}</label>
                                    <input type="number" name="courses_capacity" class="form-control @error('courses_capacity') is-invalid @enderror" value="{{ !empty($package) ? $package->courses_capacity : old('courses_capacity') }}"/>
                                </div>

                                <div class="form-group">
                                    <label>{{ trans('update.courses_count') }}</label>
                                    <input type="number" name="courses_count" class="form-control @error('courses_count') is-invalid @enderror" value="{{ !empty($package) ? $package->courses_count : old('courses_count') }}"/>
                                </div>

                                <div class="form-group">
                                    <label>{{ trans('update.meeting_count') }}</label>
                                    <input type="number" name="meeting_count" class="form-control @error('meeting_count') is-invalid @enderror" value="{{ !empty($package) ? $package->meeting_count : old('meeting_count') }}"/>
                                </div>

                                <div class="form-group custom-switches-stacked">
                                    <label class="custom-switch pl-0">
                                        <input type="hidden" name="status" value="disabled">
                                        <input type="checkbox" name="status" id="statusSwitch" value="active" {{ (!empty($package) and $package->status == 'active') ? 'checked="checked"' : '' }} class="custom-switch-input"/>
                                        <span class="custom-switch-indicator"></span>
                                        <label class="custom-switch-description mb-0 cursor-pointer" for="statusSwitch">{{ trans('admin/main.active') }}</label>
                                    </label>
                                </div>

                                <div class="mt-4">
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
