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
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>{{ trans('admin/main.users') }}</h4>
                            </div>
                            <div class="card-body">
                                {{ $totalUsers }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-success">
                            <i class="fas fa-money-bill"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>{{ trans('admin/main.total_amount') ?? 'Total Amount' }}</h4>
                            </div>
                            <div class="card-body">
                                {{ handlePrice($totalAmount) }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-warning">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>{{ trans('update.total_items') ?? 'Total Items' }}</h4>
                            </div>
                            <div class="card-body">
                                {{ $totalItems }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-info">
                            <i class="fas fa-bell"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>{{ trans('update.sent_reminders') ?? 'Sent Reminders' }}</h4>
                            </div>
                            <div class="card-body">
                                {{ $totalSentReminders }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <section class="card">
                <div class="card-body">
                    <form method="get" class="mb-0">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="input-label">{{ trans('admin/main.search') }}</label>
                                    <input type="text" class="form-control" name="search" value="{{ request()->get('search') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="input-label">{{ trans('admin/main.role') }}</label>
                                    <select name="role" class="form-control">
                                        <option value="">{{ trans('admin/main.all') }}</option>
                                        <option value="user" {{ (request()->get('role') == 'user') ? 'selected' : '' }}>{{ trans('admin/main.user') }}</option>
                                        <option value="instructor" {{ (request()->get('role') == 'instructor') ? 'selected' : '' }}>{{ trans('admin/main.instructor') }}</option>
                                        <option value="organization" {{ (request()->get('role') == 'organization') ? 'selected' : '' }}>{{ trans('admin/main.organization') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="input-label">{{ trans('admin/main.sort') }}</label>
                                    <select name="sort" class="form-control">
                                        <option value="">{{ trans('admin/main.all') }}</option>
                                        <option value="items_asc" {{ (request()->get('sort') == 'items_asc') ? 'selected' : '' }}>{{ trans('update.items_asc') ?? 'Items (Ascending)' }}</option>
                                        <option value="items_desc" {{ (request()->get('sort') == 'items_desc') ? 'selected' : '' }}>{{ trans('update.items_desc') ?? 'Items (Descending)' }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 text-right">
                                <button type="submit" class="btn btn-primary">{{ trans('admin/main.show_results') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </section>

            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped font-14">
                                    <tr>
                                        <th>{{ trans('admin/main.user') }}</th>
                                        <th class="text-center">{{ trans('update.items') ?? 'Items' }}</th>
                                        <th class="text-center">{{ trans('admin/main.amount') }}</th>
                                        <th class="text-center">{{ trans('update.reminders') ?? 'Reminders' }}</th>
                                        <th class="text-center">{{ trans('update.coupons') ?? 'Coupons' }}</th>
                                        <th>{{ trans('admin/main.actions') }}</th>
                                    </tr>
                                    
                                    @if($carts)
                                        @foreach($carts as $cart)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <figure class="avatar mr-2">
                                                            <img src="{{ $cart->user->getAvatar() }}" alt="{{ $cart->user->full_name }}">
                                                        </figure>
                                                        <div class="media-body ml-1">
                                                            <div class="mt-0 mb-1 font-weight-bold">{{ $cart->user->full_name }}</div>
                                                            <div class="text-primary text-small font-600-bold">{{ $cart->user->mobile }}</div>
                                                            <div class="text-primary text-small font-600-bold">{{ $cart->user->email }}</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-center">{{ $cart->total_items }}</td>
                                                <td class="text-center">{{ handlePrice($cart->total_amount) }}</td>
                                                <td class="text-center">{{ $cart->send_reminders }}</td>
                                                <td class="text-center">{{ $cart->send_coupons }}</td>
                                                <td class="text-center mb-2" width="120">
                                                    @can('admin_abandoned_cart_users')
                                                        <a href="{{ getAdminPanelUrl() }}/abandoned-cart/users-carts/{{ $cart->creator_id }}/send-reminder" class="btn-transparent text-primary" data-toggle="tooltip" data-placement="top" title="{{ trans('update.send_reminder') ?? 'Send Reminder' }}">
                                                            <i class="fa fa-bell"></i>
                                                        </a>
                                                        
                                                        <a href="{{ getAdminPanelUrl() }}/abandoned-cart/users-carts/{{ $cart->creator_id }}/view-items" class="btn-transparent text-primary ml-2" data-toggle="tooltip" data-placement="top" title="{{ trans('update.view_items') ?? 'View Items' }}">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                        
                                                        @include('admin.includes.delete_button', [
                                                            'url' => getAdminPanelUrl("/abandoned-cart/users-carts/{$cart->creator_id}/empty"),
                                                            'btnClass' => 'ml-2',
                                                            'tooltip' => trans('update.empty_cart') ?? 'Empty Cart',
                                                            'btnIcon' => 'fa-trash'
                                                        ])
                                                    @endcan
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </table>
                            </div>
                            
                            <div class="mt-4">
                                {{ $carts->appends(request()->input())->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
