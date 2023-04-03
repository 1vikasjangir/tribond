
<div class="container">
    <ul>

        @foreach($instagramContent["data"] as $post)
            @php
                $username = isset($post["username"]) ? $post["username"] : "";
                $caption = isset($post["caption"]) ? $post["caption"] : "";
                $media_url = isset($post["media_url"]) ? $post["media_url"] : "";
                $permalink = isset($post["permalink"]) ? $post["permalink"] : "";
                $media_type = isset($post["media_type"]) ? $post["media_type"] : "";
                $thumbnail_url = isset($post["thumbnail_url"]) ? $post["thumbnail_url"] : "";
            @endphp
            <li>
                @if ($media_type=="VIDEO")
                    <video controls poster="{{ $thumbnail_url }}" style='width:100%; display: block !important;'>
                        <source src='{{ $media_url }}' type='video/mp4'>
                        Your browser does not support the video tag.
                    </video>
                @elseif ($media_type=="CAROUSEL_ALBUM")
                    <a href='{{ $permalink }}' target='_blank'>
                        <img class="instagram-img" src='{{ $thumbnail_url }}' alt= '{{ $thumbnail_url }}'/>
                        <i class="fa fa-images"></i>
                    </a>
                @else
                    <a href='{{ $permalink }}' target='_blank'>
                        <img class="instagram-img" src='{{ $thumbnail_url }}' alt= '{{ $thumbnail_url }}' />
                    </a>
                @endif
            </li>
        @endforeach
    </ul>

    {{-- <div class="container" id="instafeed">
        <h2>FOLLOW US ON <a href="#"><img src="https://dd63psqcl1xsv.cloudfront.net/images/insta_icon.svg" alt="Instagram"></a></h2>
    </div> --}}

    <h2>FOLLOW US ON <a href="https://www.instagram.com/big_instore" target="_blank"><img src="https://dd63psqcl1xsv.cloudfront.net/images/insta_icon.svg" alt="Instagram"></a></h2>
    {{-- <h2>FOLLOW US ON <a href="{{ route('frontend.home') }}#footer_links" target="_blank"><img src="https://dd63psqcl1xsv.cloudfront.net/images/insta_icon.svg" alt="Instagram"></a></h2> --}}
</div>

@push('scripts')
    {{-- <script type="text/javascript">
        window.INSTAGRAM_TOKEN = `{{ config('services.instagram.instagram_token') }}`;
        const instagramToken = window.INSTAGRAM_TOKEN;
        var userFeed = new Instafeed({
            get: 'user',
            accessToken: instagramToken,
            resolution: 'low_resolution',
            useHttp: "true",
            target: "instafeed",
            // after: function() {
            // // disable button if no more results to load
            //     if (!this.hasNext()) {
            //         btnInstafeedLoad.setAttribute('disabled', 'disabled');
            //     }
            // },
        });
        userFeed.run();

        // var btnInstafeedLoad = document.getElementById("instafeed-load-more");
        // btnInstafeedLoad.addEventListener("click", function() {
        //     userFeed.next()
        // });
    </script> --}}

    {{-- template:'<div class="container"><ul><li><img src="{{ image }}" alt=""></li></ul></div>', --}}

@endpush
