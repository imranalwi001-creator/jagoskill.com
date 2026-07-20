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
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-robot"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>{{ trans('update.total_generated') }}</h4>
                            </div>
                            <div class="card-body">
                                {{ $totalGenerated }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-info">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>{{ trans('update.text_generated') }}</h4>
                            </div>
                            <div class="card-body">
                                {{ $textGenerated }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-warning">
                            <i class="fas fa-image"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>{{ trans('update.image_generated') }}</h4>
                            </div>
                            <div class="card-body">
                                {{ $imageGenerated }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-success">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>{{ trans('update.users') }}</h4>
                            </div>
                            <div class="card-body">
                                {{ $usersCount }}
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
                                        <th class="text-center">{{ trans('admin/main.type') }}</th>
                                        <th class="text-center">{{ trans('admin/main.date') }}</th>
                                        <th>{{ trans('admin/main.actions') }}</th>
                                    </tr>

                                    @foreach($contents as $content)
                                        <tr>
                                            <td>
                                                @if(!empty($content->user))
                                                    <a href="{{ getAdminPanelUrl() }}/users/{{ $content->user_id }}/edit" target="_blank">{{ $content->user->full_name }}</a>
                                                @else
                                                    <span class="text-muted">{{ trans('update.guest') }}</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                {{ trans('update.' . $content->service_type) }}
                                            </td>
                                            <td class="text-center">
                                                {{ dateTimeFormat($content->created_at, 'j M Y H:i') }}
                                            </td>
                                            <td>
                                                @can('admin_ai_contents_lists')
                                                    @include('admin.includes.delete_button',['url' => getAdminPanelUrl('/ai-contents/'.$content->id.'/delete') , 'btnClass' => ''])
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>

                            <div class="card-footer text-center">
                                {{ $contents->appends(request()->input())->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
