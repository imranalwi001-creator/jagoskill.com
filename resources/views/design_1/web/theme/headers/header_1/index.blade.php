@if(!empty($themeHeaderData['contents']))
    <div id="themeHeaderVacuum"></div>
    <div class="theme-header-1">
        {{-- Top Nav --}}
        @if(!empty($themeHeaderData['contents']['top_navbar']))
            @include('design_1.web.theme.headers.header_1.top_nav', ['themeHeaderTopNavData' => $themeHeaderData['contents']['top_navbar']])
        @endif

        {{-- Main --}}
        @include('design_1.web.theme.headers.header_1.main')
    </div>

    <style>
        /* Fix top navbar overlap where search bar and cart get cut off by the white navbar card */
        .theme-header-1__main {
            top: -26px !important;
            margin-bottom: -26px !important;
        }
        .theme-header-1__top-navbar {
            padding-bottom: 42px !important;
        }
    </style>
@endif
