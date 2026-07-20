@extends('admin.layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ $pageTitle }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}">{{trans('admin/main.dashboard')}}</a>
                </div>
                <div class="breadcrumb-item">{{ $pageTitle}}</div>
            </div>
        </div>

        <div class="section-body">

            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            @can('admin_subscribe_create')
                                <a href="{{ getAdminPanelUrl() }}/financial/subscribes/new" class="btn btn-primary">{{ trans('admin/main.add_new') }}</a>
                            @endcan
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped font-14">
                                    <tr>
                                        <th>{{ trans('admin/main.title') }}</th>
                                        <th class="text-center">{{ trans('admin/main.price') }}</th>
                                        <th class="text-center">{{ trans('public.days') }}</th>
                                        <th class="text-center">{{ trans('admin/main.usable_count') }}</th>
                                        <th class="text-center">{{ trans('admin/main.sales') }}</th>
                                        <th class="text-center">{{ trans('admin/main.is_popular') }}</th>
                                        <th class="text-center">{{ trans('admin/main.created_at') }}</th>
                                        <th>{{ trans('admin/main.actions') }}</th>
                                    </tr>

                                    @foreach($subscribes as $subscribe)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ $subscribe->icon }}" width="40" alt="{{ $subscribe->title }}">
                                                    <span class="ml-2 font-weight-500">{{ $subscribe->title }}</span>
                                                </div>
                                            </td>
                                            <td class="text-center">{{ handlePrice($subscribe->price) }}</td>
                                            <td class="text-center">{{ $subscribe->days }}</td>
                                            <td class="text-center">{{ $subscribe->infinite_use ? trans('update.infinite') : $subscribe->usable_count }}</td>
                                            <td class="text-center">{{ $subscribe->sales ? $subscribe->sales->count() : 0 }}</td>
                                            <td class="text-center">
                                                @if($subscribe->is_popular)
                                                    <span class="badge badge-success">{{ trans('admin/main.yes') }}</span>
                                                @else
                                                    <span class="badge badge-dark">{{ trans('admin/main.no') }}</span>
                                                @endif
                                            </td>
                                            <td class="text-center">{{ dateTimeFormat($subscribe->created_at, 'j M Y') }}</td>
                                            <td>
                                                @can('admin_subscribe_edit')
                                                    <a href="{{ getAdminPanelUrl() }}/financial/subscribes/{{ $subscribe->id }}/edit" class="btn-transparent text-primary" data-toggle="tooltip" data-placement="top" title="{{ trans('admin/main.edit') }}">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                @endcan
                                                @can('admin_subscribe_delete')
                                                    @include('admin.includes.delete_button',['url' => getAdminPanelUrl('/financial/subscribes/'.$subscribe->id.'/delete') , 'btnClass' => ''])
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>

                        <div class="card-footer text-center">
                            {{ $subscribes->appends(request()->input())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
