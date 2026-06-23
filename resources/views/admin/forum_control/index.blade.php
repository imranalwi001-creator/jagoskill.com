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
            <div class="row">
                <div class="col-12 col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Forum Page Access</h5>
                        </div>

                        <div class="card-body">
                            <form action="{{ getAdminPanelUrl('/forum-control') }}" method="post">
                                {{ csrf_field() }}

                                <div class="form-group custom-switches-stacked mb-4">
                                    <label class="custom-switch pl-0 mb-0">
                                        <input type="checkbox" name="forums_status" id="forumsStatusSwitch" value="1" {{ $forumEnabled ? 'checked="checked"' : '' }} class="custom-switch-input"/>
                                        <span class="custom-switch-indicator"></span>
                                        <span class="custom-switch-description mb-0 cursor-pointer">Enable public forum page</span>
                                    </label>
                                    <p class="font-12 text-gray-500 mt-2 mb-0">This controls the same forum status used by <code>/forums</code>.</p>
                                </div>

                                <div class="d-flex align-items-center">
                                    <button type="submit" class="btn btn-primary mr-2">{{ trans('admin/main.submit') }}</button>
                                    <a href="/forums" target="_blank" class="btn btn-outline-primary">Open Forum</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Current Status</h5>
                        </div>

                        <div class="card-body">
                            @if($forumEnabled)
                                <div class="alert alert-success mb-0">Forum page is enabled.</div>
                            @else
                                <div class="alert alert-warning mb-0">Forum page is disabled.</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
