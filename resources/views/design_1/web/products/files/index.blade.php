@extends('design_1.web.layouts.app')

@push("styles_top")
    <link rel="stylesheet" href="{{ getDesign1StylePath("product_show") }}">
@endpush

@section('content')
    <div class="container mt-160 mb-160">
        <div class="bg-white py-16 rounded-24">
            <div class="d-flex align-items-start px-16">
                <div class="product-files-thumbnail size-126 rounded-24 bg-gray-100">
                    <img src="{{ $product->thumbnail }}" alt="{{ $product->title }}" class="img-cover rounded-24">
                </div>
                <div class="ml-16">
                    <a href="{{ $product->getUrl() }}" class="">
                        <h1 class="font-16 text-dark">{{ $product->title }}</h1>
                    </a>

                    {{-- Rate --}}
                    @include('design_1.web.components.rate', [
                         'rate' => $product->getRate(),
                         'rateCount' => $product->getRateCount(),
                         'rateClassName' => 'mt-8',
                         'rateCountFont' => 'font-12',
                     ])

                    <div class="d-flex align-items-center mt-16 gap-24">
                        <a href="{{ $product->creator->getProfileUrl() }}" target="_blank" class="d-flex align-items-center text-gray-500">
                            <x-iconsax-lin-profile class="icons text-gray-500" width="16px" height="16px"/>
                            <span class="ml-4 font-12 font-weight-bold">{{ $product->creator->full_name }}</span>
                        </a>

                        <div class="d-flex align-items-center text-gray-500">
                            <x-iconsax-lin-document class="icons text-gray-500" width="16px" height="16px"/>
                            <span class="mx-4 font-12 font-weight-bold">{{ $product->files->count() }}</span>
                            <span class="font-12 ">{{ trans('public.files') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="px-16 mt-16 border-top-gray-200">

                @if(!empty($license))
                    <div class="bg-primary-10 border border-primary-20 rounded-16 p-16 p-lg-24 mt-20 d-flex flex-column flex-lg-row align-items-lg-center justify-content-lg-between">
                        <div>
                            <div class="d-flex align-items-center">
                                <x-iconsax-bul-key class="icons text-primary mr-8" width="24px" height="24px"/>
                                <h3 class="font-16 font-weight-bold text-dark mb-0">Lisensi Resmi Produk Anda</h3>
                            </div>
                            <p class="font-12 text-gray-500 mt-4 mb-0">Gunakan serial key berikut untuk mengaktivasi software, tema, plugin, atau mengakses fasilitas VIP.</p>
                            <div class="mt-12 d-flex align-items-center gap-12">
                                <code class="font-16 font-weight-bold text-primary bg-white px-12 py-6 rounded-8 border border-primary-20">{{ $license->license_key }}</code>
                                <button type="button" class="btn btn-outline-primary btn-sm rounded-8 js-copy-license" data-key="{{ $license->license_key }}">
                                    <i class="fa fa-copy mr-1"></i> Salin Kunci
                                </button>
                            </div>
                        </div>
                        <div class="mt-16 mt-lg-0 text-lg-right">
                            <span class="d-block font-12 text-gray-500">Kuota Aktivasi Domain:</span>
                            <span class="font-14 font-weight-bold text-dark">{{ $license->activation_count }} / {{ $license->max_activations == 0 ? 'Unlimited' : $license->max_activations }}</span>
                            <span class="d-block font-12 text-muted mt-4">Masa Berlaku: {{ $license->expires_at ? dateTimeFormat($license->expires_at, 'j M Y') : 'Seumur Hidup (Lifetime)' }}</span>
                        </div>
                    </div>
                @endif

                {{-- Files --}}
                @include("design_1.web.products.show.includes.files_accordion", ['files' => $product->files])

            </div>

        </div>
    </div>
@endsection
