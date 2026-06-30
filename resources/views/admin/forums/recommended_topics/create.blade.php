@extends('admin.layouts.app')

@push('styles_top')
    <link rel="stylesheet" href="/assets/default/vendors/select2/select2.min.css">
@endpush

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ !empty($recommended) ? trans('update.edit_recommended_topic') : trans('update.new_recommended_topic') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}">{{ trans('admin/main.dashboard') }}</a></div>
                <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}/recommended-topics">{{ trans('update.recommended_topics') }}</a></div>
                <div class="breadcrumb-item">{{ !empty($recommended) ? trans('admin/main.edit') : trans('admin/main.new') }}</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ getAdminPanelUrl() }}/recommended-topics/{{ !empty($recommended) ? $recommended->id.'/update' : 'store' }}" method="post">
                                {{ csrf_field() }}

                                @if(!empty(getGeneralSettings('content_translate')))
                                    <div class="form-group">
                                        <label class="input-label">{{ trans('auth.language') }}</label>
                                        <select name="locale" class="form-control {{ !empty($recommended) ? 'js-edit-content-locale' : '' }}">
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
                                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ !empty($recommended) ? $recommended->title : old('title') }}" placeholder="{{ trans('admin/main.choose_title') }}"/>
                                    @error('title')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>{{ trans('update.subtitle') }}</label>
                                    <input type="text" name="subtitle" class="form-control @error('subtitle') is-invalid @enderror" value="{{ !empty($recommended) ? $recommended->subtitle : old('subtitle') }}" placeholder="{{ trans('admin/main.choose_subtitle') }}"/>
                                    @error('subtitle')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="input-label">{{ trans('update.topics') }}</label>
                                    <select name="topic_ids[]" id="topicsSelect" multiple="multiple" class="form-control @error('topic_ids') is-invalid @enderror" data-placeholder="{{ trans('update.search_topic') }}">
                                        @if(!empty($recommended) && !empty($recommended->topics))
                                            @foreach($recommended->topics as $topic)
                                                <option value="{{ $topic->id }}" selected>{{ $topic->title }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('topic_ids')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
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
                                        <input type="text" name="icon" id="icon" value="{{ !empty($recommended) ? $recommended->icon : old('icon') }}" class="form-control @error('icon') is-invalid @enderror"/>
                                        <div class="input-group-append">
                                            <button type="button" class="input-group-text admin-file-view" data-input="icon">
                                                <i class="fa fa-eye"></i>
                                            </button>
                                        </div>
                                        @error('icon')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="text-right mt-4">
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
    <script>
        (function ($) {
            "use strict";

            var adminPanelPrefix = '{{ getAdminPanelUrl() }}';

            $('#topicsSelect').select2({
                placeholder: '{{ trans('update.search_topic') }}',
                minimumInputLength: 3,
                allowClear: true,
                ajax: {
                    url: adminPanelPrefix + '/forums/search-topics',
                    dataType: 'json',
                    type: 'GET',
                    delay: 250,
                    data: function (params) {
                        return {
                            term: params.term
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (item) {
                                return {
                                    text: item.title,
                                    id: item.id
                                }
                            })
                        };
                    },
                    cache: true
                }
            });
        })(jQuery);
    </script>
@endpush
