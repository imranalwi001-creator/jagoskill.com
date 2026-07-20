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
                                        <th class="text-center">{{ trans('update.total_points') }}</th>
                                        <th class="text-center">{{ trans('update.spent_points') }}</th>
                                        <th class="text-center">{{ trans('update.available_points') }}</th>
                                        <th>{{ trans('admin/main.actions') }}</th>
                                    </tr>

                                    @foreach($rewards as $reward)
                                        <tr>
                                            <td>
                                                @if(!empty($reward->user))
                                                    <div class="d-flex align-items-center">
                                                        <img src="{{ $reward->user->getAvatar() }}" width="40" alt="{{ $reward->user->full_name }}" class="rounded-circle mr-2">
                                                        <div class="d-flex flex-column">
                                                            <span class="font-weight-bold">{{ $reward->user->full_name }}</span>
                                                            <span class="text-muted font-12">{{ $reward->user->email }}</span>
                                                        </div>
                                                    </div>
                                                @else
                                                    <span class="text-danger">{{ trans('update.user_deleted') }}</span>
                                                @endif
                                            </td>
                                            <td class="text-center text-success">{{ $reward->total_points }}</td>
                                            <td class="text-center text-danger">{{ $reward->spent_points }}</td>
                                            <td class="text-center font-weight-bold">{{ $reward->available_points }}</td>
                                            <td>
                                                @if(!empty($reward->user))
                                                    <a href="{{ getAdminPanelUrl() }}/users/{{ $reward->user->id }}/edit" class="btn-transparent text-primary" data-toggle="tooltip" data-placement="top" title="{{ trans('admin/main.edit') }}">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>

                        <div class="card-footer text-center">
                            {{ $rewards->appends(request()->input())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
