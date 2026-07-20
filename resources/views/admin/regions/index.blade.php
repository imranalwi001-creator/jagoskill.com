@extends('admin.layouts.app')

@push('styles_top')
    <link rel="stylesheet" href="/assets/default/vendors/sweetalert2/dist/sweetalert2.min.css">
@endpush

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
                            @can('admin_regions_create')
                                <a href="{{ getAdminPanelUrl('/regions/new?type=' . $type) }}" class="btn btn-primary">{{ trans('admin/main.add_new') }}</a>
                            @endcan
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped font-14">
                                    <tr>
                                        <th>{{ trans('admin/main.title') }}</th>
                                        
                                        @if($type !== \App\Models\Region::$country)
                                            <th>{{ trans('update.country') }}</th>
                                        @endif
                                        
                                        @if($type === \App\Models\Region::$city or $type === \App\Models\Region::$district)
                                            <th>{{ trans('update.province') }}</th>
                                        @endif
                                        
                                        @if($type === \App\Models\Region::$district)
                                            <th>{{ trans('update.city') }}</th>
                                        @endif
                                        
                                        <th>{{ trans('update.coordinates') }}</th>
                                        <th>{{ trans('admin/main.actions') }}</th>
                                    </tr>

                                    @foreach($regions as $region)
                                        <tr>
                                            <td>{{ $region->title }}</td>
                                            
                                            @if($type !== \App\Models\Region::$country)
                                                <td>{{ $region->country ? $region->country->title : '-' }}</td>
                                            @endif
                                            
                                            @if($type === \App\Models\Region::$city or $type === \App\Models\Region::$district)
                                                <td>{{ $region->province ? $region->province->title : '-' }}</td>
                                            @endif
                                            
                                            @if($type === \App\Models\Region::$district)
                                                <td>{{ $region->city ? $region->city->title : '-' }}</td>
                                            @endif
                                            
                                            <td>{{ is_array($region->geo_center) ? implode(', ', $region->geo_center) : ($region->geo_center ?? '-') }}</td>
                                            
                                            <td>
                                                @can('admin_regions_edit')
                                                    <a href="{{ getAdminPanelUrl('/regions/' . $region->id . '/edit') }}" class="btn-transparent text-primary mr-1" data-toggle="tooltip" data-placement="top" title="{{ trans('admin/main.edit') }}">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                @endcan
                                                @can('admin_regions_delete')
                                                    @include('admin.includes.delete_button',['url' => getAdminPanelUrl('/regions/'.$region->id.'/delete') , 'btnClass' => ''])
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>

                        <div class="card-footer text-center">
                            {{ $regions->appends(request()->input())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts_bottom')
    <script src="/assets/default/vendors/sweetalert2/dist/sweetalert2.min.js"></script>
    <script>
        var saveSuccessLang = '{{ trans('webinars.success_store') }}';
    </script>
    <script src="/assets/default/js/admin/make_sure_delete.min.js"></script>
@endpush
