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
                <div class="breadcrumb-item"><a href="{{ getAdminPanelUrl() }}/abandoned-cart/rules">{{ trans('update.abandoned_cart_rules') }}</a></div>
                <div class="breadcrumb-item">{{ $pageTitle}}</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-8 col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ getAdminPanelUrl('/abandoned-cart/rules/' . (!empty($rule) ? $rule->id . '/update' : 'store')) }}" method="post">
                                {{ csrf_field() }}

                                @if(!empty(getGeneralSettings('content_translate')))
                                    <div class="form-group">
                                        <label class="input-label">{{ trans('auth.language') }}</label>
                                        <select name="locale" class="form-control {{ !empty($rule) ? 'js-edit-content-locale' : '' }}">
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
                                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ !empty($rule) ? $rule->title : old('title') }}"/>
                                    @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>{{ trans('admin/main.discount') }}</label>
                                    <select name="discount_id" class="form-control select2 @error('discount_id') is-invalid @enderror">
                                        <option value="">{{ trans('admin/main.select') }}</option>
                                        @if(!empty($discounts))
                                            @foreach($discounts as $discount)
                                                <option value="{{ $discount->id }}" {{ (!empty($rule) and $rule->discount_id == $discount->id) ? 'selected' : '' }}>{{ $discount->title }} ({{ $discount->percent }}%)</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('discount_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>{{ trans('admin/main.user_group') }}</label>
                                    <select name="users_group_id" class="form-control select2 @error('users_group_id') is-invalid @enderror">
                                        <option value="">{{ trans('admin/main.all') }}</option>
                                        @if(!empty($userGroups))
                                            @foreach($userGroups as $group)
                                                <option value="{{ $group->id }}" {{ (!empty($rule) and $rule->users_group_id == $group->id) ? 'selected' : '' }}>{{ $group->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>{{ trans('admin/main.category') }}</label>
                                    <select name="category_id" class="form-control select2 @error('category_id') is-invalid @enderror">
                                        <option value="">{{ trans('admin/main.all') }}</option>
                                        @if(!empty($categories))
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ (!empty($rule) and $rule->category_id == $category->id) ? 'selected' : '' }}>{{ $category->title }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label>{{ trans('update.action_cycle_days') }}</label>
                                            <input type="number" name="action_cycle_days" class="form-control" value="{{ !empty($rule) ? $rule->action_cycle_days : old('action_cycle_days', 0) }}"/>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label>{{ trans('update.action_cycle_hours') }}</label>
                                            <input type="number" name="action_cycle_hours" class="form-control" value="{{ !empty($rule) ? $rule->action_cycle_hours : old('action_cycle_hours', 2) }}"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group custom-switches-stacked">
                                    <label class="custom-switch pl-0">
                                        <input type="hidden" name="status" value="inactive">
                                        <input type="checkbox" name="status" id="statusSwitch" value="active" {{ (!empty($rule) and $rule->status == 'active') ? 'checked="checked"' : '' }} class="custom-switch-input"/>
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

@push('scripts_bottom')
    <script src="/assets/default/vendors/select2/select2.min.js"></script>
@endpush
