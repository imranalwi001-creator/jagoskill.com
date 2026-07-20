@extends('admin.layouts.app')

@push('styles_top')
    <link rel="stylesheet" href="/assets/default/vendors/select2/select2.min.css">
    <link rel="stylesheet" href="/assets/default/vendors/summernote/summernote-bs4.min.css">
@endpush

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ $pageTitle }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}">{{trans('admin/main.dashboard')}}</a></div>
                <div class="breadcrumb-item"><a href="{{ getAdminPanelUrl() }}/financial/installments">{{ trans('update.installments') }}</a></div>
                <div class="breadcrumb-item">{{ $pageTitle}}</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ getAdminPanelUrl('/financial/installments/' . (!empty($installment) ? $installment->id . '/update' : 'store')) }}" method="post">
                                {{ csrf_field() }}
                                
                                <ul class="nav nav-pills" id="myTab3" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="basic-tab" data-toggle="tab" href="#basic" role="tab" aria-controls="basic" aria-selected="true">{{ trans('admin/main.basic_information') }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="options-tab" data-toggle="tab" href="#options" role="tab" aria-controls="options" aria-selected="false">{{ trans('update.options') }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="steps-tab" data-toggle="tab" href="#steps" role="tab" aria-controls="steps" aria-selected="false">{{ trans('update.steps') }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="verification-tab" data-toggle="tab" href="#verification" role="tab" aria-controls="verification" aria-selected="false">{{ trans('update.verification') }}</a>
                                    </li>
                                </ul>

                                <div class="tab-content" id="myTabContent2">
                                    <!-- Basic Info -->
                                    <div class="tab-pane mt-3 fade show active" id="basic" role="tabpanel" aria-labelledby="basic-tab">
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                @if(!empty(getGeneralSettings('content_translate')))
                                                    <div class="form-group">
                                                        <label class="input-label">{{ trans('auth.language') }}</label>
                                                        <select name="locale" class="form-control {{ !empty($installment) ? 'js-edit-content-locale' : '' }}">
                                                            @foreach($userLanguages ?? getUserLanguagesLists() as $lang => $language)
                                                                <option value="{{ $lang }}" @if(mb_strtolower(request()->get('locale', app()->getLocale())) == mb_strtolower($lang)) selected @endif>{{ $language }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                @else
                                                    <input type="hidden" name="locale" value="{{ getDefaultLocale() }}">
                                                @endif
                                                
                                                <div class="form-group">
                                                    <label>{{ trans('admin/main.title') }}</label>
                                                    <input type="text" name="title" value="{{ !empty($installment) ? $installment->title : old('title') }}" class="form-control" required/>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label>{{ trans('update.main_title') }}</label>
                                                    <input type="text" name="main_title" value="{{ !empty($installment) ? $installment->main_title : old('main_title') }}" class="form-control" required/>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label class="input-label">{{ trans('admin/main.banner') }}</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <button type="button" class="input-group-text admin-file-manager" data-input="banner" data-preview="holder">
                                                                <i class="fa fa-upload"></i>
                                                            </button>
                                                        </div>
                                                        <input type="text" name="banner" id="banner" value="{{ !empty($installment) ? $installment->banner : old('banner') }}" class="form-control" required/>
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label>{{ trans('admin/main.description') }}</label>
                                                    <textarea name="description" class="summernote form-control" rows="5" required>{{ !empty($installment) ? $installment->description : old('description') }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Options -->
                                    <div class="tab-pane mt-3 fade" id="options" role="tabpanel" aria-labelledby="options-tab">
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <div class="form-group">
                                                    <label>{{ trans('update.upfront') }}</label>
                                                    <input type="number" name="upfront" value="{{ !empty($installment) ? $installment->upfront : old('upfront') }}" class="form-control"/>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label>{{ trans('update.upfront_type') }}</label>
                                                    <select name="upfront_type" class="form-control">
                                                        <option value="percent" {{ (!empty($installment) && $installment->upfront_type == 'percent') ? 'selected' : '' }}>{{ trans('update.percent') }}</option>
                                                        <option value="fixed_amount" {{ (!empty($installment) && $installment->upfront_type == 'fixed_amount') ? 'selected' : '' }}>{{ trans('update.fixed_amount') }}</option>
                                                    </select>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label>{{ trans('update.capacity') }}</label>
                                                    <input type="number" name="capacity" value="{{ !empty($installment) ? $installment->capacity : old('capacity') }}" class="form-control"/>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label>{{ trans('update.target_type') }}</label>
                                                    <select name="target_type" class="form-control">
                                                        <option value="all" {{ (!empty($installment) && $installment->target_type == 'all') ? 'selected' : '' }}>{{ trans('update.all') }}</option>
                                                        <option value="courses" {{ (!empty($installment) && $installment->target_type == 'courses') ? 'selected' : '' }}>{{ trans('update.courses') }}</option>
                                                        <option value="bundles" {{ (!empty($installment) && $installment->target_type == 'bundles') ? 'selected' : '' }}>{{ trans('update.bundles') }}</option>
                                                        <option value="store_products" {{ (!empty($installment) && $installment->target_type == 'store_products') ? 'selected' : '' }}>{{ trans('update.store_products') }}</option>
                                                        <option value="registration_packages" {{ (!empty($installment) && $installment->target_type == 'registration_packages') ? 'selected' : '' }}>{{ trans('update.registration_packages') }}</option>
                                                    </select>
                                                </div>
                                                
                                                <div class="form-group custom-switches-stacked mt-4">
                                                    <label class="custom-switch pl-0">
                                                        <input type="hidden" name="enable" value="0">
                                                        <input type="checkbox" name="enable" value="1" {{ (!empty($installment) && $installment->enable) ? 'checked="checked"' : '' }} class="custom-switch-input"/>
                                                        <span class="custom-switch-indicator"></span>
                                                        <label class="custom-switch-description mb-0 cursor-pointer">{{ trans('admin/main.active') }}</label>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Steps -->
                                    <div class="tab-pane mt-3 fade" id="steps" role="tabpanel" aria-labelledby="steps-tab">
                                        <div class="alert alert-info">
                                            {{ trans('update.installment_steps_hint') }}
                                        </div>
                                        <p class="text-muted">{{ trans('update.please_add_steps_after_saving_first') }}</p>
                                    </div>
                                    
                                    <!-- Verification -->
                                    <div class="tab-pane mt-3 fade" id="verification" role="tabpanel" aria-labelledby="verification-tab">
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <div class="form-group custom-switches-stacked mt-4">
                                                    <label class="custom-switch pl-0">
                                                        <input type="hidden" name="verification" value="0">
                                                        <input type="checkbox" name="verification" id="verificationSwitch" value="1" {{ (!empty($installment) && $installment->verification) ? 'checked="checked"' : '' }} class="custom-switch-input"/>
                                                        <span class="custom-switch-indicator"></span>
                                                        <label class="custom-switch-description mb-0 cursor-pointer" for="verificationSwitch">{{ trans('update.requires_verification') }}</label>
                                                    </label>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label class="input-label">{{ trans('update.verification_banner') }}</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <button type="button" class="input-group-text admin-file-manager" data-input="verification_banner" data-preview="holder">
                                                                <i class="fa fa-upload"></i>
                                                            </button>
                                                        </div>
                                                        <input type="text" name="verification_banner" id="verification_banner" value="{{ !empty($installment) ? $installment->verification_banner : old('verification_banner') }}" class="form-control"/>
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label>{{ trans('update.verification_description') }}</label>
                                                    <textarea name="verification_description" class="summernote form-control" rows="5">{{ !empty($installment) ? $installment->verification_description : old('verification_description') }}</textarea>
                                                </div>
                                            </div>
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
    <script src="/assets/default/vendors/select2/select2.min.js"></script>
    <script src="/assets/default/vendors/summernote/summernote-bs4.min.js"></script>
@endpush
