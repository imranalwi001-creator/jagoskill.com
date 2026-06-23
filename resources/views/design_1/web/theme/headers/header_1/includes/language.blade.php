@php
    $getUserLanguageAndLocale = getUserLanguagesLists();
@endphp

<div class="js-language-select theme-header-1__dropdown position-relative">
    <form action="/locale" method="post">
        {{ csrf_field() }}
        <input type="hidden" name="locale" value="{{ app()->getLocale() }}">

        @foreach($getUserLanguageAndLocale as $localeSign => $language)
            @if(mb_strtolower(app()->getLocale()) == mb_strtolower($localeSign))
                <div class="d-flex align-items-center gap-8">
                    <div class="language-toggle-badge size-32 d-flex-center bg-white-10 rounded-8 font-11 font-weight-bold text-white text-uppercase">
                        {{ mb_strtoupper($localeSign) }}
                    </div>
                    <span class="js-lang-title text-white opacity-75 d-none d-md-flex text-nowrap">{{ $language }}</span>
                    <x-iconsax-lin-arrow-down class="icons text-white opacity-75" width="16px" height="16px"/>
                </div>
            @endif
        @endforeach
    </form>

    <div class="header-1-dropdown-menu py-8 mx-w-200">

        <div class="py-8 px-16 font-12 text-gray-500">{{ trans('update.select_a_language') }}</div>

        @foreach($getUserLanguageAndLocale as $localeSign => $language)
            <div class="js-language-dropdown-item header-1-dropdown-menu__item cursor-pointer {{ (mb_strtolower(app()->getLocale()) == mb_strtolower($localeSign)) ? 'active' : '' }}" data-value="{{ $localeSign }}" data-title="{{ $language }}">
                <div class="d-flex align-items-center w-100 px-16 py-8 text-dark bg-transparent">
                    <div class="size-32 d-flex-center bg-gray-100 rounded-8 font-11 font-weight-bold text-primary text-uppercase flex-shrink-0">
                        {{ mb_strtoupper($localeSign) }}
                    </div>
                    <span class="ml-8 font-14 text-nowrap">{{ $language }}</span>
                </div>
            </div>
        @endforeach

    </div>
</div>
