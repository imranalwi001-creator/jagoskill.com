@extends('admin.layouts.app')

@push('styles_top')
    <link href="/assets/default/vendors/sortable/jquery-ui.min.css" rel="stylesheet"/>
@endpush

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ !empty($specification) ? trans('admin/main.edit') : trans('admin/main.new') }} {{ trans('update.specifications') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}">{{ trans('admin/main.dashboard') }}</a></div>
                <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}/store/specifications">{{ trans('update.specifications') }}</a></div>
                <div class="breadcrumb-item">{{ !empty($specification) ? trans('admin/main.edit') : trans('admin/main.new') }}</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ getAdminPanelUrl() }}/store/specifications/{{ !empty($specification) ? $specification->id.'/update' : 'store' }}" method="Post">
                                {{ csrf_field() }}

                                @if(!empty(getGeneralSettings('content_translate')))
                                    <div class="form-group">
                                        <label class="input-label">{{ trans('auth.language') }}</label>
                                        <select name="locale" class="form-control {{ !empty($specification) ? 'js-edit-content-locale' : '' }}">
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
                                    <input type="text" name="title" class="form-control  @error('title') is-invalid @enderror" value="{{ !empty($specification) ? $specification->title : old('title') }}" placeholder="{{ trans('admin/main.choose_title') }}"/>
                                    @error('title')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>{{ trans('/admin/main.category') }}</label>
                                    <select class="form-control select2 @error('category') is-invalid @enderror" name="category[]" multiple>
                                        <option disabled>{{ trans('admin/main.choose_category') }}</option>
                                        @foreach($categories as $category)
                                            @if(!empty($category->subCategories) and count($category->subCategories))
                                                <optgroup label="{{  $category->title }}">
                                                    @foreach($category->subCategories as $subCategory)
                                                        <option value="{{ $subCategory->id }}" @if(!empty($selectedCategories) and in_array($subCategory->id, $selectedCategories)) selected="selected" @endif>{{ $subCategory->title }}</option>
                                                    @endforeach
                                                </optgroup>
                                            @else
                                                <option value="{{ $category->id }}" class="font-weight-bold" @if(!empty($selectedCategories) and in_array($category->id, $selectedCategories)) selected="selected" @endif>{{ $category->title }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @error('category')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="input-label">{{ trans('update.input_type') }}</label>
                                    <select name="input_type" class="form-control @error('input_type') is-invalid @enderror">
                                        <option value="textarea" @if((!empty($specification) and $specification->input_type == 'textarea') or old('input_type') == 'textarea') selected @endif>{{ trans('update.textarea') }}</option>
                                        <option value="multi_value" @if((!empty($specification) and $specification->input_type == 'multi_value') or old('input_type') == 'multi_value') selected @endif>{{ trans('update.multi_value') }}</option>
                                    </select>
                                    @error('input_type')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div id="multiValues" class="ml-1 {{ (!empty($specification) and $specification->input_type == 'multi_value') ? '' : 'd-none' }}">
                                    <div class="d-flex align-items-center justify-content-between mb-4">
                                        <strong class="d-block">{{ trans('admin/main.add_options') }}</strong>
                                        <button type="button" class="btn btn-success add-btn"><i class="fa fa-plus"></i> {{ trans('admin/main.add') }}</button>
                                    </div>

                                    <ul class="draggable-lists mt-3 list-group">
                                        @if(!empty($multiValues))
                                            @foreach($multiValues as $key => $multiValue)
                                                <li class="form-group list-group rounded-lg p-2 mb-3 position-relative">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text cursor-pointer move-icon">
                                                                <i class="fa fa-arrows-alt"></i>
                                                            </div>
                                                        </div>
                                                        <input type="text" name="multi_values[{{ $multiValue->id }}][title]" class="form-control w-auto flex-grow-1" value="{{ $multiValue->title }}" placeholder="{{ trans('admin/main.choose_title') }}"/>
                                                        <div class="input-group-append">
                                                            <button type="button" class="btn remove-btn btn-danger"><i class="fa fa-times"></i></button>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>

                                <div class="mt-4">
                                    <button class="btn btn-primary">{{ trans('admin/main.submit') }}</button>
                                </div>
                            </form>

                            <li class="form-group main-row list-group rounded-lg p-2 mb-3 position-relative d-none">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text cursor-pointer move-icon">
                                            <i class="fa fa-arrows-alt"></i>
                                        </div>
                                    </div>
                                    <input type="text" name="multi_values[record][title]" class="form-control w-auto flex-grow-1" placeholder="{{ trans('admin/main.choose_title') }}"/>
                                    <div class="input-group-append">
                                        <button type="button" class="btn remove-btn btn-danger"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                            </li>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts_bottom')
    <script src="/assets/default/vendors/sortable/jquery-ui.min.js"></script>
    <script>
        (function ($) {
            "use strict";

            $('body').on('change', 'select[name="input_type"]', function () {
                var value = $(this).val();
                if (value === 'multi_value') {
                    $('#multiValues').removeClass('d-none');
                } else {
                    $('#multiValues').addClass('d-none');
                }
            });

            $('body').on('click', '.add-btn', function (e) {
                e.preventDefault();
                var mainRow = $('.main-row').clone();
                mainRow.removeClass('main-row d-none');
                var copyHtml = mainRow.prop('innerHTML');
                copyHtml = copyHtml.replace(/record/g, randomString());
                mainRow.html(copyHtml);
                $('#multiValues .draggable-lists').append(mainRow);
            });

            $('body').on('click', '.remove-btn', function (e) {
                e.preventDefault();
                $(this).closest('li').remove();
            });
            
            if ($('.draggable-lists').length) {
                $('.draggable-lists').sortable({
                    handle: '.move-icon',
                    cursor: 'move'
                });
            }
        })(jQuery);
    </script>
@endpush
