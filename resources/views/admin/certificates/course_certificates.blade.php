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
            <div class="card">
                <div class="card-header"><div><h5 class="font-14 mb-0">{{ trans('update.competition_certificates') }}</h5><p class="font-12 mt-4 mb-0 text-gray-500">{{ trans('update.manage_all_items_in_a_single_place') }}</p></div></div>
                <div class="card-body">
                    @if(!empty($certificates) and $certificates->count())
                        <div class="table-responsive">
                            <table class="table custom-table font-14">
                                <tr><th>{{ trans('public.certificate_id') }}</th><th class="text-left">{{ trans('admin/main.course') }}</th><th>{{ trans('update.bundle') }}</th><th>{{ trans('admin/main.student') }}</th><th>{{ trans('public.date') }}</th><th>{{ trans('admin/main.actions') }}</th></tr>
                                @foreach($certificates as $certificate)
                                    <tr class="text-center">
                                        <td>{{ $certificate->id }}</td>
                                        <td class="text-left">{{ !empty($certificate->webinar) ? $certificate->webinar->title : '-' }}</td>
                                        <td>{{ !empty($certificate->bundle) ? $certificate->bundle->title : '-' }}</td>
                                        <td>{{ !empty($certificate->student) ? $certificate->student->full_name : '-' }}</td>
                                        <td>{{ dateTimeFormat($certificate->created_at, 'j M Y') }}</td>
                                        <td><a href="{{ getAdminPanelUrl("/certificates/course/{$certificate->id}/download") }}" target="_blank" class="btn-transparent"><x-iconsax-lin-import-2 class="icons text-gray-500" width="20px" height="20px"/></a></td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                        <div class="card-footer text-center">{{ $certificates->appends(request()->input())->links() }}</div>
                    @else
                        @include('admin.includes.no-result',['file_name' => 'cert.png','title' => trans('update.competition_certificates'),'hint' => trans('update.no_result_default_hint')])
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
