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
                                <span class="text-gray-500 mt-8">{{trans('admin/main.total_organizations')}}</span>
                                <div class="d-flex-center size-48 bg-primary-30 rounded-12">
                                    <i class="fa fa-building text-primary font-24"></i>
                                </div>
                            </div>
                            <h5 class="font-24 mt-12 line-height-1 text-black">{{ $totalOrganizations }}</h5>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card-statistic">
                        <div class="card-statistic__mask"></div>
                        <div class="card-statistic__wrap">
                            <div class="d-flex align-items-start justify-content-between">
                                <span class="text-gray-500 mt-8">{{trans('admin/main.verified_organizations')}}</span>
                                <div class="d-flex-center size-48 bg-success-30 rounded-12">
                                    <i class="fa fa-check text-success font-24"></i>
                                </div>
                            </div>
                            <h5 class="font-24 mt-12 line-height-1 text-black">{{ $verifiedOrganizations }}</h5>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card-statistic">
                        <div class="card-statistic__mask"></div>
                        <div class="card-statistic__wrap">
                            <div class="d-flex align-items-start justify-content-between">
                                <span class="text-gray-500 mt-8">{{trans('admin/main.organizations_instructors')}}</span>
                                <div class="d-flex-center size-48 bg-info-30 rounded-12">
                                    <i class="fa fa-chalkboard-teacher text-info font-24"></i>
                                </div>
                            </div>
                            <h5 class="font-24 mt-12 line-height-1 text-black">{{ $totalOrganizationsTeachers }}</h5>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card-statistic">
                        <div class="card-statistic__mask"></div>
                        <div class="card-statistic__wrap">
                            <div class="d-flex align-items-start justify-content-between">
                                <span class="text-gray-500 mt-8">{{trans('admin/main.organizations_students')}}</span>
                                <div class="d-flex-center size-48 bg-warning-30 rounded-12">
                                    <i class="fa fa-graduation-cap text-warning font-24"></i>
                                </div>
                            </div>
                            <h5 class="font-24 mt-12 line-height-1 text-black">{{ $totalOrganizationsStudents }}</h5>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped font-14">
                                    <tr>
                                        <th>{{ trans('admin/main.id') }}</th>
                                        <th class="text-left">{{ trans('admin/main.name') }}</th>
                                        <th class="text-center">{{ trans('admin/main.classes_sales') }}</th>
                                        <th class="text-center">{{ trans('admin/main.meetings_sales') }}</th>
                                        <th class="text-center">{{ trans('admin/main.instructors') }}</th>
                                        <th class="text-center">{{ trans('admin/main.students') }}</th>
                                        <th class="text-center">{{ trans('admin/main.status') }}</th>
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
                                                        <div class="text-primary text-small font-600-bold">{{ $user->mobile }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            
                                            <td class="text-center">
                                                <div class="media-body">
                                                    <div class="mt-0 mb-1 font-weight-bold">{{ $user->classesSalesCount ?? 0 }}</div>
                                                    <div class="text-primary text-small font-600-bold">{{ handlePrice($user->classesSalesSum ?? 0) }}</div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="media-body">
                                                    <div class="mt-0 mb-1 font-weight-bold">{{ $user->meetingsSalesCount ?? 0 }}</div>
                                                    <div class="text-primary text-small font-600-bold">{{ handlePrice($user->meetingsSalesSum ?? 0) }}</div>
                                                </div>
                                            </td>
                                            
                                            <td class="text-center">{{ $user->getOrganizationTeachers()->count() }}</td>
                                            <td class="text-center">{{ $user->getOrganizationStudents()->count() }}</td>
                                            
                                            <td class="text-center">
                                                @if($user->status == 'active')
                                                    <span class="text-success">{{ trans('admin/main.active') }}</span>
                                                @elseif($user->status == 'pending')
                                                    <span class="text-warning">{{ trans('admin/main.pending') }}</span>
                                                @else
                                                    <span class="text-danger">{{ trans('admin/main.inactive') }}</span>
                                                @endif
                                            </td>

                                            <td class="text-right">
                                                @can('admin_users_login')
                                                    <a href="{{ getAdminPanelUrl() }}/users/{{ $user->id }}/impersonate" target="_blank" class="btn-transparent text-primary" data-toggle="tooltip" data-placement="top" title="{{ trans('admin/main.login') }}">
                                                        <i class="fa fa-user-shield"></i>
                                                    </a>
                                                @endcan

                                                @can('admin_users_edit')
                                                    <a href="{{ getAdminPanelUrl() }}/users/{{ $user->id }}/edit" class="btn-transparent text-primary ml-1" data-toggle="tooltip" data-placement="top" title="{{ trans('admin/main.edit') }}">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                @endcan
                                                
                                                @can('admin_users_delete')
                                                    @include('admin.includes.delete_button',[
                                                        'url' => getAdminPanelUrl("/users/{$user->id}/delete"),
                                                        'btnClass' => 'btn-sm btn-transparent text-primary ml-1',
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
                            {{ $users->appends(request()->input())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
