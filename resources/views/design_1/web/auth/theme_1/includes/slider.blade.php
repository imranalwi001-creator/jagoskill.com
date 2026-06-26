@php
    $themeSettings = getThemeAuthenticationPagesSettings();
    $sliderBg = (!empty($themeSettings) and !empty($themeSettings['slider_background_image'])) ? $themeSettings['slider_background_image'] : null;
    $sliders = (!empty($themeSettings) and !empty($themeSettings['slider_contents']) and is_array($themeSettings['slider_contents'])) ? $themeSettings['slider_contents'] : [];
@endphp

@php
    $slider = !empty($sliders) ? reset($sliders) : [];
@endphp

<div class="auth-static-showcase w-100" @if(!empty($sliderBg)) style="background-image: url('{{ $sliderBg }}')" @endif>
    @if(!empty($sliders))
        <div class="auth-static-showcase__overlay">
            <div class="w-100">
                @if(!empty($slider['image']))
                    <div class="auth-static-showcase__image d-flex-center mb-24">
                        <img src="{{ $slider['image'] }}" alt="image" class="img-fluid" loading="lazy" decoding="async">
                    </div>
                @endif

                @if(!empty($slider['title']))
                    <h4 class="font-24 text-white mb-8">{{ $slider['title'] }}</h4>
                @endif

                @if(!empty($slider['subtitle']))
                    <div class="font-14 text-white opacity-75">{{ $slider['subtitle'] }}</div>
                @endif
            </div>
        </div>
    @endif
</div>
