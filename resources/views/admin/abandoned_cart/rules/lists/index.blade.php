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
                            <i class="fas fa-list"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>{{ trans('admin/main.total') }}</h4>
                            </div>
                            <div class="card-body">
                                {{ $totalRules }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-success">
                            <i class="fas fa-check"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>{{ trans('admin/main.active') }}</h4>
                            </div>
                            <div class="card-body">
                                {{ $activeRules }}
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
                                <h4>{{ trans('update.total_activities') ?? 'Total Activities' }}</h4>
                            </div>
                            <div class="card-body">
                                {{ $totalActivities }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-warning">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>{{ trans('admin/main.total_sales') }}</h4>
                            </div>
                            <div class="card-body">
                                {{ handlePrice($totalSales) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            @can('admin_abandoned_cart_rules')
                                <a href="{{ getAdminPanelUrl() }}/abandoned-cart/rules/create" class="btn btn-primary">{{ trans('admin/main.add_new') }}</a>
                            @endcan
                        </div>
                        
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped font-14">
                                    <tr>
                                        <th>{{ trans('admin/main.title') }}</th>
                                        <th class="text-center">{{ trans('admin/main.target') }}</th>
                                        <th class="text-center">{{ trans('update.action') ?? 'Action' }}</th>
                                        <th class="text-center">{{ trans('admin/main.status') }}</th>
                                        <th class="text-center">{{ trans('admin/main.created_at') }}</th>
                                        <th>{{ trans('admin/main.actions') }}</th>
                                    </tr>
                                    
                                    @if($rules)
                                        @foreach($rules as $rule)
                                            <tr>
                                                <td>{{ $rule->title }}</td>
                                                
                                                <td class="text-center">
                                                    {{ trans('update.target_type_' . $rule->target_type) ?? trans('update.' . $rule->target_type) ?? ucfirst(str_replace('_', ' ', $rule->target_type)) }}
                                                </td>
                                                
                                                <td class="text-center">
                                                    {{ trans('update.action_' . $rule->action) ?? trans('update.' . $rule->action) ?? ucfirst(str_replace('_', ' ', $rule->action)) }}
                                                </td>
                                                
                                                <td class="text-center">
                                                    @if($rule->enable)
                                                        <span class="badge badge-success">{{ trans('admin/main.active') }}</span>
                                                    @else
                                                        <span class="badge badge-danger">{{ trans('admin/main.inactive') }}</span>
                                                    @endif
                                                </td>
                                                
                                                <td class="text-center">{{ dateTimeFormat($rule->created_at, 'j M Y') }}</td>
                                                
                                                <td class="text-center mb-2" width="120">
                                                    @can('admin_abandoned_cart_rules')
                                                        <a href="{{ getAdminPanelUrl() }}/abandoned-cart/rules/{{ $rule->id }}/edit" class="btn-transparent text-primary" data-toggle="tooltip" data-placement="top" title="{{ trans('admin/main.edit') }}">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                        
                                                        @include('admin.includes.delete_button', [
                                                            'url' => getAdminPanelUrl("/abandoned-cart/rules/{$rule->id}/delete"),
                                                            'btnClass' => 'ml-2',
                                                            'tooltip' => trans('admin/main.delete'),
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
                                {{ $rules->appends(request()->input())->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
