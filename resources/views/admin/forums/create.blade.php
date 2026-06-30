@extends('admin.layouts.app')

@push('styles_top')
    <link href="/assets/default/vendors/sortable/jquery-ui.min.css"/>
    <link rel="stylesheet" href="/assets/default/vendors/summernote/summernote-bs4.min.css">
@endpush

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ !empty($forum) ? trans('admin/main.edit') : trans('admin/main.new') }} {{ trans('update.forum') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}">{{ trans('admin/main.dashboard') }}</a></div>
                <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}/forums">{{ trans('update.forums') }}</a></div>
                <div class="breadcrumb-item">{{ !empty($forum) ? trans('admin/main.edit') : trans('admin/main.new') }}</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-8 col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ getAdminPanelUrl() }}/forums/{{ !empty($forum) ? $forum->id.'/update' : 'store' }}" method="post">
                                {{ csrf_field() }}

                                @if(!empty(getGeneralSettings('content_translate')))
                                    <div class="form-group">
                                        <label class="input-label">{{ trans('auth.language') }}</label>
                                        <select name="locale" class="form-control {{ !empty($forum) ? 'js-edit-content-locale' : '' }}">
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
                                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ !empty($forum) ? $forum->title : old('title') }}" placeholder="{{ trans('admin/main.choose_title') }}"/>
                                    @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="control-label">{{ trans('admin/main.description') }}</label>
                                    <textarea name="description" class="summernote form-control @error('description') is-invalid @enderror" rows="5">{{ !empty($forum) ? $forum->description : old('description') }}</textarea>
                                    @error('description')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="input-label">{{ trans('admin/main.icon') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <button type="button" class="input-group-text admin-file-manager" data-input="icon" data-preview="holder">
                                                <i class="fa fa-upload"></i>
                                            </button>
                                        </div>
                                        <input type="text" name="icon" id="icon" value="{{ !empty($forum) ? $forum->icon : old('icon') }}" class="form-control @error('icon') is-invalid @enderror"/>
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
                                    <label class="input-label">{{ trans('admin/main.cover_image') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <button type="button" class="input-group-text admin-file-manager" data-input="cover" data-preview="holder">
                                                <i class="fa fa-upload"></i>
                                            </button>
                                        </div>
                                        <input type="text" name="cover" id="cover" value="{{ !empty($forum) ? $forum->cover : old('cover') }}" class="form-control @error('cover') is-invalid @enderror"/>
                                        <div class="input-group-append">
                                            <button type="button" class="input-group-text admin-file-view" data-input="cover">
                                                <i class="fa fa-eye"></i>
                                            </button>
                                        </div>
                                        @error('cover')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="input-label">{{ trans('admin/main.role') }} ({{ trans('update.accessibility') }})</label>
                                            <select name="role_id" class="form-control">
                                                <option value="">{{ trans('admin/main.all') }}</option>
                                                @foreach($roles as $role)
                                                    <option value="{{ $role->id }}" {{ (!empty($forum) && $forum->role_id == $role->id) ? 'selected' : '' }}>{{ $role->caption }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="input-label">{{ trans('admin/main.group') }} ({{ trans('update.accessibility') }})</label>
                                            <select name="group_id" class="form-control">
                                                <option value="">{{ trans('admin/main.all') }}</option>
                                                @foreach($userGroups as $group)
                                                    <option value="{{ $group->id }}" {{ (!empty($forum) && $forum->group_id == $group->id) ? 'selected' : '' }}>{{ $group->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="input-label">{{ trans('admin/main.status') }}</label>
                                            <select name="status" class="form-control">
                                                <option value="active" {{ (!empty($forum) && $forum->status == 'active') ? 'selected' : '' }}>{{ trans('admin/main.active') }}</option>
                                                <option value="disabled" {{ (!empty($forum) && $forum->status == 'disabled') ? 'selected' : '' }}>{{ trans('admin/main.disabled') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group custom-switches-stacked mt-4">
                                            <label class="custom-switch pl-0">
                                                <input type="hidden" name="close" value="0">
                                                <input type="checkbox" name="close" id="closeSwitch" value="1" {{ (!empty($forum) && $forum->close) ? 'checked="checked"' : '' }} class="custom-switch-input"/>
                                                <span class="custom-switch-indicator"></span>
                                                <label class="custom-switch-description mb-0 cursor-pointer" for="closeSwitch">{{ trans('admin/main.close') }}</label>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Sub Forums Toggle -->
                                <div class="form-group mt-4">
                                    <div class="custom-control custom-checkbox">
                                        <input id="hasSubForum" type="checkbox" name="has_sub" class="custom-control-input" {{ (!empty($subForums) && !$subForums->isEmpty()) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="hasSubForum">{{ trans('update.has_sub_forum') }}</label>
                                    </div>
                                </div>

                                <!-- Sub Forums Container -->
                                <div id="subForumsContainer" class="ml-0 {{ (!empty($subForums) && !$subForums->isEmpty()) ? '' : 'd-none' }}">
                                    <div class="d-flex align-items-center justify-content-between mb-4">
                                        <strong class="d-block">{{ trans('update.sub_forums') }}</strong>
                                        <button type="button" class="btn btn-success add-btn"><i class="fa fa-plus"></i> {{ trans('admin/main.add') }}</button>
                                    </div>

                                    <ul class="draggable-lists list-group">
                                        @if(!empty($subForums) && !$subForums->isEmpty())
                                            @foreach($subForums as $subForum)
                                                <li class="form-group list-group p-3 border rounded mb-3">
                                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                                        <span class="font-weight-bold">{{ trans('update.sub_forum') }}</span>
                                                        <button type="button" class="remove-btn btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                                    </div>

                                                    <input type="hidden" name="sub_forums[{{ $subForum->id }}][id]" value="{{ $subForum->id }}">

                                                    <div class="form-group">
                                                        <label>{{ trans('admin/main.title') }}</label>
                                                        <input type="text" name="sub_forums[{{ $subForum->id }}][title]" value="{{ $subForum->title }}" class="form-control" required>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>{{ trans('admin/main.description') }}</label>
                                                        <textarea name="sub_forums[{{ $subForum->id }}][description]" rows="3" class="form-control" required>{{ $subForum->description }}</textarea>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>{{ trans('admin/main.icon') }}</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <button type="button" class="input-group-text admin-file-manager" data-input="icon_{{ $subForum->id }}">
                                                                    <i class="fa fa-upload"></i>
                                                                </button>
                                                            </div>
                                                            <input type="text" name="sub_forums[{{ $subForum->id }}][icon]" id="icon_{{ $subForum->id }}" class="form-control" value="{{ $subForum->icon }}" required>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-6">
                                                            <label>{{ trans('admin/main.role') }}</label>
                                                            <select name="sub_forums[{{ $subForum->id }}][role_id]" class="form-control">
                                                                <option value="">{{ trans('admin/main.all') }}</option>
                                                                @foreach($roles as $role)
                                                                    <option value="{{ $role->id }}" {{ $subForum->role_id == $role->id ? 'selected' : '' }}>{{ $role->caption }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-6">
                                                            <label>{{ trans('admin/main.group') }}</label>
                                                            <select name="sub_forums[{{ $subForum->id }}][group_id]" class="form-control">
                                                                <option value="">{{ trans('admin/main.all') }}</option>
                                                                @foreach($userGroups as $group)
                                                                    <option value="{{ $group->id }}" {{ $subForum->group_id == $group->id ? 'selected' : '' }}>{{ $group->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="row mt-2">
                                                        <div class="col-6">
                                                            <label>{{ trans('admin/main.status') }}</label>
                                                            <select name="sub_forums[{{ $subForum->id }}][status]" class="form-control">
                                                                <option value="active" {{ $subForum->status == 'active' ? 'selected' : '' }}>{{ trans('admin/main.active') }}</option>
                                                                <option value="disabled" {{ $subForum->status == 'disabled' ? 'selected' : '' }}>{{ trans('admin/main.disabled') }}</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group custom-switches-stacked mt-4">
                                                                <label class="custom-switch pl-0">
                                                                    <input type="checkbox" name="sub_forums[{{ $subForum->id }}][close]" value="1" {{ $subForum->close ? 'checked' : '' }} class="custom-switch-input"/>
                                                                    <span class="custom-switch-indicator"></span>
                                                                    <label class="custom-switch-description mb-0">{{ trans('admin/main.close') }}</label>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
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

    <!-- Sub Forum Template -->
    <div id="subForumTemplate" class="d-none">
        <li class="form-group list-group p-3 border rounded mb-3">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="font-weight-bold">{{ trans('update.sub_forum') }}</span>
                <button type="button" class="remove-btn btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
            </div>

            <div class="form-group">
                <label>{{ trans('admin/main.title') }}</label>
                <input type="text" name="sub_forums[ID_HOLDER][title]" class="form-control" required>
            </div>

            <div class="form-group">
                <label>{{ trans('admin/main.description') }}</label>
                <textarea name="sub_forums[ID_HOLDER][description]" rows="3" class="form-control" required></textarea>
            </div>

            <div class="form-group">
                <label>{{ trans('admin/main.icon') }}</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <button type="button" class="input-group-text admin-file-manager" data-input="icon_ID_HOLDER">
                            <i class="fa fa-upload"></i>
                        </button>
                    </div>
                    <input type="text" name="sub_forums[ID_HOLDER][icon]" id="icon_ID_HOLDER" class="form-control" required>
                </div>
            </div>

            <div class="row">
                <div class="col-6">
                    <label>{{ trans('admin/main.role') }}</label>
                    <select name="sub_forums[ID_HOLDER][role_id]" class="form-control">
                        <option value="">{{ trans('admin/main.all') }}</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->caption }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6">
                    <label>{{ trans('admin/main.group') }}</label>
                    <select name="sub_forums[ID_HOLDER][group_id]" class="form-control">
                        <option value="">{{ trans('admin/main.all') }}</option>
                        @foreach($userGroups as $group)
                            <option value="{{ $group->id }}">{{ $group->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-6">
                    <label>{{ trans('admin/main.status') }}</label>
                    <select name="sub_forums[ID_HOLDER][status]" class="form-control">
                        <option value="active">{{ trans('admin/main.active') }}</option>
                        <option value="disabled">{{ trans('admin/main.disabled') }}</option>
                    </select>
                </div>
                <div class="col-6">
                    <div class="form-group custom-switches-stacked mt-4">
                        <label class="custom-switch pl-0">
                            <input type="checkbox" name="sub_forums[ID_HOLDER][close]" value="1" class="custom-switch-input"/>
                            <span class="custom-switch-indicator"></span>
                            <label class="custom-switch-description mb-0">{{ trans('admin/main.close') }}</label>
                        </label>
                    </div>
                </div>
            </div>
        </li>
    </div>
@endsection

@push('scripts_bottom')
    <script src="/assets/default/vendors/summernote/summernote-bs4.min.js"></script>
    <script>
        (function ($) {
            "use strict";

            $('#hasSubForum').on('change', function () {
                if (this.checked) {
                    $('#subForumsContainer').removeClass('d-none');
                } else {
                    $('#subForumsContainer').addClass('d-none');
                }
            });

            $('#subForumsContainer .add-btn').on('click', function () {
                var randomId = Math.floor(Math.random() * 1000000);
                var html = $('#subForumTemplate').html();
                html = html.replace(/ID_HOLDER/g, 'new_' + randomId);
                $('#subForumsContainer ul.draggable-lists').append(html);
            });

            $('body').on('click', '.remove-btn', function () {
                $(this).closest('li').remove();
            });
        })(jQuery);
    </script>
@endpush
