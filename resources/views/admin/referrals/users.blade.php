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
                                        <th class="text-center">{{ trans('admin/main.role') }}</th>
                                        <th class="text-center">{{ trans('update.affiliate_code') }}</th>
                                    </tr>

                                    @foreach($affiliates as $affiliate)
                                        <tr>
                                            <td>
                                                @if(!empty($affiliate->affiliateUser))
                                                    <a href="{{ getAdminPanelUrl() }}/users/{{ $affiliate->affiliateUser->id }}/edit" target="_blank">{{ $affiliate->affiliateUser->full_name }}</a>
                                                @else
                                                    <span class="text-muted">{{ trans('update.guest') }}</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if(!empty($affiliate->affiliateUser) && !empty($affiliate->affiliateUser->role_name))
                                                    {{ $affiliate->affiliateUser->role_name }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if(!empty($affiliate->affiliateUser) && !empty($affiliate->affiliateUser->affiliateCode))
                                                    {{ $affiliate->affiliateUser->affiliateCode->code }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>

                            <div class="card-footer text-center">
                                {{ $affiliates->appends(request()->input())->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
