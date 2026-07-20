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
                <div class="col-12 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped font-14">
                                    <tr>
                                        <th>{{ trans('admin/main.user') }}</th>
                                        <th class="text-center">{{ trans('admin/main.amount') }}</th>
                                        <th class="text-center">{{ trans('admin/main.type') }}</th>
                                        <th class="text-center">{{ trans('admin/main.date') }}</th>
                                    </tr>

                                    @foreach($transactions as $transaction)
                                        <tr>
                                            <td>
                                                @if(!empty($transaction->user))
                                                    <a href="{{ getAdminPanelUrl() }}/users/{{ $transaction->user_id }}/edit" target="_blank">{{ $transaction->user->full_name }}</a>
                                                @else
                                                    <span class="text-muted">{{ trans('update.guest') }}</span>
                                                @endif
                                            </td>
                                            <td class="text-center text-success">
                                                {{ handlePrice($transaction->amount) }}
                                            </td>
                                            <td class="text-center">
                                                {{ trans('update.' . $transaction->type ?? 'cashback') }}
                                            </td>
                                            <td class="text-center">
                                                {{ dateTimeFormat($transaction->created_at, 'j M Y H:i') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>

                            <div class="card-footer text-center">
                                {{ $transactions->appends(request()->input())->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
