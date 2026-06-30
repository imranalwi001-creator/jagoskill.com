@extends('admin.layouts.app')

@push('libraries_top')
@endpush

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ trans('admin/main.categories') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}">{{ trans('admin/main.dashboard') }}</a></div>
                <div class="breadcrumb-item">{{ trans('categories.categories') }}</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="card">
                        <div class="card-header justify-content-between">
                            <div>
                                <h5 class="font-14 mb-0">{{ $pageTitle }}</h5>
                                <p class="font-12 mt-4 mb-0 text-gray-500">{{ trans('update.manage_all_items_in_a_single_place') }}</p>
                            </div>
                            <div class="d-flex align-items-center gap-12">
                                <a href="{{ getAdminPanelUrl() }}/store/categories/create" class="btn btn-primary">
                                    <i class="fa fa-plus"></i>
                                    <span class="ml-4">{{ trans('admin/main.new') }} {{ trans('admin/main.category') }}</span>
                                </a>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table custom-table font-14">
                                    <tr>
                                        <th>{{ trans('admin/main.icon') }}</th>
                                        <th class="text-left">{{ trans('update.order') }}</th>
                                        <th class="text-left">{{ trans('admin/main.title') }}</th>
                                        <th>{{ trans('admin/main.sub_category') }}</th>
                                        <th>{{ trans('update.products') }}</th>
                                        <th>{{ trans('admin/main.action') }}</th>
                                    </tr>
                                    @foreach($categories as $category)
                                        <tr>
                                            <td>
                                                @if(!empty($category->icon))
                                                    <img src="{{ $category->icon }}" width="30" alt="">
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="text-left">{{ $category->order }}</td>
                                            <td class="text-left">{{ $category->title }}</td>
                                            <td>{{ $category->subCategories->count() }}</td>
                                            <td>{{ $category->products()->count() }}</td>
                                            <td>
                                                <div class="btn-group dropdown table-actions position-relative">
                                                    <button type="button" class="btn-transparent dropdown-toggle" data-toggle="dropdown">
                                                        <i class="fa fa-ellipsis-v"></i>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a href="{{ getAdminPanelUrl() }}/store/categories/{{ $category->id }}/edit" class="dropdown-item">{{ trans('admin/main.edit') }}</a>
                                                        <a href="{{ getAdminPanelUrl() }}/store/categories/{{ $category->id }}/delete" class="dropdown-item text-danger delete-action" data-confirm-text="{{ trans('public.confirm_delete') }}">{{ trans('admin/main.delete') }}</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>

                        <div class="card-footer text-center">
                            {{ $categories->appends(request()->input())->links('vendor.pagination.bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts_bottom')
@endpush
