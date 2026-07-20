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
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped font-14">
                                    <tr>
                                        <th>{{ trans('admin/main.user') }}</th>
                                        <th class="text-center">{{ trans('update.gift_sender') }}</th>
                                        <th class="text-center">{{ trans('admin/main.amount') }}</th>
                                        <th class="text-center">{{ trans('update.gift_status') }}</th>
                                        <th class="text-center">{{ trans('admin/main.created_at') }}</th>
                                        <th>{{ trans('admin/main.actions') }}</th>
                                    </tr>

                                    @if(!empty($gifts))
                                        @foreach($gifts as $gift)
                                            <tr>
                                                <td>
                                                    @if(!empty($gift->user))
                                                        <div class="d-flex align-items-center">
                                                            <img src="{{ $gift->user->getAvatar() }}" width="40" alt="{{ $gift->user->full_name }}" class="rounded-circle mr-2">
                                                            <div class="d-flex flex-column">
                                                                <span class="font-weight-bold">{{ $gift->user->full_name }}</span>
                                                                <span class="text-muted font-12">{{ $gift->user->email }}</span>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <span class="text-danger">{{ trans('update.user_deleted') }}</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    {{ $gift->name }} <br>
                                                    <span class="text-muted font-12">{{ $gift->email }}</span>
                                                </td>
                                                <td class="text-center">{{ !empty($gift->sale) ? handlePrice($gift->sale->total_amount) : '-' }}</td>
                                                <td class="text-center">
                                                    @if($gift->status === 'active')
                                                        <span class="text-success">{{ trans('admin/main.active') }}</span>
                                                    @elseif($gift->status === 'cancel')
                                                        <span class="text-danger">{{ trans('admin/main.canceled') }}</span>
                                                    @else
                                                        <span class="text-warning">{{ trans('admin/main.pending') }}</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">{{ dateTimeFormat($gift->created_at, 'j M Y H:i') }}</td>
                                                <td>
                                                    @if($gift->status === 'pending')
                                                        @can('admin_gift_send_reminder')
                                                            <a href="{{ getAdminPanelUrl() }}/gifts/{{ $gift->id }}/send_reminder" class="btn-transparent text-primary" data-toggle="tooltip" data-placement="top" title="{{ trans('update.send_reminder') }}">
                                                                <i class="fa fa-bell"></i>
                                                            </a>
                                                        @endcan
                                                    @endif
                                                    
                                                    @if($gift->status !== 'cancel')
                                                        @can('admin_gift_cancel')
                                                            @include('admin.includes.delete_button',['url' => getAdminPanelUrl('/gifts/'.$gift->id.'/cancel') , 'btnClass' => 'mt-1', 'tooltip' => trans('admin/main.cancel')])
                                                        @endcan
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </table>
                            </div>
                        </div>

                        <div class="card-footer text-center">
                            @if(!empty($gifts) and method_exists($gifts, 'links'))
                                {{ $gifts->appends(request()->input())->links() }}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
