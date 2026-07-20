@extends('admin.layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ $pageTitle }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}">{{trans('admin/main.dashboard')}}</a></div>
                <div class="breadcrumb-item">{{ $pageTitle}}</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h4>{{ trans('admin/main.add_new') }}</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ getAdminPanelUrl('/rewards/store') }}" method="post" id="rewardForm">
                                {{ csrf_field() }}

                                <div class="form-group">
                                    <label>{{ trans('admin/main.type') }}</label>
                                    <select name="type" class="form-control">
                                        <option value="account_charge">{{ trans('update.account_charge') }}</option>
                                        <option value="create_classes">{{ trans('update.create_classes') }}</option>
                                        <option value="buy">{{ trans('update.buy') }}</option>
                                        <option value="pass_the_quiz">{{ trans('update.pass_the_quiz') }}</option>
                                        <option value="certificate">{{ trans('update.certificate') }}</option>
                                        <option value="comment">{{ trans('update.comment') }}</option>
                                        <option value="register">{{ trans('update.register') }}</option>
                                        <option value="review_courses">{{ trans('update.review_courses') }}</option>
                                        <option value="instructor_meeting_reserve">{{ trans('update.instructor_meeting_reserve') }}</option>
                                        <option value="student_meeting_reserve">{{ trans('update.student_meeting_reserve') }}</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>{{ trans('update.score') }}</label>
                                    <input type="number" name="score" class="form-control" required/>
                                </div>

                                <div class="form-group">
                                    <label>{{ trans('update.condition') }}</label>
                                    <input type="number" name="condition" class="form-control"/>
                                    <p class="text-muted text-small">{{ trans('update.condition_hint') }}</p>
                                </div>

                                <div class="form-group custom-switches-stacked">
                                    <label class="custom-switch pl-0">
                                        <input type="hidden" name="status" value="disabled">
                                        <input type="checkbox" name="status" value="on" class="custom-switch-input"/>
                                        <span class="custom-switch-indicator"></span>
                                        <label class="custom-switch-description mb-0 cursor-pointer">{{ trans('admin/main.active') }}</label>
                                    </label>
                                </div>

                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary">{{ trans('admin/main.submit') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped font-14">
                                    <tr>
                                        <th>{{ trans('admin/main.type') }}</th>
                                        <th class="text-center">{{ trans('update.score') }}</th>
                                        <th class="text-center">{{ trans('update.condition') }}</th>
                                        <th class="text-center">{{ trans('admin/main.status') }}</th>
                                        <th>{{ trans('admin/main.actions') }}</th>
                                    </tr>

                                    @foreach($rewards as $reward)
                                        <tr>
                                            <td>{{ trans('update.' . $reward->type) }}</td>
                                            <td class="text-center text-success">{{ $reward->score }}</td>
                                            <td class="text-center">{{ $reward->condition ?? '-' }}</td>
                                            <td class="text-center">
                                                @if($reward->status == 'active')
                                                    <span class="text-success">{{ trans('admin/main.active') }}</span>
                                                @else
                                                    <span class="text-danger">{{ trans('admin/main.inactive') }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @can('admin_rewards_item_delete')
                                                    @include('admin.includes.delete_button',['url' => getAdminPanelUrl('/rewards/'.$reward->id.'/delete') , 'btnClass' => ''])
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts_bottom')
    <script>
        (function ($) {
            "use strict";

            $('#rewardForm').on('submit', function (e) {
                e.preventDefault();
                var $form = $(this);
                var $btn = $form.find('button[type="submit"]');
                var action = $form.attr('action');
                var data = $form.serialize();

                $btn.addClass('btn-loading');
                $form.find('.invalid-feedback').remove();
                $form.find('.is-invalid').removeClass('is-invalid');

                $.post(action, data, function (result) {
                    if (result && result.code == 200) {
                        window.location.reload();
                    } else {
                        window.location.reload(); // Simple fallback
                    }
                }).fail(function (err) {
                    $btn.removeClass('btn-loading');
                    var errors = err.responseJSON;
                    if (errors && errors.errors) {
                        Object.keys(errors.errors).forEach(function (key) {
                            var error = errors.errors[key];
                            var element = $form.find('[name="' + key + '"]');
                            element.addClass('is-invalid');
                            element.parent().append('<div class="invalid-feedback d-block">' + error[0] + '</div>');
                        });
                    }
                });
            });
        })(jQuery);
    </script>
@endpush
