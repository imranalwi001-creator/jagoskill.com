@extends('admin.layouts.app')

@push('libraries_top')
    <link rel="stylesheet" href="/assets/default/vendors/select2/select2.min.css">
@endpush

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ $pageTitle }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}">{{trans('admin/main.dashboard')}}</a>
                </div>
                <div class="breadcrumb-item">{{ $pageTitle }}</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            @can('admin_users_not_access_content_toggle')
                                <button type="button" class="btn btn-primary" id="addUserBtn" data-toggle="modal" data-target="#addUserModal">
                                    <i class="fa fa-plus"></i> {{ trans('update.add_user') }}
                                </button>
                            @endcan
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped font-14">
                                    <tr>
                                        <th>{{ trans('admin/main.id') }}</th>
                                        <th class="text-left">{{ trans('admin/main.name') }}</th>
                                        <th class="text-center">{{ trans('admin/main.email') }}</th>
                                        <th class="text-center">{{ trans('admin/main.mobile') }}</th>
                                        <th class="text-center">{{ trans('admin/main.role') }}</th>
                                        <th class="text-center">{{ trans('admin/main.created_at') }}</th>
                                        <th class="text-right">{{ trans('admin/main.actions') }}</th>
                                    </tr>

                                    @foreach($users as $user)
                                        <tr>
                                            <td>{{ $user->id }}</td>
                                            <td class="text-left">
                                                <div class="d-flex align-items-center">
                                                    <figure class="avatar mr-2">
                                                        <img src="{{ $user->getAvatar() }}" alt="{{ $user->full_name }}">
                                                    </figure>
                                                    <div class="media-body ml-1">
                                                        <div class="mt-0 mb-1 font-weight-bold">{{ $user->full_name }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">{{ $user->email }}</td>
                                            <td class="text-center">{{ $user->mobile }}</td>
                                            <td class="text-center">
                                                <span class="badge badge-primary">{{ $user->role_name }}</span>
                                            </td>
                                            <td class="text-center">{{ dateTimeFormat($user->created_at, 'j M Y') }}</td>

                                            <td class="text-right">
                                                @can('admin_users_not_access_content_toggle')
                                                    @include('admin.includes.delete_button',[
                                                        'url' => getAdminPanelUrl("/users/not-access-to-content/{$user->id}/active"),
                                                        'btnClass' => 'btn-sm btn-transparent text-primary',
                                                        'btnIcon' => 'tick-square',
                                                        'iconType' => 'lin',
                                                        'iconClass' => 'text-success',
                                                        'tooltip' => trans('update.active_content_access'),
                                                        'deleteConfirmMsg' => trans('update.active_content_access_confirm'),
                                                    ])
                                                @endcan

                                                @can('admin_users_edit')
                                                    <a href="{{ getAdminPanelUrl() }}/users/{{ $user->id }}/edit" class="btn-transparent text-primary ml-1" data-toggle="tooltip" data-placement="top" title="{{ trans('admin/main.edit') }}">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>

                        <div class="card-footer text-center">
                            {{ $users->appends(request()->input())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Add User Modal -->
    @can('admin_users_not_access_content_toggle')
        <div class="modal fade" id="addUserModal" aria-labelledby="addUserModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addUserModalLabel">{{ trans('admin/main.add') }} {{ trans('admin/main.user') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="restrictAccessForm">
                            <div class="form-group">
                                <label class="input-label">{{ trans('admin/main.user') }}</label>
                                <select name="user_id" id="modalUserSelect" class="form-control"
                                        data-placeholder="{{ trans('public.search_user') }}">
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('admin/main.cancel') }}</button>
                        <button type="button" class="btn btn-danger" id="restrictAccessBtn">{{ trans('admin/main.submit') }}</button>
                    </div>
                </div>
            </div>
        </div>
    @endcan
@endsection

@push('scripts_bottom')
    <script src="/assets/default/vendors/select2/select2.min.js"></script>
    <script>
        (function ($) {
            "use strict";

            var adminPanelPrefix = '{{ getAdminPanelUrl() }}';

            // Initialize Select2 inside modal with dropdownParent to fix focus issue
            $('#addUserModal').on('shown.bs.modal', function () {
                $('#modalUserSelect').select2({
                    dropdownParent: $('#addUserModal'),
                    placeholder: '{{ trans('public.search_user') }}',
                    minimumInputLength: 3,
                    allowClear: true,
                    ajax: {
                        url: adminPanelPrefix + '/users/search',
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
                                        text: item.name || item.full_name,
                                        id: item.id
                                    }
                                })
                            };
                        },
                        cache: true
                    }
                });
            });

            $('#restrictAccessBtn').on('click', function () {
                var userId = $('#modalUserSelect').val();
                if (!userId) {
                    alert('{{ trans('public.search_user') }}');
                    return;
                }

                $.ajax({
                    url: adminPanelPrefix + '/users/not-access-to-content',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        user_id: userId
                    },
                    success: function (result) {
                        if (result.code === 200) {
                            location.reload();
                        }
                    },
                    error: function (err) {
                        alert('{{ trans('public.request_failed') }}');
                    }
                });
            });
        })(jQuery);
    </script>
@endpush
