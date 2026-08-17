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
                                        <th>{{ trans('admin/main.item') }}</th>
                                        <th class="text-center">{{ trans('update.installment') }}</th>
                                        <th class="text-center">{{ trans('update.upfront') }}</th>
                                        <th class="text-center">{{ trans('admin/main.status') }}</th>
                                        <th class="text-center">{{ trans('admin/main.actions') }}</th>
                                    </tr>

                                    @if(isset($orders) && count($orders) > 0)
                                        @foreach($orders as $order)
                                            @php
                                                $item = $order->getItem();
                                                $itemType = $order->getItemType();
                                                $itemTitle = !empty($item) ? $item->title : trans('update.deleted_item');
                                            @endphp
                                            <tr>
                                                <td>
                                                    @if(!empty($order->user))
                                                        <div class="d-flex align-items-center">
                                                            <figure class="avatar mr-2">
                                                                <img src="{{ $order->user->getAvatar() }}" alt="{{ $order->user->full_name }}">
                                                            </figure>
                                                            <div class="media-body ml-1">
                                                                <div class="mt-0 mb-1 font-weight-bold">{{ $order->user->full_name }}</div>
                                                                <div class="text-primary text-small font-600-bold">{{ $order->user->mobile }}</div>
                                                                <div class="text-primary text-small font-600-bold">{{ $order->user->email }}</div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="d-block font-weight-500">{{ $itemTitle }}</span>
                                                    <span class="d-block text-muted font-12">{{ trans('update.'.$itemType) }}</span>
                                                </td>
                                                <td class="text-center">
                                                    @if(!empty($order->installment))
                                                        <span class="d-block font-weight-bold">{{ $order->installment->title }}</span>
                                                    @endif
                                                    <span class="d-block text-muted font-12">{{ handlePrice($order->getCompletePrice()) }}</span>
                                                </td>
                                                <td class="text-center">
                                                    @if(!empty($order->selectedInstallment))
                                                        {{ handlePrice($order->selectedInstallment->getUpfront($order->getItemPrice())) }}
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if($order->status == 'open')
                                                        <span class="text-warning">{{ trans('admin/main.open') }}</span>
                                                    @elseif($order->status == 'pending_verification')
                                                        <span class="text-primary">{{ trans('update.pending_verification') }}</span>
                                                    @elseif($order->status == 'paying')
                                                        <span class="text-info">{{ trans('update.paying') }}</span>
                                                    @elseif($order->status == 'canceled')
                                                        <span class="text-danger">{{ trans('admin/main.canceled') }}</span>
                                                    @elseif($order->status == 'refunded')
                                                        <span class="text-dark">{{ trans('admin/main.refunded') }}</span>
                                                    @elseif($order->status == 'rejected')
                                                        <span class="text-danger">{{ trans('admin/main.rejected') }}</span>
                                                    @endif
                                                </td>
                                                <td class="text-center mb-2" width="120">
                                                    @can('admin_installments_verification_requests')
                                                        <a href="{{ getAdminPanelUrl() }}/financial/installments/purchases/{{ $order->id }}/details" class="btn-transparent text-primary" data-toggle="tooltip" data-placement="top" title="{{ trans('admin/main.details') }}">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                    @endcan
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </table>
                            </div>
                            
                            @if(isset($orders))
                                <div class="mt-4">
                                    {{ $orders->appends(request()->input())->links() }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
