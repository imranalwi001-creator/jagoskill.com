@extends('admin.layouts.app')

@push('libraries_top')

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
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card-statistic">
                        <div class="card-statistic__mask"></div>
                        <div class="card-statistic__wrap">
                            <div class="d-flex align-items-start justify-content-between">
                                <span class="text-gray-500 mt-8">{{trans('update.total_packages')}}</span>
                                <div class="d-flex-center size-48 bg-primary-30 rounded-12">
                                    <i class="fa fa-list-alt text-primary font-24"></i>
                                </div>
                            </div>
                            <h5 class="font-24 mt-12 line-height-1 text-black">{{ $totalPackages ?? 0 }}</h5>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card-statistic">
                        <div class="card-statistic__mask"></div>
                        <div class="card-statistic__wrap">
                            <div class="d-flex align-items-start justify-content-between">
                                <span class="text-gray-500 mt-8">{{trans('update.instructors_packages')}}</span>
                                <div class="d-flex-center size-48 bg-info-30 rounded-12">
                                    <i class="fa fa-chalkboard-teacher text-info font-24"></i>
                                </div>
                            </div>
                            <h5 class="font-24 mt-12 line-height-1 text-black">{{ $totalInstructorsPackages ?? 0 }}</h5>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card-statistic">
                        <div class="card-statistic__mask"></div>
                        <div class="card-statistic__wrap">
                            <div class="d-flex align-items-start justify-content-between">
                                <span class="text-gray-500 mt-8">{{trans('update.organizations_packages')}}</span>
                                <div class="d-flex-center size-48 bg-warning-30 rounded-12">
                                    <i class="fa fa-building text-warning font-24"></i>
                                </div>
                            </div>
                            <h5 class="font-24 mt-12 line-height-1 text-black">{{ $totalOrganizationPackages ?? 0 }}</h5>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card-statistic">
                        <div class="card-statistic__mask"></div>
                        <div class="card-statistic__wrap">
                            <div class="d-flex align-items-start justify-content-between">
                                <span class="text-gray-500 mt-8">{{trans('update.total_sold_packages')}}</span>
                                <div class="d-flex-center size-48 bg-success-30 rounded-12">
                                    <i class="fa fa-shopping-cart text-success font-24"></i>
                                </div>
                            </div>
                            <h5 class="font-24 mt-12 line-height-1 text-black">{{ $totalSoldPackages ?? 0 }}</h5>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            @can('admin_meeting_packages_create')
                                <a href="{{ getAdminPanelUrl() }}/meeting-packages/create" class="btn btn-primary">{{ trans('admin/main.create') }}</a>
                            @endcan
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped font-14">
                                    <tr>
                                        <th class="text-left">{{ trans('admin/main.title') }}</th>
                                        <th class="text-left">{{ trans('admin/main.creator') }}</th>
                                        <th class="text-center">{{ trans('admin/main.sales') }}</th>
                                        <th class="text-center">{{ trans('admin/main.status') }}</th>
                                        <th class="text-center">{{ trans('admin/main.created_at') }}</th>
                                        <th class="text-right">{{ trans('admin/main.actions') }}</th>
                                    </tr>
                                    
                                    @foreach($meetingPackages as $package)
                                        <tr>
                                            <td class="text-left">
                                                <span>{{ $package->title }}</span>
                                            </td>
                                            <td class="text-left">
                                                <span>{{ $package->creator->full_name ?? '' }}</span>
                                            </td>
                                            <td class="text-center">{{ $package->sales_count ?? 0 }}</td>
                                            
                                            <td class="text-center">
                                                @if($package->enable)
                                                    <span class="text-success">{{ trans('admin/main.active') }}</span>
                                                @else
                                                    <span class="text-danger">{{ trans('admin/main.inactive') }}</span>
                                                @endif
                                            </td>
                                            <td class="text-center">{{ dateTimeFormat($package->created_at, 'j M Y') }}</td>
                                            
                                            <td class="text-right">
                                                @can('admin_meeting_packages_create')
                                                    <a href="{{ getAdminPanelUrl() }}/meeting-packages/{{ $package->id }}/edit" class="btn-transparent text-primary" data-toggle="tooltip" data-placement="top" title="{{ trans('admin/main.edit') }}">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    
                                                    @include('admin.includes.delete_button',[
                                                        'url' => getAdminPanelUrl("/meeting-packages/{$package->id}/delete"),
                                                        'btnClass' => 'btn-sm btn-transparent text-primary mt-1',
                                                        'btnIcon' => 'trash',
                                                        'iconType' => 'lin',
                                                        'iconClass' => 'text-danger',
                                                    ])
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>

                        <div class="card-footer text-center">
                            {{ $meetingPackages->appends(request()->input())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection