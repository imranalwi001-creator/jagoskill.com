@extends("design_1.web.layouts.app")

@push("styles_top")
    <link rel="stylesheet" href="{{ getDesign1StylePath("cart_page") }}">
    <link rel="stylesheet" href="/assets/default/vendors/daterangepicker/daterangepicker.min.css">
@endpush

@php
    $isMultiCurrency = !empty(getFinancialCurrencySettings('multi_currency'));
    $userCurrency = currency();
    $invalidChannels = [];
@endphp

@section("content")
    <section class="container my-56 position-relative">
        <div class="d-flex-center flex-column text-center">
            <h1 class="font-32">{{ trans('update.checkout') }}</h1>
            <p class="mt-8 font-16 text-gray-500">{{ handlePrice($calculatePrices["total"], true, true, false, null, true) . ' ' . trans('cart.for_items',['count' => $count]) }}</p>
        </div>

        <form action="/payments/payment-request" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <input type="hidden" name="order_id" value="{{ $order->id }}">

            <div class="row">
                {{-- Items --}}
                <div class="col-12 col-md-7 col-lg-9 mt-32 mb-104">

                    {{-- CashBack --}}
                    @if(!empty($totalCashbackAmount))
                        @include('design_1.web.cart.overview.includes.cashback_alert')
                    @endif

                    <div class="card-with-mask position-relative">
                        <div class="mask-8-white"></div>

                        <div class="position-relative z-index-2 bg-white rounded-16 py-16">
                            <div class="card-before-line px-16">
                                <h3 class="font-14">{{ trans('update.select_a_payment_gateway') }}</h3>
                            </div>

                            <div class="d-grid grid-columns-2 grid-lg-columns-3 gap-24 px-16 mt-16">
                                @if(!empty($paymentChannels))
                                    @foreach($paymentChannels as $paymentChannel)
                                        @if(!$isMultiCurrency or (!empty($paymentChannel->currencies) and in_array($userCurrency, $paymentChannel->currencies)))
                                            <div class="payment-channel-card position-relative">
                                                <input type="radio" name="gateway" id="gateway_{{ $paymentChannel->id }}" data-class="{{ $paymentChannel->class_name }}" value="{{ $paymentChannel->id }}">
                                                <label class="position-relative w-100 d-block cursor-pointer" for="gateway_{{ $paymentChannel->id }}">
                                                    <div class="gateway-mask"></div>
                                                    <div class="gateway-card position-relative z-index-2 d-flex-center flex-column rounded-16 bg-white w-100 h-100 text-center">
                                                        <div class="d-flex-center size-48 bg-gray-100">
                                                            <img src="{{ $paymentChannel->image }}" alt="" class="img-fluid">
                                                        </div>
                                                        <h6 class="font-14 mt-12">{{ $paymentChannel->title }}</h6>
                                                    </div>
                                                </label>
                                            </div>
                                        @else
                                            @php
                                                $invalidChannels[] = $paymentChannel;
                                            @endphp
                                        @endif
                                    @endforeach
                                @endif

                                <div class="payment-channel-card position-relative">
                                    <input type="radio" name="gateway" id="gateway_credit" value="credit" {{ (empty($userCharge) or ($calculatePrices["total"] > $userCharge)) ? 'disabled' : '' }}>
                                    <label class="position-relative w-100 d-block cursor-pointer" for="gateway_credit">
                                        <div class="gateway-mask"></div>
                                        <div class="gateway-card position-relative z-index-2 d-flex-center flex-column rounded-16 bg-white w-100 h-100 text-center">
                                            <div class="d-flex-center size-48 bg-gray-100">
                                                <x-iconsax-bul-empty-wallet class="icons text-dark" width="48px" height="48px"/>
                                            </div>
                                            <h6 class="font-14 mt-12">{{ trans('financial.account_charge') }}</h6>
                                            <p class="mt-4 font-12 text-gray-500">{{ handlePrice($userCharge) }}</p>
                                        </div>
                                    </label>
                                </div>

                                @if(!empty(getOfflineBankSettings('offline_banks_status')))
                                    <div class="payment-channel-card position-relative">
                                        <input type="radio" name="gateway" id="gateway_offline" value="offline">
                                        <label class="position-relative w-100 d-block cursor-pointer" for="gateway_offline">
                                            <div class="gateway-mask"></div>
                                            <div class="gateway-card position-relative z-index-2 d-flex-center flex-column rounded-16 bg-white w-100 h-100 text-center">
                                                <div class="d-flex-center size-48 bg-gray-100">
                                                    <x-iconsax-bul-convert-card class="icons text-dark" width="48px" height="48px"/>
                                                </div>
                                                <h6 class="font-14 mt-12">{{ trans('financial.offline') }}</h6>
                                            </div>
                                        </label>
                                    </div>
                                @endif
                            </div>


                            @if(!empty($invalidChannels) and empty(getFinancialSettings("hide_disabled_payment_gateways")))
                                <div class="px-16 mt-28">
                                    {{-- Alert --}}
                                    <div class="position-relative pl-8">
                                        <div class="d-flex align-items-center p-12 rounded-12 bg-gray-500-20">
                                            <div class="alert-left-20 d-flex-center size-48 bg-gray-500 rounded-12">
                                                <x-iconsax-bol-info-circle class="icons text-white" width="24px" height="24px"/>
                                            </div>

                                            <div class="ml-8">
                                                <h6 class="font-14 text-gray-500">{{ trans('update.disabled_payment_gateways') }}</h6>
                                                <p class="font-12 text-gray-500 opacity-75">{{ trans('update.disabled_payment_gateways_hint') }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-grid grid-columns-3 gap-24 mt-16">
                                        @foreach($invalidChannels as $invalidChannel)
                                            <div class="disabled-payment-channel d-flex align-items-center p-16 rounded-16 border-gray-200">
                                                <div class="d-flex-center size-48 bg-gray-100">
                                                    <img src="{{ $invalidChannel->image }}" alt="" class="img-fluid">
                                                </div>
                                                <h6 class="font-14 ml-16 text-gray-500">{{ $invalidChannel->title }}</h6>
                                            </div>
                                        @endforeach
                                    </div>

                                </div>

                            @endif

                        </div>

                        @if(!empty(getOfflineBankSettings('offline_banks_status')))
                            <div class="js-offline-payment-input d-none mt-36 px-16">
                                @php
                                    $sessionKey = 'offline_unique_code_' . $order->id;
                                    $uniqueCode = session()->get($sessionKey);
                                    if (empty($uniqueCode)) {
                                        $uniqueCode = rand(100, 999);
                                        session()->put($sessionKey, $uniqueCode);
                                    }
                                    $uniqueAmount = $order->total_amount + $uniqueCode;
                                    $qrisPayload = generate_qris_dynamic($uniqueAmount);
                                    $qrImageUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&margin=10&data=' . urlencode($qrisPayload);
                                @endphp

                                <div class="row align-items-stretch">
                                    {{-- QRIS Scanner Section --}}
                                    <div class="col-12 col-md-5 mb-24 mb-md-0">
                                        <div class="p-20 rounded-16 border border-gray-200 bg-light text-center d-flex flex-column align-items-center justify-content-center h-100">
                                            <h6 class="font-16 font-weight-bold text-dark mb-8">Scan QRIS Anugerah Store</h6>
                                            <p class="font-12 text-gray-500 mb-16">Dapat di-scan dengan e-wallet (GoPay, OVO, Dana) & M-Banking</p>
                                            
                                            <div class="p-12 bg-white rounded-16 shadow-sm mb-16 animate-pulse" style="border: 1px solid var(--gray-200);">
                                                <img src="{{ $qrImageUrl }}" alt="QRIS" class="img-fluid" style="max-height: 220px; width: 220px; object-fit: contain;">
                                            </div>

                                            <a href="{{ $qrImageUrl }}" download="jagoskill-qris-{{ $order->id }}.png" target="_blank" class="btn btn-sm btn-outline-primary d-inline-flex align-items-center gap-4 px-16 py-8 rounded-8 font-12">
                                                <x-iconsax-lin-import class="icons text-primary" width="16px" height="16px"/>
                                                Download QR Image
                                            </a>
                                        </div>
                                    </div>

                                    {{-- Payment Info & Form --}}
                                    <div class="col-12 col-md-7">
                                        <div class="p-20 rounded-16 border border-gray-200 h-100 bg-white d-flex flex-column justify-content-between">
                                            <div class="mb-20 p-16 rounded-12 text-center" style="background-color: #fff9e6; border: 1px solid #ffe8ad;">
                                                <span class="font-12 text-warning font-weight-500 uppercase tracking-wider">TOTAL TRANSFER (WAJIB PERSIS)</span>
                                                <h3 class="font-28 font-weight-bold mt-4" style="color: #d97706;">
                                                    Rp {{ number_format($uniqueAmount, 0, ',', '.') }}
                                                </h3>
                                                <p class="font-11 text-warning mt-4 mb-0">Mohon transfer nominal di atas hingga 3 digit terakhir (kode unik) agar transaksi Anda terverifikasi secara otomatis.</p>
                                            </div>

                                            <div class="row">
                                                <div class="col-12 col-sm-6 mb-16">
                                                    <div class="form-group">
                                                        <label class="form-group-label">{{ trans('financial.account') }}</label>
                                                        <select name="account" class="form-control">
                                                            @foreach($offlineBanks as $offlineBank)
                                                                <option value="{{ $offlineBank->id }}" {{ str_contains(strtolower($offlineBank->title), 'qris') ? 'selected' : '' }}>
                                                                    {{ $offlineBank->title }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-12 col-sm-6 mb-16">
                                                    <div class="form-group">
                                                        <label class="form-group-label">Kode Unik Transaksi</label>
                                                        <input type="text" name="referral_code" value="{{ $uniqueCode }}" class="form-control text-center font-weight-bold" style="background-color: var(--gray-100);" readonly/>
                                                    </div>
                                                </div>

                                                <div class="col-12 col-sm-6 mb-16">
                                                    <div class="form-group">
                                                        <label class="form-group-label">{{ trans('public.date_time') }}</label>
                                                        <input type="text" name="date" value="{{ date('Y/m/d H:i') }}" class="form-control datetimepicker js-default-init-date-picker" data-format="YYYY/MM/DD HH:mm"/>
                                                    </div>
                                                </div>

                                                <div class="col-12 col-sm-6 mb-16">
                                                    <div class="form-group">
                                                        <label class="form-group-label">{{ trans('update.attach_the_payment_photo') }}</label>
                                                        <div class="custom-file bg-white">
                                                            <input type="file" name="attachment" class="custom-file-input" id="attachmentInputCheckout" accept="image/*">
                                                            <span class="custom-file-text"></span>
                                                            <label class="custom-file-label" for="attachmentInputCheckout">{{ trans('update.browse') }}</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>


                </div>

                {{-- Right Side --}}
                <div class="col-12 col-md-5 col-lg-3 mt-32">
                    <div class="cart-right-side-section">
                        {{-- Summary --}}

                        <div class="js-cart-summary-container">
                            @include('design_1.web.cart.overview.includes.summary', ['isCartPaymentPage' => true])
                        </div>

                    </div>
                </div>
            </div>

        </form>

    </section>

    @if(!empty($razorpay) and $razorpay)
        <form action="/payments/verify/Razorpay" method="get">
            <input type="hidden" name="order_id" value="{{ $order->id }}">

            <script src="https://checkout.razorpay.com/v1/checkout.js"
                    data-key="{{ getRazorpayApiKey()['api_key'] }}"
                    data-amount="{{ (int)($order->total_amount * 100) }}"
                    data-buttontext=""
                    data-description="Rozerpay"
                    data-currency="{{ currency() }}"
                    data-image="{{ $generalSettings['logo'] }}"
                    data-prefill.name="{{ $order->user->full_name }}"
                    data-prefill.email="{{ $order->user->email }}"
                    data-theme.color="#43d477">
            </script>
        </form>
    @endif

@endsection

@push('scripts_bottom')
    <script>
        var hasErrors = '{{ (!empty($errors) and count($errors)) ? 'true' : 'false' }}';
        var hasErrorsHintLang = '{{ trans('update.please_check_the_errors_in_the_shipping_form') }}';
        var selectPaymentGatewayLang = '{{ trans('update.select_a_payment_gateway') }}';
        var pleaseWaitLang = '{{ trans('update.please_wait') }}';
        var transferringToLang = '{{ trans('update.transferring_to_the_payment_gateway') }}';
    </script>
    <script src="/assets/default/vendors/moment.min.js"></script>
    <script src="/assets/default/vendors/daterangepicker/daterangepicker.min.js"></script>
    <script src="{{ getDesign1ScriptPath("cart_page") }}"></script>
    <script>
        (function() {
            function toggleOfflineFields() {
                var offlineRadio = document.getElementById('gateway_offline');
                var container = document.querySelector('.js-offline-payment-input');
                if (!container) return;
                if (offlineRadio && offlineRadio.checked) {
                    container.classList.remove('d-none');
                } else {
                    container.classList.add('d-none');
                }
            }
            document.addEventListener('change', function (e) {
                if (e.target && e.target.name === 'gateway') {
                    toggleOfflineFields();
                }
            });
            document.addEventListener('DOMContentLoaded', toggleOfflineFields);
        })();
    </script>
@endpush
