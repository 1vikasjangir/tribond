@extends('layouts.frontend')
@if(empty($slugDetail)) 
    @section('title') 
        The Visual Merchandising News & Tech Blog
    @endsection
    
@section('meta_description', 'The latest tech advancements in the world of visual merchandising. Discover how brands are using innovative point of purchase displays to market their products.')
@else
    @section('title') 
        {{ $slugDetail->meta_title }}
    @endsection
    
@section('meta_description', $slugDetail->meta_desc)
@endif

@section('content')

    <section class="blog_section">
        <div class="bg_text">
            BLOG
        </div>
        <div class="blog_header d-sm-none">
            <h2>BLOG</h2>
        </div>
        <div class="container">
            <div class="blog_outer">
                <div class="blog_listing">
                    <div class="flter_top d-none d-sm-flex">
                        <h1>
                            @if(!empty($slugDetail))
                                {{ $slugDetail->h1 }}
                            @else
                                The Visual Merchandising Blog
                            @endif
                        </h1>
                        <div class="button-group filters-button-group">
                            <button class="button is-checked" data-filter="*">ALL POSTS</button>
                            @foreach ($categories as $cat)
                                <button class="button" data-filter=".{{ $cat->title }}">{{ strtoupper($cat->title) }}</button>
                            @endforeach
                        </div>
                    </div>
                    <div class="grid">
                        @foreach ($blogs as $key => $blog)
                            @php
                                // p($blogs);
                                // die();
                                // getCategories(json_decode($blog->category_id, true));
                                $catIdArr = explode(',', $blog->category_id);
                                $catArr = getCategories($catIdArr);
                                $catArr = implode(' ', $catArr);
                                // p($catArr);
                                // die();
                            @endphp
                            <div class="element-item {{ $catArr }}" data-category="{{ optional($blog->categories)->title }}">
                                <div class="blog_card">
                                    <div class="blog_img">
                                        <img src="{{ $blog->image }}" alt="{{ $blog->title }}">
                                    </div>
                                    <div class="blog_content">
                                        <a href="{{ route('frontend.blog.detail', $blog->slug) }}"><h2>{{ $blog->title }}</h2></a>
                                        <p>{!! Str::limit(strip_tags($blog->description), 140) !!}</p>
                                        <div class="blog_footer">
                                            <div class="posted_by">
                                                <p>Posted on {{ date('F d, Y', strtotime($blog->created_at)) }}</p>
                                                <p>By {{ $blog->author }}</p>
                                            </div>
                                            <a href="{{ route('frontend.blog.detail', $blog->slug) }}" class="blog_btn">Read</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                        @if(!empty($slugDetail))
                            <div class="blog_content_section">
                                @php echo $slugDetail->seo_desc; @endphp
                            </div>
                        @endif
						<!-- <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p> -->
					
                    {{ $blogs->links() }}
                </div>

                <div class="blog_right">
                    <aside>
                        <form method="GET" action="{{ route('frontend.blog') }}">
                            @csrf
                            <div class="search_box">
                                <input type="search" placeholder="Search" id="q" name="q" value={{ request()->get('q', '') }}>
                                <input type="submit" name="search-btn" /> 
                            </div>
                        </form>
                        <div class="aside_menu_box">
                            <h3>CATEGORY</h3>
                            <ul>
                                @foreach ($categories as $cat)
                                    <li><a href="{{ route('frontend.blog', $cat->slug) }}">{{ ucfirst($cat->title) }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="aside_menu_box top_post">
                            <h3>TOP POSTS</h3>
                            <ul>
                                @foreach ($topPosts as $key => $topPost)
                                    <li><a href="{{ route('frontend.blog.detail', $topPost->slug) }}">{{ ucfirst($topPost->title) }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </section>

    @include('frontend/section/contact-us')

    <!-- <section class="instagram_section" id="instafeed">
    </section> -->
@endsection

@push('scripts')
    @include('frontend/scripts/page-template')
@endpush
