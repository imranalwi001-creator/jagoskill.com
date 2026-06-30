@extends("design_1.web.layouts.app")

@push("styles_top")
    <link rel="stylesheet" href="{{ getDesign1StylePath("system_status_pages") }}">
@endpush

@section("content")
    <section class="container mt-96 mb-104 position-relative">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8">
                <div class="system-status-page-section position-relative">
                    <div class="system-status-page-section__mask"></div>

                    <div class="position-relative d-flex-center flex-column bg-white rounded-32 px-24 px-lg-40 py-54 py-lg-100 text-center z-index-2">

                        @if($order->status === \App\Models\Order::$paid)
                            <div class="system-status-page-image">
                                <img src="/assets/design_1/img/cart/successful_payment.png" alt="{{ trans('update.successful_payment') }}" class="img-cover">
                            </div>

                            <h1 class="font-16 font-weight-bold mt-14">{{ trans('update.successful_payment') }}</h1>

                            <p class="font-14 text-gray-500 mt-4">{{ trans('update.successful_payment_hint') }}</p>

                            <div class="d-flex align-items-center gap-16 mt-16">
                                <a href="academyapp://payment-success" class="btn btn-lg btn-outline-primary d-flex d-sm-none">{{ trans('update.redirect_to_app') }}</a>

                                <a href="/panel" class="btn btn-primary btn-lg">{{ trans('public.my_panel') }}</a>
                            </div>
                        @else
                            @php
                                $isOfflineSubmitted = (!empty($order) && $order->status === \App\Models\Order::$paying);
                            @endphp
                            @if($isOfflineSubmitted)
                                 @php
                                     $offlinePayment = \App\Models\OfflinePayment::where('order_id', $order->id)->first();
                                     $uniqueCode = $offlinePayment ? $offlinePayment->reference_number : session()->get('offline_unique_code_' . $order->id);
                                     $uniqueAmount = $offlinePayment ? $offlinePayment->amount : ($order->total_amount + $uniqueCode);
                                     $waPhone = '6281355904897';
                                     $waMessage = "Halo Admin JagoSkill, saya telah mengunggah bukti pembayaran QRIS Offline. Mohon bantuannya untuk memverifikasi transaksi berikut:\n\n"
                                                . "• No. Order: #" . $order->id . "\n"
                                                . "• Nama Akun: " . $order->user->full_name . "\n"
                                                . "• Total Transfer: Rp " . number_format($uniqueAmount, 0, ',', '.') . " (Termasuk Kode Unik: " . $uniqueCode . ")\n"
                                                . "• Metode: QRIS Dinamis\n\n"
                                                . "Terima kasih, mohon segera diaktifkan kelasnya!";
                                     $waUrl = "https://wa.me/" . $waPhone . "?text=" . urlencode($waMessage);
                                 @endphp

                                <div class="system-status-page-image">
                                    <img src="/assets/design_1/img/cart/successful_payment.png" alt="{{ trans('update.successful_payment') }}" class="img-cover">
                                </div>

                                <h1 class="font-16 font-weight-bold mt-14">{{ trans('update.offline_payment_submitted') }}</h1>

                                <p class="font-14 text-gray-500 mt-4">{{ trans('update.offline_payment_submitted_hint') }}</p>

                                <div class="d-flex flex-column align-items-center justify-content-center mt-24 mb-16 p-20 rounded-24 border border-gray-200 bg-white" style="max-width: 480px; margin-left: auto; margin-right: auto; box-shadow: 0 4px 16px rgba(0,0,0,0.03);">
                                    <div class="d-flex-center size-48 rounded-circle mb-12" style="background-color: #e6f7ed;">
                                        <x-iconsax-bul-message-2 class="icons text-success animate-pulse" width="28px" height="28px"/>
                                    </div>
                                    <h5 class="font-15 font-weight-bold text-dark mb-4">Konfirmasi Instan WhatsApp</h5>
                                    <p class="font-12 text-gray-500 mb-16 px-16">Bukti pembayaran Anda sudah dikirim. Klik tombol di bawah ini jika aplikasi WhatsApp tidak terbuka otomatis.</p>
                                    <a href="{{ $waUrl }}" id="btnConfirmWA" target="_blank" class="btn btn-success d-inline-flex align-items-center gap-8 px-24 py-12 rounded-12 font-weight-600 font-14" style="background-color: #25d366; border-color: #25d366; color: white;">
                                        Hubungi Admin JagoSkill
                                    </a>
                                </div>

                                <div class="d-flex align-items-center gap-16 mt-16">
                                    <a href="/panel" class="btn btn-primary btn-lg">{{ trans('public.my_panel') }}</a>
                                </div>
                            @else
                            <div class="system-status-page-image">
                                <img src="/assets/design_1/img/cart/failed_payment.png" alt="{{ trans('update.failed_payment') }}" class="img-cover">
                            </div>

                            <h1 class="font-16 font-weight-bold mt-14">{{ trans('update.failed_payment') }}</h1>

                            <p class="font-14 text-gray-500 mt-4">{{ trans('update.failed_payment_hint') }}</p>

                            <div class="d-flex align-items-center gap-16 mt-16">
                                <a href="academyapp://payment-failed" class="btn btn-lg btn-outline-primary d-flex d-sm-none">{{ trans('update.redirect_to_app') }}</a>

                                <a href="/panel" class="btn btn-primary btn-lg">{{ trans('public.my_panel') }}</a>
                            </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts_bottom')
    @if(!empty($order) && $order->status === \App\Models\Order::$paying)
        <script>
            $(document).ready(function() {
                setTimeout(function() {
                    var win = window.open('{!! $waUrl !!}', '_blank');
                    if (win) {
                        win.focus();
                    }
                }, 1800);
            });
        </script>
    @endif
@endpush
