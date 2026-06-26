<div class="blog-editorial-header">
    <div class="d-flex align-items-center mb-16">
        <a href="/" class="text-gray-500 font-14 hover-text-primary">{{ getPlatformName() }}</a>
        <x-iconsax-lin-arrow-right-1 class="icons text-gray-500 mx-8" width="14px" height="14px"/>
        <a href="/blog" class="text-gray-500 font-14 hover-text-primary">{{ trans('home.blog') }}</a>
        <x-iconsax-lin-arrow-right-1 class="icons text-gray-500 mx-8" width="14px" height="14px"/>
        <a href="{{ $post->category->getUrl() }}" class="text-gray-500 font-14 hover-text-primary">{{ $post->category->title }}</a>
    </div>

    <h1 class="font-36 font-weight-bold text-dark mb-20" style="line-height: 1.3;">{{ $post->title }}</h1>

    @php
        $postBadges = $post->allBadges();
    @endphp
    @if(!empty($postBadges) and count($postBadges))
        <div class="d-flex flex-wrap align-items-center gap-12 mb-20">
            @foreach($postBadges as $postBadge)
                <div class="d-inline-flex align-items-center gap-4 px-12 py-4 rounded-32 font-12" style="background-color: {{ $postBadge->background }}; color: {{ $postBadge->color }};">
                    <x-iconsax-bul-note-2 class="icons" width="16px" height="16px"/>
                    <span class="font-weight-600">{{ $postBadge->title }}</span>
                </div>
            @endforeach
        </div>
    @endif

    <div class="d-flex flex-wrap align-items-center border-top border-bottom py-16 mt-24">
        
        <a href="{{ $post->author->getProfileUrl() }}" target="_blank" class="d-flex align-items-center mr-32">
            <img src="{{ $post->author->getAvatar(48) }}" alt="{{ $post->author->full_name }}" class="img-cover rounded-circle" style="width: 48px; height: 48px;">
            <div class="ml-12">
                <span class="d-block font-14 font-weight-bold text-dark">{{ $post->author->full_name }}</span>
                <span class="d-block font-12 text-gray-500 mt-4">{{ trans('update.written_by') }}</span>
            </div>
        </a>

        <div class="d-flex align-items-center mr-32 mt-16 mt-md-0">
            <div class="d-flex-center size-32 bg-gray-100 rounded-circle text-gray-500 mr-8">
                <x-iconsax-lin-calendar-2 width="16px" height="16px"/>
            </div>
            <div>
                <span class="d-block font-14 font-weight-bold text-dark">{{ dateTimeFormat($post->created_at, 'j M Y') }}</span>
                <span class="d-block font-12 text-gray-500 mt-4">{{ trans('update.published_on') }}</span>
            </div>
        </div>

        @if(!empty($post->study_time))
        <div class="d-flex align-items-center mt-16 mt-md-0">
            <div class="d-flex-center size-32 bg-gray-100 rounded-circle text-gray-500 mr-8">
                <x-iconsax-lin-clock-1 width="16px" height="16px"/>
            </div>
            <div>
                <span class="d-block font-14 font-weight-bold text-dark">{{ $post->study_time }} {{ trans('update.mins') }}</span>
                <span class="d-block font-12 text-gray-500 mt-4">{{ trans('public.study_time') }}</span>
            </div>
        </div>
        @endif

    </div>
</div>
