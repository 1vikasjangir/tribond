@extends('layouts.frontend')

@section('title')
    Blog || BigInStore
@endsection

@section('content')

    <section class="blog_section">
        <div class="bg_text">
            BLOG CATEGORY
        </div>
        <div class="blog_header d-sm-none">
            <h1>BLOG CATEGORY</h1>
        </div>
        <div class="container">
            <div class="blog_outer">
                <div class="blog_listing">
                    <div class="flter_top d-none d-sm-flex">
                        <h1>BLOG CATEGORY</h1>
                        <div class="button-group filters-button-group">
                            <button class="button is-checked" data-filter="*">ALL POSTS</button>
                            @foreach ($categories as $cat)
                                <button class="button" data-filter=".{{ $cat->title }}">{{ strtoupper($cat->title) }}</button>
                            @endforeach
                        </div>
                    </div>
                    <div class="grid">
                        @foreach($categories as $category)
                            @foreach($category->posts as $post)
                                <div class="element-item">
                                    <div class="blog_card">
                                        <div class="blog_img">
                                            <img src="{{ $post->image }}" alt="{{ $post->title }}">
                                        </div>
                                        <div class="blog_content">
                                            <a href="{{ route('frontend.blog.detail', $post->id) }}"><h2>{{ $post->title }}</h2></a>
                                            <p>{!! Str::limit(strip_tags($post->description), 140) !!}</p>
                                            <div class="blog_footer">
                                                <div class="posted_by">
                                                    <p>Posted on {{ date('F d, Y', strtotime($post->created_at)) }}</p>
                                                    <p>By {{ $post->author }}</p>
                                                </div>
                                                <a href="{{ route('frontend.blog.detail', $post->id) }}" class="blog_btn">Read</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endforeach
                    </div>
                    {{-- {{ $category->posts->links() }} --}}
                </div>

                <div class="blog_right">
                    <aside>
                        <form method="GET" action="{{ route('frontend.blog') }}">
                            @csrf
                            <div class="search_box">
                                <input type="search" placeholder="Search" id="q" name="q" value={{ request()->get('q', '') }}>
                            </div>
                        </form>
                        <div class="aside_menu_box">
                            <h3>CATEGORY</h3>
                            <ul>
                                @foreach ($categoryList as $cat)
                                    <li><a href="{{ route('frontend.blog.category', $cat->id) }}">{{ ucfirst($cat->title) }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="aside_menu_box top_post">
                            <h3>TOP POSTS</h3>
                            <ul>
                                @foreach ($topPosts as $key => $topPost)
                                    <li><a href="{{ route('frontend.blog.detail', $topPost->id) }}">{{ ucfirst($topPost->title) }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </section>

    @include('frontend/section/contact-us')

    <section class="instagram_section" id="instafeed">
    </section>
@endsection

@push('scripts')
    @include('frontend/scripts/page-template')
@endpush
