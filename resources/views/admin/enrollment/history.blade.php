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
            <section class="card">
                <div class="card-body pb-4">
                    <form method="get" class="mb-0">
                        <div class="row">
                            <div class="col-md-3"><div class="form-group"><label class="input-label">{{ trans('admin/main.start_date') }}</label><input name="from" type="date" class="form-control text-center" value="{{ request()->get('from') }}"></div></div>
                            <div class="col-md-3"><div class="form-group"><label class="input-label">{{ trans('admin/main.end_date') }}</label><input name="to" type="date" class="form-control text-center" value="{{ request()->get('to') }}"></div></div>
                            <div class="col-md-3"><div class="form-group"><label class="input-label">{{ trans('admin/main.student') }}</label><select name="student_ids[]" multiple class="form-control search-user-select2" data-search-option="just_student_role">@if(!empty($students))@foreach($students as $student)<option value="{{ $student->id }}" selected>{{ $student->full_name }}</option>@endforeach@endif</select></div></div>
                            <div class="col-md-3 d-flex align-items-center"><button type="submit" class="btn btn-primary btn-block btn-lg">{{ trans('admin/main.show_results') }}</button></div>
                        </div>
                    </form>
                </div>
            </section>

            <div class="card mt-32">
                <div class="card-header justify-content-between">
                    <div><h5 class="font-14 mb-0">{{ trans('update.enrollments') }}</h5><p class="font-12 mt-4 mb-0 text-gray-500">{{ trans('update.manage_all_items_in_a_single_place') }}</p></div>
                    @can('admin_enrollment_add_student_to_items')<a href="{{ getAdminPanelUrl('/enrollments/add-student-to-class') }}" class="btn btn-primary">{{ trans('update.add_student_to_a_class') }}</a>@endcan
                </div>
                <div class="card-body">
                    @if(!empty($sales) and $sales->count())
                        <div class="table-responsive">
                            <table class="table custom-table font-14">
                                <tr><th class="text-left">{{ trans('admin/main.course') }}</th><th>{{ trans('admin/main.student') }}</th><th>{{ trans('admin/main.instructor') }}</th><th>{{ trans('admin/main.amount') }}</th><th>{{ trans('public.date') }}</th><th>{{ trans('admin/main.status') }}</th></tr>
                                @foreach($sales as $sale)
                                    <tr class="text-center">
                                        <td class="text-left"><span class="text-dark font-weight-bold">{{ $sale->item_title }}</span></td>
                                        <td>{{ !empty($sale->buyer) ? $sale->buyer->full_name : '-' }}</td>
                                        <td>{{ $sale->item_seller ?? '-' }}</td>
                                        <td>{{ handlePrice($sale->total_amount) }}</td>
                                        <td>{{ dateTimeFormat($sale->created_at, 'j M Y H:i') }}</td>
                                        <td><span class="badge {{ empty($sale->refund_at) ? 'badge-primary' : 'badge-danger' }}">{{ empty($sale->refund_at) ? trans('admin/main.success') : trans('admin/main.refunded') }}</span></td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                        <div class="card-footer text-center">{{ $sales->appends(request()->input())->links() }}</div>
                    @else
                        @include('admin.includes.no-result',['file_name' => 'sales.png','title' => trans('update.enrollments'),'hint' => trans('update.no_result_default_hint')])
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
