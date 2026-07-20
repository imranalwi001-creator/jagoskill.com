@extends('admin.layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ $pageTitle }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}">{{trans('admin/main.dashboard')}}</a></div>
                <div class="breadcrumb-item">{{ $pageTitle }}</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-lg-4 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-list"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>{{ trans('update.total_rules') }}</h4>
                            </div>
                            <div class="card-body">
                                {{ $totalRules }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-success">
                            <i class="fas fa-check"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>{{ trans('update.active_rules') }}</h4>
                            </div>
                            <div class="card-body">
                                {{ $activeRules }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-warning">
                            <i class="fas fa-ban"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>{{ trans('update.disabled_rules') }}</h4>
                            </div>
                            <div class="card-body">
                                {{ $disabledRules }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            @can('admin_cashback_rules_create')
                                <a href="{{ getAdminPanelUrl() }}/cashback/rules/new" class="btn btn-success">{{ trans('admin/main.add_new') }}</a>
                            @endcan
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped font-14">
                                    <tr>
                                        <th>{{ trans('admin/main.title') }}</th>
                                        <th class="text-center">{{ trans('update.target_type') }}</th>
                                        <th class="text-center">{{ trans('update.amount') }}</th>
                                        <th class="text-center">{{ trans('admin/main.start_date') }}</th>
                                        <th class="text-center">{{ trans('admin/main.end_date') }}</th>
                                        <th class="text-center">{{ trans('admin/main.status') }}</th>
                                        <th>{{ trans('admin/main.actions') }}</th>
                                    </tr>

                                    @foreach($rules as $rule)
                                        <tr>
                                            <td>
                                                <span class="d-block font-weight-bold">{{ $rule->title }}</span>
                                            </td>
                                            <td class="text-center">{{ trans('update.' . $rule->target_type) }}</td>
                                            <td class="text-center">
                                                @if(!empty($rule->amount))
                                                    {{ $rule->amount_type == 'percent' ? $rule->amount . '%' : handlePrice($rule->amount) }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                {{ !empty($rule->start_date) ? dateTimeFormat($rule->start_date, 'j M Y') : '-' }}
                                            </td>
                                            <td class="text-center">
                                                {{ !empty($rule->end_date) ? dateTimeFormat($rule->end_date, 'j M Y') : '-' }}
                                            </td>
                                            <td class="text-center">
                                                @if($rule->enable)
                                                    <span class="text-success">{{ trans('admin/main.active') }}</span>
                                                @else
                                                    <span class="text-danger">{{ trans('admin/main.inactive') }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @can('admin_cashback_rules_edit')
                                                    <a href="{{ getAdminPanelUrl() }}/cashback/rules/{{ $rule->id }}/edit" class="btn-transparent btn-sm text-primary mr-1" data-toggle="tooltip" data-placement="top" title="{{ trans('admin/main.edit') }}">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                @endcan
                                                @can('admin_cashback_rules_delete')
                                                    @include('admin.includes.delete_button',['url' => getAdminPanelUrl('/cashback/rules/'.$rule->id.'/delete') , 'btnClass' => ''])
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>

                            <div class="card-footer text-center">
                                {{ $rules->appends(request()->input())->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
