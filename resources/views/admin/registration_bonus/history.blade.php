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
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>{{ trans('update.achieved_users') }}</h4>
                            </div>
                            <div class="card-body">
                                {{ $achievedUsers ?? 0 }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-success">
                            <i class="fas fa-unlock"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>{{ trans('update.unlocked_bonus_users') }}</h4>
                            </div>
                            <div class="card-body">
                                {{ $unlockedBonusUsers ?? 0 }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-warning">
                            <i class="fas fa-wallet"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>{{ trans('update.total_bonus') }}</h4>
                            </div>
                            <div class="card-body">
                                {{ handlePrice($totalBonus ?? 0) }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-info">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>{{ trans('update.unlocked_bonus') }}</h4>
                            </div>
                            <div class="card-body">
                                {{ handlePrice($unlockedBonus ?? 0) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped font-14">
                                    <tr>
                                        <th>{{ trans('admin/main.user') }}</th>
                                        <th class="text-center">{{ trans('admin/main.role') }}</th>
                                        <th class="text-center">{{ trans('update.bonus') }}</th>
                                        <th class="text-center">{{ trans('admin/main.status') }}</th>
                                        <th class="text-center">{{ trans('admin/main.created_at') }}</th>
                                    </tr>

                                    @if(!empty($users))
                                        @foreach($users as $user)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="{{ $user->getAvatar() }}" width="40" alt="{{ $user->full_name }}" class="rounded-circle mr-2">
                                                        <div class="d-flex flex-column">
                                                            <span class="font-weight-bold">{{ $user->full_name }}</span>
                                                            <span class="text-muted font-12">{{ $user->email }}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-center">{{ $user->role->caption }}</td>
                                                <td class="text-center">
                                                    @php
                                                        $bonusAmount = 0;
                                                        if (!empty($registrationBonusSettings) && !empty($registrationBonusSettings['role_id']) && $registrationBonusSettings['role_id'] == $user->role_id) {
                                                            $bonusAmount = $registrationBonusSettings['bonus_amount'] ?? 0;
                                                        }
                                                    @endphp
                                                    {{ handlePrice($bonusAmount) }}
                                                </td>
                                                <td class="text-center">
                                                    @if($user->enable_registration_bonus)
                                                        @if($user->affiliates_count > 0 || (isset($registrationBonusSettings['unlock_with_referral']) && !$registrationBonusSettings['unlock_with_referral']))
                                                            <span class="text-success">{{ trans('update.unlocked') }}</span>
                                                        @else
                                                            <span class="text-warning">{{ trans('update.locked') }}</span>
                                                        @endif
                                                    @else
                                                        <span class="text-danger">{{ trans('admin/main.disabled') }}</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">{{ dateTimeFormat($user->created_at, 'j M Y H:i') }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </table>
                            </div>
                        </div>

                        <div class="card-footer text-center">
                            @if(!empty($users) and method_exists($users, 'links'))
                                {{ $users->appends(request()->input())->links() }}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
