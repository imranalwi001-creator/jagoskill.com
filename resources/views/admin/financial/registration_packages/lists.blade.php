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
                <div class="col-12 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            @can('admin_registration_packages_create')
                                <a href="{{ getAdminPanelUrl() }}/financial/registration-packages/new" class="btn btn-primary">{{ trans('admin/main.add_new') }}</a>
                            @endcan
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped font-14">
                                    <tr>
                                        <th>{{ trans('admin/main.title') }}</th>
                                        <th class="text-center">{{ trans('admin/main.role') }}</th>
                                        <th class="text-center">{{ trans('admin/main.price') }}</th>
                                        <th class="text-center">{{ trans('public.days') }}</th>
                                        <th class="text-center">{{ trans('admin/main.status') }}</th>
                                        <th class="text-center">{{ trans('admin/main.created_at') }}</th>
                                        <th>{{ trans('admin/main.actions') }}</th>
                                    </tr>

                                    @if(!empty($packages))
                                        @foreach($packages as $package)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="{{ $package->icon }}" width="40" alt="{{ $package->title }}">
                                                        <span class="ml-2 font-weight-500">{{ $package->title }}</span>
                                                    </div>
                                                </td>
                                                <td class="text-center">{{ trans('update.' . $package->role) }}</td>
                                                <td class="text-center">{{ handlePrice($package->price) }}</td>
                                                <td class="text-center">{{ $package->days }}</td>
                                                <td class="text-center">
                                                    @if($package->status === 'active')
                                                        <span class="badge badge-success">{{ trans('admin/main.active') }}</span>
                                                    @else
                                                        <span class="badge badge-dark">{{ trans('admin/main.inactive') }}</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">{{ dateTimeFormat($package->created_at, 'j M Y') }}</td>
                                                <td>
                                                    @can('admin_registration_packages_edit')
                                                        <a href="{{ getAdminPanelUrl() }}/financial/registration-packages/{{ $package->id }}/edit" class="btn-transparent text-primary" data-toggle="tooltip" data-placement="top" title="{{ trans('admin/main.edit') }}">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                    @endcan
                                                    @can('admin_registration_packages_delete')
                                                        @include('admin.includes.delete_button',['url' => getAdminPanelUrl('/financial/registration-packages/'.$package->id.'/delete') , 'btnClass' => ''])
                                                    @endcan
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </table>
                            </div>
                        </div>

                        <div class="card-footer text-center">
                            @if(!empty($packages) and method_exists($packages, 'links'))
                                {{ $packages->appends(request()->input())->links() }}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
