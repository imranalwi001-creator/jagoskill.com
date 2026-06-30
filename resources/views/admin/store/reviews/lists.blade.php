@extends('admin.layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ trans('update.admin_store_reviews_list_title') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}">{{trans('admin/main.dashboard')}}</a></div>
                <div class="breadcrumb-item">{{ trans('update.admin_store_reviews_list_title') }}</div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>{{trans('admin/main.total_reviews')}}</h4>
                        </div>
                        <div class="card-body">
                            {{ $totalReviews }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-success">
                        <i class="fas fa-eye"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>{{trans('admin/main.published_reviews')}}</h4>
                        </div>
                        <div class="card-body">
                            {{ $publishedReviews }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-warning">
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>{{trans('admin/main.rates_average')}}</h4>
                        </div>
                        <div class="card-body">
                            {{ $ratesAverage }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-danger">
                        <i class="fas fa-times"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>{{trans('update.products_without_review')}}</h4>
                        </div>
                        <div class="card-body">
                            {{ $productsWithoutReview }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="section-body">
            <section class="card">
                <div class="card-body">
                    <form method="get" class="mb-0">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="input-label">{{ trans('admin/main.search') }}</label>
                                    <input name="item_title" type="text" class="form-control" value="{{ request()->get('item_title') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="input-label">{{ trans('admin/main.start_date') }}</label>
                                    <div class="input-group">
                                        <input type="date" id="from" class="text-center form-control" name="from" value="{{ request()->get('from') }}" placeholder="Start Date">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="input-label">{{ trans('admin/main.end_date') }}</label>
                                    <div class="input-group">
                                        <input type="date" id="to" class="text-center form-control" name="to" value="{{ request()->get('to') }}" placeholder="End Date">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="input-label">{{ trans('admin/main.status') }}</label>
                                    <select name="status" class="form-control">
                                        <option value="">{{ trans('admin/main.all_status') }}</option>
                                        <option value="active" @if(request()->get('status') == 'active') selected @endif>{{ trans('admin/main.published') }}</option>
                                        <option value="pending" @if(request()->get('status') == 'pending') selected @endif>{{ trans('admin/main.pending') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mt-1">
                                    <label class="input-label mb-4"> </label>
                                    <input type="submit" class="text-center btn btn-primary w-100" value="{{ trans('admin/main.show_results') }}">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </section>

            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="card">
                        <div class="card-header justify-content-between">
                            <div>
                                <h5 class="font-14 mb-0">{{ trans('update.admin_store_reviews_list_title') }}</h5>
                                <p class="font-12 mt-4 mb-0 text-gray-500">{{ trans('update.manage_all_items_in_a_single_place') }}</p>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table custom-table font-14">
                                    <tr>
                                        <th class="text-left">{{ trans('admin/main.product') }}</th>
                                        <th class="text-left">{{ trans('admin/main.user') }}</th>
                                        <th class="text-center">{{ trans('admin/main.rate') }}</th>
                                        <th class="text-center">{{ trans('admin/main.status') }}</th>
                                        <th class="text-center">{{ trans('admin/main.date') }}</th>
                                        <th>{{ trans('admin/main.action') }}</th>
                                    </tr>
                                    @foreach($reviews as $review)
                                        <tr>
                                            <td class="text-left">
                                                @if(!empty($review->product))
                                                    <a href="{{ $review->product->getUrl() }}" target="_blank">{{ $review->product->title }}</a>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="text-left">
                                                @if(!empty($review->creator))
                                                    <a href="{{ $review->creator->getProfileUrl() }}" target="_blank">{{ $review->creator->full_name }}</a>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                {{ $review->rates }}
                                            </td>
                                            <td class="text-center">
                                                @if($review->status == 'active')
                                                    <span class="text-success">{{ trans('admin/main.published') }}</span>
                                                @else
                                                    <span class="text-warning">{{ trans('admin/main.pending') }}</span>
                                                @endif
                                            </td>
                                            <td class="text-center">{{ dateTimeFormat($review->created_at, 'j M Y H:i') }}</td>
                                            <td>
                                                <div class="btn-group dropdown table-actions position-relative">
                                                    <button type="button" class="btn-transparent dropdown-toggle" data-toggle="dropdown">
                                                        <i class="fa fa-ellipsis-v"></i>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        @if($review->status != 'active')
                                                            <a href="{{ getAdminPanelUrl() }}/store/reviews/{{ $review->id }}/toggleStatus" class="dropdown-item">{{ trans('admin/main.publish') }}</a>
                                                        @endif
                                                        <a href="{{ getAdminPanelUrl() }}/store/reviews/{{ $review->id }}/reply" class="dropdown-item">{{ trans('admin/main.reply') }}</a>
                                                        <a href="{{ getAdminPanelUrl() }}/store/reviews/{{ $review->id }}/delete" class="dropdown-item text-danger delete-action" data-confirm-text="{{ trans('public.confirm_delete') }}">{{ trans('admin/main.delete') }}</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>

                        <div class="card-footer text-center">
                            {{ $reviews->appends(request()->input())->links('vendor.pagination.bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
