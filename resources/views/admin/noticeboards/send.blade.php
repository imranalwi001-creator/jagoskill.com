@extends('admin.layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ $pageTitle }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}">{{ trans('admin/main.dashboard') }}</a></div>
                <div class="breadcrumb-item">{{ $pageTitle }}</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    <form action="{{ !empty($noticeboard) ? getAdminPanelUrl("/course-noticeboards/{$noticeboard->id}/update") : getAdminPanelUrl('/course-noticeboards/store') }}" method="post">
                        {{ csrf_field() }}

                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label class="input-label">{{ trans('admin/main.title') }}</label>
                                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $noticeboard->title ?? '') }}">
                                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label class="input-label">{{ trans('admin/main.course') }}</label>
                                    <select name="webinar_id" class="form-control search-webinar-select2 @error('webinar_id') is-invalid @enderror" data-placeholder="{{ trans('admin/main.search') }}">
                                        @if(!empty($noticeboard) and !empty($noticeboard->webinar))
                                            <option value="{{ $noticeboard->webinar->id }}" selected>{{ $noticeboard->webinar->title }}</option>
                                        @endif
                                    </select>
                                    @error('webinar_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="input-label">{{ trans('admin/main.color') }}</label>
                            <input type="color" name="color" class="form-control @error('color') is-invalid @enderror" value="{{ old('color', $noticeboard->color ?? '#1aa394') }}">
                            @error('color')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group">
                            <label class="input-label">{{ trans('admin/main.message') }}</label>
                            <textarea name="message" rows="8" class="form-control @error('message') is-invalid @enderror">{{ old('message', $noticeboard->message ?? '') }}</textarea>
                            @error('message')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">{{ trans('admin/main.save_change') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
