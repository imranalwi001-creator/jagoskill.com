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
                <div class="breadcrumb-item">{{ $pageTitle}}</div>
            </div>
        </div>

        <div class="section-body">

            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="card">
                        <div class="card-header justify-content-between">
                            <div>
                            </div>
                            <div class="d-flex align-items-center gap-12">
                                @can('admin_purchase_notifications_create')
                                    <a href="{{ getAdminPanelUrl("/purchase_notifications/create") }}" class="btn btn-primary">
                                        <x-iconsax-lin-add class="icons text-white" width="18px" height="18px"/>
                                        <span class="ml-4 font-12">{{ trans('admin/main.add_new') }}</span>
                                    </a>
                                @endcan
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table custom-table font-14 ">
                                    <tr>
                                        <th>{{trans('admin/main.title')}}</th>
                                        <th class="text-left">{{trans('update.popup_title')}}</th>
                                        <th>{{trans('update.display_type')}}</th>
                                        <th>{{trans('admin/main.status')}}</th>
                                        <th>{{trans('admin/main.created_at')}}</th>
                                        <th width="120">{{trans('admin/main.actions')}}</th>
                                    </tr>

                                    @foreach($notifications as $notification)
                                        <tr class="text-center">
                                            <td class="text-left">{{ $notification->title }}</td>
                                            <td class="text-left">{{ $notification->popup_title }}</td>
                                            
                                            <td>
                                                {{ trans('update.'.$notification->display_type) }}
                                            </td>

                                            <td>
                                                @if($notification->enable)
                                                    <div class="badge-status text-success bg-success-30">{{ trans('admin/main.active') }}</div>
                                                @else
                                                    <div class="badge-status text-danger bg-danger-30">{{ trans('admin/main.inactive') }}</div>
                                                @endif
                                            </td>

                                            <td>{{ dateTimeFormat($notification->created_at, 'Y M j | H:i') }}</td>

                                            <td>
                                                <div class="btn-group dropdown table-actions position-relative">
                                                    <button type="button" class="btn-transparent dropdown-toggle" data-toggle="dropdown">
                                                        <x-iconsax-lin-more class="icons text-gray-500" width="20px" height="20px"/>
                                                    </button>

                                                    <div class="dropdown-menu dropdown-menu-right">

                                                        @can('admin_purchase_notifications_edit')
                                                            <a href="{{ getAdminPanelUrl() }}/purchase_notifications/{{ $notification->id }}/edit" class="dropdown-item d-flex align-items-center mb-3 py-3 px-0 gap-4">
                                                                <x-iconsax-lin-edit-2 class="icons text-gray-500 mr-2" width="18px" height="18px"/>
                                                                <span class="text-gray-500 font-14">{{ trans('admin/main.edit') }}</span>
                                                            </a>
                                                        @endcan

                                                        @can('admin_purchase_notifications_delete')

                                                            @include('admin.includes.delete_button',[
                                                           'url' => getAdminPanelUrl().'/purchase_notifications/'.$notification->id.'/delete',
                                                           'btnClass' => 'dropdown-item text-danger mb-0 py-3 px-0 font-14',
                                                           'btnText' => trans("admin/main.delete"),
                                                           'btnIcon' => 'trash',
                                                           'iconType' => 'lin',
                                                           'iconClass' => 'text-danger mr-2',
                                                        ])
                                                        @endcan
                                                    </div>
                                                </div>
                                            </td>


                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>

                        <div class="card-footer text-center">
                            {{ $notifications->appends(request()->input())->links() }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts_bottom')

@endpush
