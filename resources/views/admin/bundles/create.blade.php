@extends('admin.layouts.app')

@push('styles_top')
    <link rel="stylesheet" href="/assets/default/vendors/select2/select2.min.css">
    <link rel="stylesheet" href="/assets/default/vendors/bootstrap-tagsinput/bootstrap-tagsinput.min.css">
    <link rel="stylesheet" href="/assets/default/vendors/summernote/summernote-bs4.min.css">
@endpush

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ !empty($bundle) ? trans('admin/main.edit') : trans('admin/main.new') }} {{ trans('update.bundle') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}">{{ trans('admin/main.dashboard') }}</a></div>
                <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}/bundles">{{ trans('update.bundles') }}</a></div>
                <div class="breadcrumb-item">{{ !empty($bundle) ? trans('admin/main.edit') : trans('admin/main.new') }}</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <!-- Nav Tabs -->
                            <ul class="nav nav-pills" id="bundleTabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="general-tab" data-toggle="tab" href="#general" role="tab">{{ trans('public.basic_information') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="extra-tab" data-toggle="tab" href="#extra" role="tab">{{ trans('public.additional_information') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="media-tab" data-toggle="tab" href="#media" role="tab">{{ trans('admin/main.media') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="price-tab" data-toggle="tab" href="#price" role="tab">{{ trans('admin/main.price') }}</a>
                                </li>
                            </ul>

                            <form action="{{ getAdminPanelUrl() }}/bundles/{{ !empty($bundle) ? $bundle->id.'/update' : 'store' }}" method="post" class="mt-4">
                                {{ csrf_field() }}

                                <div class="tab-content" id="bundleTabsContent">
                                    <!-- Tab 1: General -->
                                    <div class="tab-pane fade show active" id="general" role="tabpanel">
                                        <div class="row">
                                            <div class="col-12 col-md-8">
                                                @if(!empty(getGeneralSettings('content_translate')))
                                                    <div class="form-group">
                                                        <label class="input-label">{{ trans('auth.language') }}</label>
                                                        <select name="locale" class="form-control {{ !empty($bundle) ? 'js-edit-content-locale' : '' }}">
                                                            @foreach($userLanguages as $lang => $language)
                                                                <option value="{{ $lang }}" @if(mb_strtolower(request()->get('locale', app()->getLocale())) == mb_strtolower($lang)) selected @endif>{{ $language }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                @else
                                                    <input type="hidden" name="locale" value="{{ getDefaultLocale() }}">
                                                @endif

                                                <div class="form-group">
                                                    <label>{{ trans('admin/main.title') }}</label>
                                                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ !empty($bundle) ? $bundle->title : old('title') }}" required placeholder="{{ trans('admin/main.choose_title') }}"/>
                                                    @error('title')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="form-group">
                                                    <label>{{ trans('admin/main.url') }}</label>
                                                    <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ !empty($bundle) ? $bundle->slug : old('slug') }}" placeholder="{{ trans('admin/main.choose_url') }}"/>
                                                    @error('slug')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="form-group">
                                                    <label class="input-label">{{ trans('admin/main.teacher') }}</label>
                                                    <select name="teacher_id" class="form-control search-user-select2" data-placeholder="{{ trans('public.search_user') }}" required>
                                                        @if(!empty($bundle) && !empty($bundle->teacher))
                                                            <option value="{{ $bundle->teacher->id }}" selected>{{ $bundle->teacher->full_name }}</option>
                                                        @endif
                                                    </select>
                                                    @error('teacher_id')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="form-group">
                                                    <label class="input-label">{{ trans('admin/main.description') }}</label>
                                                    <textarea name="description" class="summernote form-control @error('description') is-invalid @enderror" rows="6" required>{{ !empty($bundle) ? $bundle->description : old('description') }}</textarea>
                                                    @error('description')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Tab 2: Additional Info -->
                                    <div class="tab-pane fade" id="extra" role="tabpanel">
                                        <div class="row">
                                            <div class="col-12 col-md-8">
                                                <div class="form-group">
                                                    <label class="input-label">{{ trans('admin/main.category') }}</label>
                                                    <select name="category_id" id="categoryId" class="form-control" required>
                                                        <option value="">{{ trans('admin/main.select_category') }}</option>
                                                        @foreach($categories as $category)
                                                            <option value="{{ $category->id }}" {{ (!empty($bundle) && $bundle->category_id == $category->id) ? 'selected' : '' }}>{{ $category->title }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('category_id')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="form-group">
                                                    <label class="input-label">{{ trans('admin/main.summary') }}</label>
                                                    <textarea name="summary" class="form-control" rows="3">{{ !empty($bundle) ? $bundle->summary : old('summary') }}</textarea>
                                                </div>

                                                <div class="form-group">
                                                    <label class="input-label">{{ trans('admin/main.seo_description') }}</label>
                                                    <textarea name="seo_description" class="form-control" rows="3">{{ !empty($bundle) ? $bundle->seo_description : old('seo_description') }}</textarea>
                                                </div>

                                                <div class="form-group">
                                                    <label class="input-label">{{ trans('admin/main.tags') }}</label>
                                                    <input type="text" name="tags" class="form-control tagsinput" value="{{ !empty($bundleTags) ? implode(',', $bundleTags) : '' }}" data-role="tagsinput"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Tab 3: Media -->
                                    <div class="tab-pane fade" id="media" role="tabpanel">
                                        <div class="row">
                                            <div class="col-12 col-md-8">
                                                <div class="form-group">
                                                    <label class="input-label">{{ trans('admin/main.thumbnail') }}</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <button type="button" class="input-group-text admin-file-manager" data-input="thumbnail" data-preview="holder">
                                                                <i class="fa fa-upload"></i>
                                                            </button>
                                                        </div>
                                                        <input type="text" name="thumbnail" id="thumbnail" value="{{ !empty($bundle) ? $bundle->thumbnail : old('thumbnail') }}" class="form-control @error('thumbnail') is-invalid @enderror" required/>
                                                        @error('thumbnail')
                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="input-label">{{ trans('admin/main.cover_image') }}</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <button type="button" class="input-group-text admin-file-manager" data-input="image_cover" data-preview="holder">
                                                                <i class="fa fa-upload"></i>
                                                            </button>
                                                        </div>
                                                        <input type="text" name="image_cover" id="image_cover" value="{{ !empty($bundle) ? $bundle->image_cover : old('image_cover') }}" class="form-control @error('image_cover') is-invalid @enderror" required/>
                                                        @error('image_cover')
                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="input-label">{{ trans('update.video_demo_source') }}</label>
                                                    <select name="video_demo_source" class="form-control">
                                                        <option value="">{{ trans('update.select_video_source') }}</option>
                                                        <option value="upload" {{ (!empty($bundle) && $bundle->video_demo_source == 'upload') ? 'selected' : '' }}>{{ trans('update.upload') }}</option>
                                                        <option value="youtube" {{ (!empty($bundle) && $bundle->video_demo_source == 'youtube') ? 'selected' : '' }}>Youtube</option>
                                                        <option value="vimeo" {{ (!empty($bundle) && $bundle->video_demo_source == 'vimeo') ? 'selected' : '' }}>Vimeo</option>
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label class="input-label">{{ trans('update.video_demo') }}</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <button type="button" class="input-group-text admin-file-manager" data-input="video_demo">
                                                                    <i class="fa fa-upload"></i>
                                                            </button>
                                                        </div>
                                                        <input type="text" name="video_demo" id="video_demo" value="{{ !empty($bundle) ? $bundle->video_demo : old('video_demo') }}" class="form-control"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Tab 4: Price & Access -->
                                    <div class="tab-pane fade" id="price" role="tabpanel">
                                        <div class="row">
                                            <div class="col-12 col-md-8">
                                                <div class="form-group">
                                                    <label class="input-label">{{ trans('admin/main.price') }} ({{ $currency ?? currency() }})</label>
                                                    <input type="number" name="price" value="{{ !empty($bundle) ? $bundle->price : old('price') }}" class="form-control" placeholder="{{ trans('admin/main.free') }}"/>
                                                </div>

                                                <div class="form-group">
                                                    <label class="input-label">{{ trans('update.access_days') }}</label>
                                                    <input type="number" name="access_days" value="{{ !empty($bundle) ? $bundle->access_days : old('access_days') }}" class="form-control"/>
                                                    <div class="text-small text-muted mt-1">{{ trans('update.access_days_hint') }}</div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="input-label">{{ trans('update.points') }}</label>
                                                    <input type="number" name="points" value="{{ !empty($bundle) ? $bundle->points : old('points') }}" class="form-control"/>
                                                </div>

                                                <div class="form-group custom-switches-stacked">
                                                    <label class="custom-switch pl-0 d-flex align-items-center mb-3">
                                                        <input type="checkbox" name="subscribe" id="subscribeSwitch" value="on" {{ (!empty($bundle) && $bundle->subscribe) ? 'checked="checked"' : '' }} class="custom-switch-input"/>
                                                        <span class="custom-switch-indicator"></span>
                                                        <label class="custom-switch-description mb-0 ml-2" for="subscribeSwitch">{{ trans('admin/main.subscribe') }}</label>
                                                    </label>
                                                    
                                                    <label class="custom-switch pl-0 d-flex align-items-center mb-3">
                                                        <input type="checkbox" name="certificate" id="certSwitch" value="on" {{ (!empty($bundle) && $bundle->certificate) ? 'checked="checked"' : '' }} class="custom-switch-input"/>
                                                        <span class="custom-switch-indicator"></span>
                                                        <label class="custom-switch-description mb-0 ml-2" for="certSwitch">{{ trans('admin/main.certificate') }}</label>
                                                    </label>
                                                    
                                                    <label class="custom-switch pl-0 d-flex align-items-center mb-3">
                                                        <input type="checkbox" name="private" id="privateSwitch" value="on" {{ (!empty($bundle) && $bundle->private) ? 'checked="checked"' : '' }} class="custom-switch-input"/>
                                                        <span class="custom-switch-indicator"></span>
                                                        <label class="custom-switch-description mb-0 ml-2" for="privateSwitch">{{ trans('admin/main.private') }}</label>
                                                    </label>
                                                </div>

                                                <div class="form-group">
                                                    <label class="input-label">{{ trans('admin/main.message_for_reviewer') }}</label>
                                                    <textarea name="message_for_reviewer" class="form-control" rows="3">{{ !empty($bundle) ? $bundle->message_for_reviewer : '' }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-right mt-4 col-12 col-md-8">
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
    <script src="/assets/default/vendors/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>
    <script src="/assets/default/vendors/summernote/summernote-bs4.min.js"></script>
    <script>
        (function ($) {
            "use strict";

            // Init select2 user search
            handleSearchableSelect2('search-user-select2', '{{ getAdminPanelUrl() }}' + '/users/search', 'name');
        })(jQuery);
    </script>
@endpush
