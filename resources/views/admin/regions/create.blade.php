@extends('admin.layouts.app')

@push('styles_top')
    <link rel="stylesheet" href="/assets/default/vendors/select2/select2.min.css">
@endpush

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
                <div class="col-12 col-md-8 col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ getAdminPanelUrl('/regions/' . (!empty($region) ? $region->id . '/update' : 'store')) }}" method="post">
                                {{ csrf_field() }}

                                <input type="hidden" name="type" value="{{ request()->get('type', !empty($region) ? $region->type : \App\Models\Region::$country) }}">

                                @if(request()->get('type', !empty($region) ? $region->type : \App\Models\Region::$country) === \App\Models\Region::$country && empty($region))
                                    <div class="form-group">
                                        <label>{{ trans('update.country') }}</label>
                                        <select name="api_country_id" class="form-control select2">
                                            <option value="">{{ trans('admin/main.select') }}</option>
                                            @if(!empty($apiCountries))
                                                @foreach($apiCountries as $apiCountry)
                                                    <option value="{{ $apiCountry['id'] }}">{{ $apiCountry['name'] }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <p class="text-muted text-small">{{ trans('update.country_will_be_imported_with_all_states_and_cities') }}</p>
                                @else
                                    <div class="form-group">
                                        <label>{{ trans('admin/main.title') }}</label>
                                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ !empty($region) ? $region->title : old('title') }}"/>
                                        @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    @if(in_array(request()->get('type', !empty($region) ? $region->type : \App\Models\Region::$country), [\App\Models\Region::$province, \App\Models\Region::$city, \App\Models\Region::$district]))
                                        <div class="form-group">
                                            <label>{{ trans('update.country') }}</label>
                                            <select name="country_id" class="form-control select2 @error('country_id') is-invalid @enderror">
                                                <option value="">{{ trans('admin/main.select') }}</option>
                                                @if(!empty($countries))
                                                    @foreach($countries as $country)
                                                        <option value="{{ $country->id }}" {{ (!empty($region) and $region->country_id == $country->id) ? 'selected' : '' }}>{{ $country->title }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @error('country_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    @endif

                                    @if(in_array(request()->get('type', !empty($region) ? $region->type : \App\Models\Region::$country), [\App\Models\Region::$city, \App\Models\Region::$district]))
                                        <div class="form-group">
                                            <label>{{ trans('update.province') }}</label>
                                            <select name="province_id" class="form-control select2 @error('province_id') is-invalid @enderror">
                                                <option value="">{{ trans('admin/main.select') }}</option>
                                                @if(!empty($provinces))
                                                    @foreach($provinces as $province)
                                                        <option value="{{ $province->id }}" {{ (!empty($region) and $region->province_id == $province->id) ? 'selected' : '' }}>{{ $province->title }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @error('province_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    @endif

                                    @if(request()->get('type', !empty($region) ? $region->type : \App\Models\Region::$country) === \App\Models\Region::$district)
                                        <div class="form-group">
                                            <label>{{ trans('update.city') }}</label>
                                            <select name="city_id" class="form-control select2 @error('city_id') is-invalid @enderror">
                                                <option value="">{{ trans('admin/main.select') }}</option>
                                                @if(!empty($cities))
                                                    @foreach($cities as $city)
                                                        <option value="{{ $city->id }}" {{ (!empty($region) and $region->city_id == $city->id) ? 'selected' : '' }}>{{ $city->title }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @error('city_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    @endif

                                    <div class="form-group">
                                        <label>{{ trans('update.latitude') }}</label>
                                        <input type="text" name="latitude" class="form-control @error('latitude') is-invalid @enderror" value="{{ !empty($region) ? (!empty($region->geo_center) ? $region->geo_center[0] : '') : old('latitude', (!empty($latitude) ? $latitude : '')) }}"/>
                                        @error('latitude')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>{{ trans('update.longitude') }}</label>
                                        <input type="text" name="longitude" class="form-control @error('longitude') is-invalid @enderror" value="{{ !empty($region) ? (!empty($region->geo_center) ? $region->geo_center[1] : '') : old('longitude', (!empty($longitude) ? $longitude : '')) }}"/>
                                        @error('longitude')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                @endif

                                <div class="mt-4">
                                    <button class="btn btn-primary">{{ trans('admin/main.submit') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts_bottom')
    <script src="/assets/default/vendors/select2/select2.min.js"></script>
    <script>
        (function ($) {
            "use strict";

            $('body').on('change', 'select[name="country_id"]', function (e) {
                e.preventDefault();

                var countryId = $(this).val();
                var $provinceSelect = $('select[name="province_id"]');
                var $citySelect = $('select[name="city_id"]');

                if ($provinceSelect.length) {
                    $provinceSelect.html('<option value="">{{ trans('admin/main.select') }}</option>');
                    if ($citySelect.length) {
                        $citySelect.html('<option value="">{{ trans('admin/main.select') }}</option>');
                    }

                    if (countryId) {
                        $.get('/admin/regions/provincesByCountry/' + countryId, function (result) {
                            if (result && result.code == 200) {
                                var options = '<option value="">{{ trans('admin/main.select') }}</option>';
                                Object.keys(result.provinces).forEach(function (key) {
                                    var province = result.provinces[key];
                                    options += '<option value="' + province.id + '">' + province.title + '</option>';
                                });
                                $provinceSelect.html(options);
                            }
                        });
                    }
                }
            });

            $('body').on('change', 'select[name="province_id"]', function (e) {
                e.preventDefault();

                var provinceId = $(this).val();
                var $citySelect = $('select[name="city_id"]');

                if ($citySelect.length) {
                    $citySelect.html('<option value="">{{ trans('admin/main.select') }}</option>');

                    if (provinceId) {
                        $.get('/admin/regions/citiesByProvince/' + provinceId, function (result) {
                            if (result && result.code == 200) {
                                var options = '<option value="">{{ trans('admin/main.select') }}</option>';
                                Object.keys(result.cities).forEach(function (key) {
                                    var city = result.cities[key];
                                    options += '<option value="' + city.id + '">' + city.title + '</option>';
                                });
                                $citySelect.html(options);
                            }
                        });
                    }
                }
            });

        })(jQuery);
    </script>
@endpush
