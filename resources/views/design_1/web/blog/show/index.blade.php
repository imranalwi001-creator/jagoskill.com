@extends("design_1.web.layouts.app")

@push("styles_top")
    <link rel="stylesheet" href="/assets/default/vendors/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="{{ getDesign1StylePath("swiperjs") }}">
    <link rel="stylesheet" href="{{ getDesign1StylePath("show_blog") }}">
    <style>
        /* Editorial Layout Custom CSS */
        .blog-editorial-container {
            margin-top: 40px;
        }
        .blog-hero-image-wrapper {
            margin: 32px 0;
            position: relative;
            box-shadow: 0 10px 40px rgba(0,0,0,0.05);
            border-radius: 24px;
            overflow: hidden;
        }
        .blog-hero-image-wrapper img {
            width: 100%;
            height: auto;
            max-height: 500px;
            object-fit: cover;
        }
        .blog-editorial-content {
            font-size: 18px;
            line-height: 1.85;
            color: #334155;
            margin-bottom: 40px;
        }
        .blog-editorial-content p {
            margin-bottom: 24px;
        }
        .blog-editorial-content h2, .blog-editorial-content h3 {
            margin-top: 40px;
            margin-bottom: 20px;
            color: #1e293b;
            font-weight: 700;
        }
        .blog-editorial-lead {
            font-size: 20px;
            line-height: 1.8;
            color: #475569;
            font-style: italic;
            border-left: 4px solid var(--primary);
            padding-left: 20px;
            margin: 32px 0;
            background: #f8fafc;
            padding: 24px 24px 24px 20px;
            border-radius: 0 16px 16px 0;
        }
        /* Sticky Sidebar */
        .blog-sidebar-sticky {
            position: sticky;
            top: 100px;
        }
        .blog-sidebar-widget {
            background: #ffffff;
            border: 1px solid #f1f5f9;
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 24px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.03);
        }
        .blog-sidebar-widget-title {
            font-size: 18px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 20px;
            position: relative;
            padding-bottom: 12px;
        }
        .blog-sidebar-widget-title::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 40px;
            height: 3px;
            background: var(--primary);
            border-radius: 4px;
        }
        .sidebar-category-pill {
            display: inline-block;
            padding: 8px 16px;
            background: #f8fafc;
            color: #475569;
            border-radius: 20px;
            font-size: 14px;
            margin-right: 8px;
            margin-bottom: 12px;
            transition: all 0.3s;
        }
        .sidebar-category-pill:hover {
            background: var(--primary);
            color: #fff;
        }
        .popular-post-item {
            display: flex;
            align-items: center;
            margin-bottom: 16px;
            padding-bottom: 16px;
            border-bottom: 1px solid #f1f5f9;
        }
        .popular-post-item:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }
        .popular-post-thumb {
            width: 70px;
            height: 70px;
            border-radius: 12px;
            object-fit: cover;
            margin-right: 16px;
        }
        .popular-post-title {
            font-size: 15px;
            font-weight: 600;
            color: #1e293b;
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            transition: color 0.3s;
        }
        .popular-post-title:hover {
            color: var(--primary);
        }
        /* Sticky Share Bar */
        .sticky-share-bar {
            display: flex;
            gap: 12px;
            margin-top: 32px;
            padding-top: 24px;
            border-top: 1px solid #e2e8f0;
        }
        .share-btn-circle {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f1f5f9;
            color: #64748b;
            transition: all 0.3s;
            cursor: pointer;
        }
        .share-btn-circle:hover {
            background: var(--primary);
            color: #ffffff;
            transform: translateY(-2px);
        }
    </style>
@endpush

@section("content")

    <div class="container blog-editorial-container pb-120">
        <div class="row">
            
            {{-- Main Column --}}
            <div class="col-12 col-lg-8 pr-lg-32">
                
                {{-- Header (Title & Meta) --}}
                @include('design_1.web.blog.show.includes.header')

                {{-- Hero Cover Image --}}
                <div class="blog-hero-image-wrapper">
                    <img src="{{ $post->image }}" alt="{{ $post->title }}">
                </div>

                {{-- Social Share (Inline Top) --}}
                <div class="sticky-share-bar d-flex align-items-center mb-32">
                    <span class="font-14 font-weight-bold text-gray-500 mr-8">{{ trans('public.share') }}:</span>
                    <div class="js-share-post share-btn-circle" data-path="/blog/{{ $post->slug }}/share-modal">
                        <x-iconsax-lin-share class="icons" width="20px" height="20px"/>
                    </div>
                </div>

                {{-- Lead Paragraph --}}
                @if(!empty($post->description))
                <div class="blog-editorial-lead">
                    {!! nl2br($post->description) !!}
                </div>
                @endif

                {{-- Post content --}}
                <div class="blog-editorial-content">
                    {!! nl2br($post->content) !!}
                </div>

                {{-- Author Info Box --}}
                <div class="mt-40">
                    @include('design_1.web.blog.show.includes.author_info')
                </div>

                {{-- Suggested Post --}}
                <div class="mt-40">
                    @include('design_1.web.blog.show.includes.suggested_post')
                </div>

                {{-- Comments --}}
                @if($post->enable_comment)
                    <div class="mt-40">
                        @include('design_1.web.blog.show.includes.comments')
                    </div>
                @endif

            </div>

            {{-- Sidebar Column --}}
            <div class="col-12 col-lg-4 mt-40 mt-lg-0">
                <div class="blog-sidebar-sticky">
                    
                    {{-- Search Widget --}}
                    <div class="blog-sidebar-widget">
                        <h3 class="blog-sidebar-widget-title">{{ trans('public.search') }}</h3>
                        <form action="/blog" method="get">
                            <div class="form-group mb-0 position-relative">
                                <input type="text" name="search" class="form-control" placeholder="Search..." style="padding-right: 45px;">
                                <button type="submit" class="bg-transparent border-0 position-absolute" style="right: 15px; top: 12px; color: #a0aec0;">
                                    <x-iconsax-lin-search-normal-1 width="18px" height="18px"/>
                                </button>
                            </div>
                        </form>
                    </div>

                    {{-- Categories Widget --}}
                    @if(!empty($blogCategories) and count($blogCategories))
                    <div class="blog-sidebar-widget">
                        <h3 class="blog-sidebar-widget-title">{{ trans('public.categories') }}</h3>
                        <div class="d-flex flex-wrap">
                            @foreach($blogCategories as $category)
                                <a href="{{ $category->getUrl() }}" class="sidebar-category-pill">
                                    {{ $category->title }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    {{-- Popular Posts Widget --}}
                    @if(!empty($popularPosts) and count($popularPosts))
                    <div class="blog-sidebar-widget">
                        <h3 class="blog-sidebar-widget-title">{{ trans('home.popular_posts') }}</h3>
                        <div class="popular-posts-list">
                            @foreach($popularPosts as $popularPost)
                                <a href="{{ $popularPost->getUrl() }}" class="popular-post-item">
                                    <img src="{{ $popularPost->image }}" alt="{{ $popularPost->title }}" class="popular-post-thumb">
                                    <div class="flex-1">
                                        <h4 class="popular-post-title">{{ $popularPost->title }}</h4>
                                        <div class="d-flex align-items-center mt-8 text-gray-400 font-12">
                                            <x-iconsax-lin-calendar-2 width="14px" height="14px" class="mr-4"/>
                                            <span>{{ dateTimeFormat($popularPost->created_at, 'j M Y') }}</span>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

    {{-- Fixed Bottom (mobile sharing etc) --}}
    @include('design_1.web.blog.show.includes.fixed_bottom')

@endsection

@push('scripts_bottom')
    <script>
        var closeLang = '{{ trans('public.close') }}';
        var shareLang = '{{ trans('public.share') }}';
        var reportCommentLang = '{{ trans('update.report_comment') }}';
        var reportLang = '{{ trans('panel.report') }}';
    </script>

    <script src="/assets/default/vendors/swiper/swiper-bundle.min.js"></script>
    <script src="{{ getDesign1ScriptPath("swiper_slider") }}"></script>

    <script src="{{ getDesign1ScriptPath("comments") }}"></script>
    <script src="{{ getDesign1ScriptPath("show_blog") }}"></script>
@endpush
