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
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            @can('admin_user_ip_restriction_create')
                                <button type="button" class="btn btn-primary js-add-restriction">
                                    <i class="fa fa-plus"></i> {{ trans('update.add_new_restriction') }}
                                </button>
                            @endcan
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped font-14">
                                    <thead>
                                        <tr>
                                            <th>{{ trans('admin/main.id') }}</th>
                                            <th>{{ trans('admin/main.type') }}</th>
                                            <th>{{ trans('admin/main.value') }}</th>
                                            <th>{{ trans('update.reason') }}</th>
                                            <th class="text-center">{{ trans('admin/main.created_at') }}</th>
                                            <th class="text-right">{{ trans('admin/main.actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($restrictions as $restriction)
                                            <tr>
                                                <td>{{ $restriction->id }}</td>
                                                <td>
                                                    @if($restriction->type == 'full_ip')
                                                        {{ trans('update.full_ip') }}
                                                    @elseif($restriction->type == 'ip_range')
                                                        {{ trans('update.ip_range') }}
                                                    @elseif($restriction->type == 'country')
                                                        {{ trans('admin/main.country') }}
                                                    @endif
                                                </td>
                                                <td>{{ $restriction->value }}</td>
                                                <td>{{ $restriction->reason }}</td>
                                                <td class="text-center">{{ dateTimeFormat($restriction->created_at, 'j M Y H:i') }}</td>
                                                <td class="text-right">
                                                    @can('admin_user_ip_restriction_create')
                                                        <button type="button" data-id="{{ $restriction->id }}" class="btn-transparent text-primary js-edit-restriction" data-toggle="tooltip" data-placement="top" title="{{ trans('admin/main.edit') }}">
                                                            <i class="fa fa-edit"></i>
                                                        </button>
                                                    @endcan

                                                    @can('admin_user_ip_restriction_delete')
                                                        @include('admin.includes.delete_button',[
                                                            'url' => getAdminPanelUrl("/users/ip-restriction/{$restriction->id}/delete"),
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
                            {{ $restrictions->appends(request()->input())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal Container -->
    <div id="restrictionModalContainer"></div>
@endsection

@push('scripts_bottom')
    <script>
        (function ($) {
            "use strict";

            var adminPanelPrefix = '{{ getAdminPanelUrl() }}';

            function loadRestrictionModal(url) {
                $.get(url, function (result) {
                    if (result.code === 200) {
                        $('#restrictionModalContainer').html(result.html);
                        $('#restrictionModal').modal('show');
                    }
                });
            }

            $('.js-add-restriction').on('click', function () {
                loadRestrictionModal(adminPanelPrefix + '/users/ip-restriction/get-form');
            });

            $('body').on('click', '.js-edit-restriction', function () {
                var id = $(this).data('id');
                loadRestrictionModal(adminPanelPrefix + '/users/ip-restriction/' + id + '/edit');
            });

            $('body').on('click', '#saveRestrictionBtn', function () {
                var form = $('#restrictionForm');
                var action = form.attr('action');
                var data = form.serialize();

                $.ajax({
                    url: action,
                    type: 'POST',
                    data: data,
                    success: function (result) {
                        if (result.code === 200) {
                            location.reload();
                        }
                    },
                    error: function (xhr) {
                        var errors = xhr.responseJSON.errors;
                        form.find('.is-invalid').removeClass('is-invalid');
                        form.find('.invalid-feedback').html('');

                        if (errors) {
                            Object.keys(errors).forEach(function (key) {
                                var input = form.find('[name="' + key + '"]');
                                if (input.length) {
                                    input.addClass('is-invalid');
                                    input.siblings('.invalid-feedback').html(errors[key][0]);
                                }
                            });
                        }
                    }
                });
            });

            $('body').on('change', 'select[name="type"]', function () {
                var type = $(this).val();
                $('.js-restriction-field').addClass('d-none');
                if (type) {
                    $('.js-field-' + type).removeClass('d-none');
                }
            });
        })(jQuery);
    </script>
@endpush
