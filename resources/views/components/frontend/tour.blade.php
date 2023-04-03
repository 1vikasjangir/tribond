@foreach($videoTours as $tour)
    <div class="virtual_tour_slide">
        @php
            $zipName = explode('.zip', $tour->url);
        @endphp
        <a href="{{ $zipName[0] }}/index.html" target="_blank">
            <div class="virtual_tour_bg">
                <picture>
                    <source media="(max-width: 360px)" srcset="https://dd63psqcl1xsv.cloudfront.net/vr/thumbnails/mobile/{{ $tour->thumbnail }}" alt="" loading="lazy">
                    <img src="https://dd63psqcl1xsv.cloudfront.net/vr/thumbnails/{{ $tour->thumbnail }}" alt="{{ $tour->name }}" loading="lazy">
                </picture>
                <div class="tour_content">
                    <img src="https://dd63psqcl1xsv.cloudfront.net/images/virtual_icon.svg" alt="{{ $tour->name }}" loading="lazy">
                    <h5>{{ $tour->name }}</h5>
                </div>
            </div>
        </a>
</div>
@endforeach
