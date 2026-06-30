@extends('admin.layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ trans('update.featured_categories') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}">{{trans('admin/main.dashboard')}}</a></div>
                <div class="breadcrumb-item">{{ trans('update.featured_categories') }}</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-5">
                    <div class="card">
                        <div class="card-header">
                            <h4>{{ !empty($editFeaturedCategory) ? trans('admin/main.edit') : trans('admin/main.new') }}</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ getAdminPanelUrl() }}/store/featured-categories/{{ !empty($editFeaturedCategory) ? $editFeaturedCategory->id.'/update' : 'store' }}" method="post">
                                {{ csrf_field() }}

                                <div class="form-group">
                                    <label>{{ trans('admin/main.category') }}</label>
                                    <select class="form-control @error('category_id') is-invalid @enderror" name="category_id">
                                        <option {{ empty($editFeaturedCategory) ? 'selected' : '' }} disabled>{{ trans('admin/main.choose_category') }}</option>
                                        @foreach($productCategories as $category)
                                            @if(!empty($category->subCategories) and count($category->subCategories))
                                                <optgroup label="{{  $category->title }}">
                                                    @foreach($category->subCategories as $subCategory)
                                                        <option value="{{ $subCategory->id }}" @if(!empty($editFeaturedCategory) and $editFeaturedCategory->category_id == $subCategory->id) selected="selected" @endif>{{ $subCategory->title }}</option>
                                                    @endforeach
                                                </optgroup>
                                            @else
                                                <option value="{{ $category->id }}" class="font-weight-bold" @if(!empty($editFeaturedCategory) and $editFeaturedCategory->category_id == $category->id) selected="selected" @endif>{{ $category->title }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="input-label">{{ trans('admin/main.icon') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <button type="button" class="input-group-text admin-file-manager " data-input="icon" data-preview="holder">
                                                <i class="fa fa-upload"></i>
                                            </button>
                                        </div>
                                        <input type="text" name="icon" id="icon" value="{{ !empty($editFeaturedCategory) ? $editFeaturedCategory->icon : old('icon') }}" class="form-control @error('icon') is-invalid @enderror" placeholder="{{ trans('admin/main.icon') }}"/>
                                        @error('icon')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class=" mt-4">
                                    <button class="btn btn-primary">{{ trans('admin/main.submit') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-7">
                    <div class="card">
                        <div class="card-header">
                            <h4>{{ trans('update.featured_categories') }}</h4>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table custom-table font-14">
                                    <tr>
                                        <th class="text-left">{{ trans('admin/main.category') }}</th>
                                        <th>{{ trans('admin/main.icon') }}</th>
                                        <th>{{ trans('admin/main.action') }}</th>
                                    </tr>

                                    @if(!empty($featuredCategories))
                                        @foreach($featuredCategories as $featuredCategory)
                                            <tr>
                                                <td class="text-left">{{ !empty($featuredCategory->category) ? $featuredCategory->category->title : '' }}</td>
                                                <td>
                                                    <img src="{{ $featuredCategory->icon }}" width="40" height="40" alt="">
                                                </td>
                                                <td>
                                                    <div class="btn-group dropdown table-actions position-relative">
                                                        <button type="button" class="btn-transparent dropdown-toggle" data-toggle="dropdown">
                                                            <i class="fa fa-ellipsis-v"></i>
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a href="{{ getAdminPanelUrl() }}/store/featured-categories/{{ $featuredCategory->id }}/edit" class="dropdown-item">{{ trans('admin/main.edit') }}</a>
                                                            <a href="{{ getAdminPanelUrl() }}/store/featured-categories/{{ $featuredCategory->id }}/delete" class="dropdown-item text-danger delete-action" data-confirm-text="{{ trans('public.confirm_delete') }}">{{ trans('admin/main.delete') }}</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
