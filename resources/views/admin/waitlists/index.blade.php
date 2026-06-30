@extends('admin.layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ $pageTitle }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}">{{ trans('admin/main.dashboard') }}</a></div>
                <div class="breadcrumb-item">{{ $pageTitle }}</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-header justify-content-between">
                    <div>
                        <h5 class="font-14 mb-0">{{ trans('update.waitlists') }}</h5>
                        <p class="font-12 mt-4 mb-0 text-gray-500">{{ trans('update.manage_all_items_in_a_single_place') }}</p>
                    </div>

                    @can('admin_waitlists_exports')
                        <a href="{{ getAdminPanelUrl('/waitlists/export') }}" class="btn bg-white bg-hover-gray-100 border-gray-400 text-gray-500">
                            <x-iconsax-lin-import-2 class="icons text-gray-500" width="18px" height="18px"/>
                            <span class="ml-4 font-12">{{ trans('admin/main.export_xls') }}</span>
                        </a>
                    @endcan
                </div>

                <div class="card-body">
                    @if(!empty($waitlists) and $waitlists->count())
                        <div class="table-responsive">
                            <table class="table custom-table font-14">
                                <tr>
                                    <th class="text-left">{{ trans('admin/main.course') }}</th>
                                    <th>{{ trans('update.members') }}</th>
                                    <th>{{ trans('update.registered_members') }}</th>
                                    <th>{{ trans('update.last_submission') }}</th>
                                    <th>{{ trans('admin/main.actions') }}</th>
                                </tr>

                                @foreach($waitlists as $waitlist)
                                    <tr class="text-center">
                                        <td class="text-left">
                                            <div class="d-flex align-items-center">
                                                <div class="size-48 rounded-8 bg-gray-100">
                                                    <img src="{{ $waitlist->getImage() }}" class="img-cover rounded-8" alt="{{ $waitlist->title }}">
                                                </div>
                                                <div class="ml-12">
                                                    <a href="{{ $waitlist->getUrl() }}" target="_blank" class="text-dark">{{ $waitlist->title }}</a>
                                                    <span class="d-block mt-4 font-12 text-gray-500">{{ !empty($waitlist->teacher) ? $waitlist->teacher->full_name : '-' }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $waitlist->members ?? 0 }}</td>
                                        <td>{{ $waitlist->registered_members ?? 0 }}</td>
                                        <td>{{ !empty($waitlist->last_submission) ? dateTimeFormat($waitlist->last_submission, 'j M Y H:i') : '-' }}</td>
                                        <td>
                                            <div class="btn-group dropdown table-actions position-relative">
                                                <button type="button" class="btn-transparent dropdown-toggle" data-toggle="dropdown">
                                                    <x-iconsax-lin-more class="icons text-gray-500" width="20px" height="20px"/>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    @can('admin_waitlists_users')
                                                        <a href="{{ getAdminPanelUrl("/waitlists/{$waitlist->id}/users") }}" class="dropdown-item d-flex align-items-center py-3 px-0 gap-4">
                                                            <x-iconsax-lin-eye class="icons text-gray-500" width="18px" height="18px"/>
                                                            <span class="text-gray-500 font-14">{{ trans('update.view_list') }}</span>
                                                        </a>
                                                    @endcan

                                                    @can('admin_waitlists_disable')
                                                        <a href="{{ getAdminPanelUrl("/waitlists/{$waitlist->id}/disable") }}" class="dropdown-item d-flex align-items-center py-3 px-0 gap-4">
                                                            <x-iconsax-lin-slash class="icons text-danger" width="18px" height="18px"/>
                                                            <span class="text-danger font-14">{{ trans('update.disable_waitlist') }}</span>
                                                        </a>
                                                    @endcan
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>

                        <div class="card-footer text-center">
                            {{ $waitlists->appends(request()->input())->links() }}
                        </div>
                    @else
                        @include('admin.includes.no-result',[
                            'file_name' => 'webinar.png',
                            'title' => trans('update.waitlists'),
                            'hint' => trans('update.no_result_default_hint'),
                        ])
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
