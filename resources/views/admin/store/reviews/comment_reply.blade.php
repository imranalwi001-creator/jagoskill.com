@extends('admin.layouts.app')

@push('styles_top')
    <link rel="stylesheet" href="/assets/vendors/summernote/summernote-bs4.min.css">
@endpush

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ trans('admin/main.reply_comment') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}">{{trans('admin/main.dashboard')}}</a></div>
                <div class="breadcrumb-item"><a href="{{ getAdminPanelUrl() }}/store/reviews">{{ trans('admin/main.reviews') }}</a></div>
                <div class="breadcrumb-item">{{ trans('admin/main.reply_comment') }}</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="card">
                        <div class="card-header flex-column align-items-start">
                            <h4>{{ trans('admin/main.main_comment') }}</h4>
                            <p class="mt-2">{{ nl2br($review->description) }}</p>

                            <hr class="divider my-2 w-100 border border-gray">

                            @if(!empty($review->comments) and $review->comments->count() > 0)
                                <div class="mt-1 w-100">
                                    <h4>{{ trans('admin/main.reply_list') }}</h4>

                                    <div class="mt-4">
                                        <table class="table custom-table font-14">
                                            <tr>
                                                <th>{{ trans('admin/main.user') }}</th>
                                                <th>{{ trans('admin/main.comment') }}</th>
                                                <th>{{ trans('public.date') }}</th>
                                                <th>{{ trans('admin/main.status') }}</th>
                                                <th>{{ trans('admin/main.action') }}</th>
                                            </tr>
                                            @foreach($review->comments as $reply)
                                                <tr>
                                                    <td>{{ $reply->user->id .' - '.$reply->user->full_name }}</td>

                                                    <td>
                                                        <button type="button" class="js-show-description btn btn-outline-primary">{{ trans('admin/main.show') }}</button>
                                                        <input type="hidden" value="{{ nl2br($reply->comment) }}">
                                                    </td>

                                                    <td>{{ dateTimeFormat($reply->created_at, 'Y M j | H:i') }}</td>

                                                    <td>
                                                        <span class="badge-status {{ ($reply->status == 'pending') ? 'text-warning bg-warning-30' : 'text-success bg-success-30' }}">
                                                            {{ ($reply->status == 'pending') ? trans('admin/main.pending') : trans('admin/main.published') }}
                                                        </span>
                                                    </td>

                                                    <td>
                                                        <div class="btn-group dropdown table-actions position-relative">
                                                            <button type="button" class="btn-transparent dropdown-toggle" data-toggle="dropdown">
                                                                <i class="fa fa-ellipsis-v"></i>
                                                            </button>

                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                @can("admin_comments_status")
                                                                    <a href="{{ getAdminPanelUrl("/comments/product_reviews/{$reply->id}/toggle") }}" class="dropdown-item mb-2">
                                                                        @if($reply->status == 'pending')
                                                                            <i class="fa fa-arrow-up mr-2"></i> {{ trans('admin/main.approve') }}
                                                                        @else
                                                                            <i class="fa fa-arrow-down mr-2"></i> {{ trans('admin/main.reject') }}
                                                                        @endif
                                                                    </a>
                                                                @endcan

                                                                @can("admin_comments_edit")
                                                                    <a href="{{ getAdminPanelUrl("/comments/product_reviews/{$reply->id}/edit") }}" class="dropdown-item mb-2">
                                                                        <i class="fa fa-edit mr-2"></i> {{ trans('admin/main.edit') }}
                                                                    </a>
                                                                @endcan

                                                                @can("admin_comments_delete")
                                                                    <a href="{{ getAdminPanelUrl("/comments/product_reviews/{$reply->id}/delete") }}" class="dropdown-item text-danger delete-action" data-confirm-text="{{ trans('public.confirm_delete') }}">
                                                                        <i class="fa fa-trash mr-2"></i> {{ trans('admin/main.delete') }}
                                                                    </a>
                                                                @endcan
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                </div>
                            @endif
                        </div>

                        @can('admin_comments_reply')
                            <div class="card-body ">
                                <form action="{{ getAdminPanelUrl("/comments/product_reviews/{$review->id}/reply") }}" method="post">
                                    {{ csrf_field() }}

                                    <div class="form-group mt-15">
                                        <label class="input-label">{{ trans('admin/main.reply_comment') }}</label>
                                        <textarea id="summernote" name="comment" class="summernote form-control @error('comment') is-invalid @enderror">{!! old('comment') !!}</textarea>
                                        @error('comment')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <button type="submit" class="mt-3 btn btn-primary">{{ trans('admin/main.save_change') }}</button>
                                </form>
                            </div>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="contactMessage" tabindex="-1" aria-labelledby="contactMessageLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="contactMessageLabel">{{ trans('admin/main.comment') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('admin/main.close') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts_bottom')
    <script src="/assets/vendors/summernote/summernote-bs4.min.js"></script>
    <script src="/assets/default/js/admin/comments.min.js"></script>
@endpush
