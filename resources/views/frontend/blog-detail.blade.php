@extends('layouts.frontend')

@section('title')
    {{ $blogDetail->title }}
@endsection
@section('meta_description')
    {{$blogDetail->meta_desc}}
@endsection
@push('styles')
    <x-embed-styles />
@endpush

@section('content')

    <section class="blog_detail_section">
        <div class="bg_text">
            BLOG
        </div>
        <div class="blog_header d-sm-none">
            <h2>BLOG</h2>
        </div>
        <div class="container">
            <div class="blog_detail_outer">
                <div class="blog_detail_content">
                    <a class="backto_blog" href="{{ route('frontend.blog') }}">Back</a>
                    <div class="blog_content">
                        <div class="feature_img">
                            <img src="{{ $blogDetail->image }}" alt="{{ $blogDetail->title }}">
                        </div>
                        <div class="blog_content_box">
                            <h1>{{ $blogDetail->title }}</h1>
                            <div class="posted_by">
                                <p>Posted on <span>{{ date('F d, Y', strtotime($blogDetail->created_at)) }}</span></p>
                                <p>By <span>{{ $blogDetail->author }}</span></p>
                            </div>
                            @php
                                $blogMedia = $blogDetail->getMedia;
                                $totMediaCount = count($blogMedia);
                                $rowClass = "";
                                if($totMediaCount == 2) {
                                    $rowClass = "two_thubnails";
                                }elseif($totMediaCount == 3){
                                    $rowClass = "three_thubnails";
                                }elseif($totMediaCount == 4){
                                    $rowClass = "four_thubnails";
                                }
                            @endphp
                            @if ($blogDetail->media_above_desc == 0)
                                {!! $blogDetail->description !!}
                            @endif

                            @if (optional($blogDetail->getMedia))
                                @if($totMediaCount > 1)
                                    <div class="blog_thubnails {{ $rowClass }}">
                                @endif
                                @foreach ($blogDetail->getMedia as $key => $blogThumbnail)
                                    @if (optional($blogThumbnail)->type == 'image')
                                        <div class="blog_thubnail">
                                            <img src="{{ $blogThumbnail->file }}" alt="{{ $blogThumbnail->file }}">
                                        </div>
                                    @endif
                                @endforeach
                                @if($totMediaCount > 1)
                                    </div>
                                @endif
                            @endif

                            @if ($blogDetail->media_above_desc == 1)
                                {!! $blogDetail->description !!}
                            @endif
                            <div class="next_prev">
                                @if ($previous)
                                    <a class="prev_blog" href="{{ url('frontend-blog-detail', $previous) }}">Previous
                                        Article</a>
                                @endif
                                @if ($next)
                                    <a class="next_blog" href="{{ url('frontend-blog-detail', $next) }}">Next Article</a>
                                @endif
                            </div>
                            <div class="blog_detail_footer">
                                <p></p>
                                <div class="blog_social_share">
                                    {{-- <x-frontend.social-icons type="blog_detail" class="blog_social_share" title="Share on social media" :socialShare="$socialShare"/> --}}
                                    <p>Share on social media</p>
                                    {!! $socialShare !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="blog_detail_right">
                    <aside>
                        <div class="aside_box share_article">
                            <h3>SHARE ARTICLE</h3>
                            {!! $socialShare !!}
                        </div>
                        @if (!$related_posts->isEmpty())
                            <div class="aside_box related_article">
                                <h3>RELATED ARTICLES</h3>
                                <ul>
                                    @foreach ($related_posts as $item)
                                        <li>
                                            <a href="{{ route('frontend.blog.detail', $item->slug) }}">
                                                <img src="{{ $item->image }}" alt="{{ $item->title }}">
                                                <div class="related_article_content">
                                                    <h4>{{ $item->title }}</h4>
                                                </div>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                                <div class="sidebar_next_prev d-flex justify-content-between">
                                    @if ($previous)
                                        <a class="prev_blog" href="{{ url('frontend-blog-detail', $previous) }}">Previous</a>
                                    @endif

                                    @if ($next)
                                        <a class="next_blog" href="{{ url('frontend-blog-detail', $next) }}">Next</a>
                                    @endif
                                </div>
                            </div>
                        @endif

                        @if ( !$topPosts->isEmpty() )
                            <div class="aside_box related_article">
                                <h3>Top ARTICLES</h3>
                                <ul>
                                    @foreach ($topPosts as $item)
                                        <li>
                                            <a href="{{ route('frontend.blog.detail', $item->slug) }}">
                                                <img src="{{ $item->image }}" alt="{{ $item->title }}">
                                                <div class="related_article_content">
                                                    <h4>{{ $item->title }}</h4>
                                                </div>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                                <div class="sidebar_next_prev d-flex justify-content-between">
                                    @if ($previous)
                                        <a class="prev_blog" href="{{ url('frontend-blog-detail', $previous) }}">Previous</a>
                                    @endif

                                    @if ($next)
                                        <a class="next_blog" href="{{ url('frontend-blog-detail', $next) }}">Next</a>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </aside>
                </div>
            </div>
        </div>
        {{-- {{ p($related_posts) }} --}}
        @if (!$related_posts->isEmpty())
            <div class="related_articles">
                <div class="container">
                    <div class="related_article_outer">
                        @foreach ($related_posts as $item)
                            <div class="blog_card">
                                <div class="blog_img">
                                    <img src="{{ $item->image }}" alt="{{ $item->title }}">
                                </div>
                                <div class="blog_content">
                                    <a href="{{ route('frontend.blog.detail', $item->slug) }}">
                                        <h2>{{ strip_tags($item->title) }}</h2>
                                    </a>
                                    {{ strip_tags($item->description) }}
                                    <div class="blog_footer">
                                        <div class="posted_by">
                                            <p>Posted on {{ date('F d, Y', strtotime($blogDetail->created_at)) }}</p>
                                            <p>By {{ $blogDetail->author }}</p>
                                        </div>
                                        <a href="{{ route('frontend.blog.detail', $item->slug) }}" class="blog_btn">Read</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    {{ $related_posts->links() }}
                </div>
            </div>
        @endif
    </section>

    {{-- @include('frontend/section/contact-us') --}}
<!-- 
    <section class="instagram_section" id="instafeed">
    </section> -->
@endsection

@push('scripts')
    @include('frontend/scripts/page-template')
    @include('frontend/scripts/social-share')
@endpush
