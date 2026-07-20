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
                        <div class="card-header">
                            @can('admin_installments_create')
                                <a href="{{ getAdminPanelUrl() }}/financial/installments/create" class="btn btn-success">{{ trans('admin/main.add_new') }}</a>
                            @endcan
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped font-14">
                                    <tr>
                                        <th>{{ trans('admin/main.title') }}</th>
                                        <th class="text-center">{{ trans('update.upfront') }}</th>
                                        <th class="text-center">{{ trans('update.steps') }}</th>
                                        <th class="text-center">{{ trans('update.capacity') }}</th>
                                        <th class="text-center">{{ trans('update.target_type') }}</th>
                                        <th class="text-center">{{ trans('admin/main.status') }}</th>
                                        <th>{{ trans('admin/main.actions') }}</th>
                                    </tr>

                                    @foreach($installments as $installment)
                                        <tr>
                                            <td>
                                                <span class="d-block font-weight-bold">{{ $installment->title }}</span>
                                                <span class="text-small text-muted">{{ $installment->sales_count ?? 0 }} {{ trans('update.purchases') }}</span>
                                            </td>
                                            <td class="text-center">
                                                @if(!empty($installment->upfront))
                                                    {{ $installment->upfront_type == 'percent' ? $installment->upfront . '%' : handlePrice($installment->upfront) }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="text-center">{{ $installment->steps_count ?? 0 }}</td>
                                            <td class="text-center">{{ !empty($installment->capacity) ? $installment->capacity : trans('update.unlimited') }}</td>
                                            <td class="text-center">{{ trans('update.' . $installment->target_type) }}</td>
                                            <td class="text-center">
                                                @if($installment->enable)
                                                    <span class="text-success">{{ trans('admin/main.active') }}</span>
                                                @else
                                                    <span class="text-danger">{{ trans('admin/main.inactive') }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @can('admin_installments_edit')
                                                    <a href="{{ getAdminPanelUrl() }}/financial/installments/{{ $installment->id }}/edit" class="btn-transparent btn-sm text-primary mr-1" data-toggle="tooltip" data-placement="top" title="{{ trans('admin/main.edit') }}">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                @endcan
                                                @can('admin_installments_delete')
                                                    @include('admin.includes.delete_button',['url' => getAdminPanelUrl('/financial/installments/'.$installment->id.'/delete') , 'btnClass' => ''])
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>

                            <div class="card-footer text-center">
                                {{ $installments->appends(request()->input())->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
