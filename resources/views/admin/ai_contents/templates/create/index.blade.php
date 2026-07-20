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
                <div class="breadcrumb-item"><a href="{{ getAdminPanelUrl() }}/ai-contents/templates">{{ trans('update.templates') }}</a></div>
                <div class="breadcrumb-item">{{ $pageTitle}}</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-8 col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ getAdminPanelUrl('/ai-contents/templates/' . (!empty($template) ? $template->id . '/update' : 'store')) }}" method="post">
                                {{ csrf_field() }}

                                <div class="form-group">
                                    <label>{{ trans('admin/main.title') }}</label>
                                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ !empty($template) ? $template->title : old('title') }}"/>
                                    @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>{{ trans('admin/main.type') }}</label>
                                    <select name="type" class="form-control @error('type') is-invalid @enderror">
                                        <option value="text" {{ (!empty($template) and $template->type == 'text') ? 'selected' : '' }}>{{ trans('update.text') }}</option>
                                        <option value="image" {{ (!empty($template) and $template->type == 'image') ? 'selected' : '' }}>{{ trans('update.image') }}</option>
                                    </select>
                                    @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label>{{ trans('update.prompt') }}</label>
                                    <textarea name="prompt" class="form-control @error('prompt') is-invalid @enderror" rows="5">{{ !empty($template) ? $template->prompt : old('prompt') }}</textarea>
                                    @error('prompt')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>{{ trans('update.image_size') }}</label>
                                    <select name="image_size" class="form-control @error('image_size') is-invalid @enderror">
                                        <option value="256x256" {{ (!empty($template) and $template->image_size == '256x256') ? 'selected' : '' }}>256x256</option>
                                        <option value="512x512" {{ (!empty($template) and $template->image_size == '512x512') ? 'selected' : '' }}>512x512</option>
                                        <option value="1024x1024" {{ (!empty($template) and $template->image_size == '1024x1024') ? 'selected' : '' }}>1024x1024</option>
                                    </select>
                                </div>

                                <div class="form-group custom-switches-stacked">
                                    <label class="custom-switch pl-0">
                                        <input type="hidden" name="enable" value="0">
                                        <input type="checkbox" name="enable" id="enableSwitch" value="1" {{ (!empty($template) and $template->enable) ? 'checked="checked"' : '' }} class="custom-switch-input"/>
                                        <span class="custom-switch-indicator"></span>
                                        <label class="custom-switch-description mb-0 cursor-pointer" for="enableSwitch">{{ trans('admin/main.active') }}</label>
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
