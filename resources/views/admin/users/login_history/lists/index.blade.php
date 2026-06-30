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
            <!-- Filter Section -->
            <div class="card">
                <div class="card-body">
                    <form action="{{ getAdminPanelUrl() }}/users/login-history" method="get">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="input-label">{{ trans('admin/main.search') }}</label>
                                    <input type="text" name="search" value="{{ request()->get('search') }}" class="form-control" placeholder="{{ trans('public.search_user') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="input-label">{{ trans('admin/main.status') }}</label>
                                    <select name="session_status" class="form-control">
                                        <option value="">{{ trans('admin/main.all') }}</option>
                                        <option value="open" {{ request()->get('session_status') == 'open' ? 'selected' : '' }}>{{ trans('admin/main.open') }}</option>
                                        <option value="ended" {{ request()->get('session_status') == 'ended' ? 'selected' : '' }}>{{ trans('update.ended') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="input-label">{{ trans('admin/main.from') }}</label>
                                    <input type="date" name="from" value="{{ request()->get('from') }}" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="input-label">{{ trans('admin/main.to') }}</label>
                                    <input type="date" name="to" value="{{ request()->get('to') }}" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12 text-right">
                                <button type="submit" class="btn btn-primary">{{ trans('admin/main.show_results') }}</button>
                                @can('admin_user_login_history_export')
                                    <a href="{{ getAdminPanelUrl() }}/users/login-history/export?{{ http_build_query(request()->all()) }}" class="btn btn-success ml-2">
                                        <i class="fa fa-file-excel"></i> {{ trans('admin/main.export_xls') }}
                                    </a>
                                @endcan
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- List Section -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped font-14">
                                    <thead>
                                        <tr>
                                            <th>{{ trans('admin/main.user') }}</th>
                                            <th>{{ trans('update.ip') }}</th>
                                            <th>{{ trans('admin/main.location') }}</th>
                                            <th>{{ trans('update.browser') }} / {{ trans('update.os') }} / {{ trans('update.device') }}</th>
                                            <th class="text-center">{{ trans('update.session_start') }}</th>
                                            <th class="text-center">{{ trans('update.session_end') }}</th>
                                            <th class="text-right">{{ trans('admin/main.actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($sessions as $session)
                                            <tr>
                                                <td>
                                                    @if(!empty($session->user))
                                                        <div class="d-flex align-items-center">
                                                            <figure class="avatar mr-2">
                                                                <img src="{{ $session->user->getAvatar() }}" alt="{{ $session->user->full_name }}">
                                                            </figure>
                                                            <div class="media-body">
                                                                <div class="mt-0 mb-1 font-weight-bold">{{ $session->user->full_name }}</div>
                                                                <div class="text-primary text-small font-600-bold">{{ $session->user->role_name }}</div>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <span class="text-muted">{{ trans('admin/main.deleted_user') }}</span>
                                                    @endif
                                                </td>
                                                <td>{{ $session->ip }}</td>
                                                <td>
                                                    {{ $session->city ?? '-' }} / {{ $session->country ?? '-' }}
                                                </td>
                                                <td>
                                                    {{ $session->browser ?? '-' }} / {{ $session->os ?? '-' }} / {{ $session->device ?? '-' }}
                                                </td>
                                                <td class="text-center">
                                                    @if(!empty($session->session_start_at))
                                                        {{ dateTimeFormat($session->session_start_at, 'j M Y H:i:s') }}
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if(!empty($session->session_end_at))
                                                        <div class="text-success">{{ dateTimeFormat($session->session_end_at, 'j M Y H:i:s') }}</div>
                                                        <div class="text-small text-muted">({{ trans('update.'.$session->end_session_type) }})</div>
                                                    @else
                                                        <span class="badge badge-warning">{{ trans('admin/main.open') }}</span>
                                                    @endif
                                                </td>
                                                <td class="text-right">
                                                    @if(empty($session->session_end_at))
                                                        @can('admin_user_login_history_end_session')
                                                            <a href="{{ getAdminPanelUrl() }}/users/login-history/{{ $session->id }}/end-session" class="btn-transparent text-warning" data-toggle="tooltip" data-placement="top" title="{{ trans('update.end_session') }}">
                                                                <i class="fa fa-times-circle"></i>
                                                            </a>
                                                        @endcan
                                                    @endif

                                                    @can('admin_user_login_history_delete')
                                                        @include('admin.includes.delete_button',[
                                                            'url' => getAdminPanelUrl("/users/login-history/{$session->id}/delete"),
                                                            'btnClass' => 'btn-sm btn-transparent text-primary ml-1',
                                                            'btnIcon' => 'trash',
                                                            'iconType' => 'lin',
                                                            'iconClass' => 'text-danger',
                                                        ])
                                                    @endcan
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            {{ $sessions->appends(request()->input())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
