@extends('admin.layouts.app')

@push('styles_top')
    <link rel="stylesheet" href="/assets/default/vendors/select2/select2.min.css">
@endpush

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ !empty($feature) ? trans('update.edit_featured_topic') : trans('update.new_featured_topic') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}">{{ trans('admin/main.dashboard') }}</a></div>
                <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}/featured-topics">{{ trans('update.featured_topics') }}</a></div>
                <div class="breadcrumb-item">{{ !empty($feature) ? trans('admin/main.edit') : trans('admin/main.new') }}</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ getAdminPanelUrl() }}/featured-topics/{{ !empty($feature) ? $feature->id.'/update' : 'store' }}" method="post">
                                {{ csrf_field() }}

                                <div class="form-group">
                                    <label class="input-label">{{ trans('update.topic') }}</label>
                                    <select name="topic_id" id="topicSelect" class="form-control @error('topic_id') is-invalid @enderror" data-placeholder="{{ trans('update.search_topic') }}">
                                        @if(!empty($feature) && !empty($feature->topic))
                                            <option value="{{ $feature->topic->id }}" selected>{{ $feature->topic->title }}</option>
                                        @endif
                                    </select>
                                    @error('topic_id')
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
                                        <input type="text" name="icon" id="icon" value="{{ !empty($feature) ? $feature->icon : old('icon') }}" class="form-control @error('icon') is-invalid @enderror"/>
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

            $('#topicSelect').select2({
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
