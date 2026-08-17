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

            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="card">
                        
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped font-14">
                                    <tr>
                                        <th>{{ trans('admin/main.user') }}</th>
                                        <th class="text-center">{{ trans('update.total_amount') }}</th>
                                        <th class="text-center">{{ trans('update.unpaid_installments') }}</th>
                                        <th class="text-center">{{ trans('update.unpaid_amount') }}</th>
                                        <th class="text-center">{{ trans('update.overdue') }}</th>
                                        <th class="text-center">{{ trans('admin/main.actions') }}</th>
                                    </tr>

                                    @if(isset($users) && count($users) > 0)
                                        @foreach($users as $user)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <figure class="avatar mr-2">
                                                            <img src="{{ $user->getAvatar() }}" alt="{{ $user->full_name }}">
                                                        </figure>
                                                        <div class="media-body ml-1">
                                                            <div class="mt-0 mb-1 font-weight-bold">{{ $user->full_name }}</div>
                                                            <div class="text-primary text-small font-600-bold">{{ $user->mobile }}</div>
                                                            <div class="text-primary text-small font-600-bold">{{ $user->email }}</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                
                                                <td class="text-center">
                                                    {{ handlePrice($user->totalAmount) }}
                                                </td>
                                                <td class="text-center">
                                                    {{ $user->unpaidStepsCount }}
                                                </td>
                                                <td class="text-center">
                                                    {{ handlePrice($user->unpaidStepsAmount) }}
                                                </td>
                                                <td class="text-center">
                                                    @if($user->overdueCount > 0)
                                                        <span class="d-block text-danger font-weight-bold">{{ $user->overdueCount }} ({{ handlePrice($user->overdueAmount) }})</span>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td class="text-center mb-2" width="120">
                                                    @can('admin_users_edit')
                                                        <a href="{{ getAdminPanelUrl() }}/users/{{ $user->id }}/edit" class="btn-transparent text-primary" data-toggle="tooltip" data-placement="top" title="{{ trans('admin/main.edit') }}">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                    @endcan
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </table>
                            </div>
                            
                            @if(isset($users))
                                <div class="mt-4">
                                    {{ $users->appends(request()->input())->links() }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
