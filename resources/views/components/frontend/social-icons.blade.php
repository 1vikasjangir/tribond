<div class="{{ $class }}">
    @if ($type == "sidebar")
        <h3>{{ $title }}</h3>
    @else
        <p>{{ $title }}</p>
    @endif

    <ul>
        <li><a href="https://www.facebook.com/" target="_blank"><img src="{{ $type == "sidebar" ? 'https://dd63psqcl1xsv.cloudfront.net/images/facebook_red.svg' : 'https://dd63psqcl1xsv.cloudfront.net/images/facebook.svg' }}" alt="Facebook"> </a> </li>
        <li><a href="https://www.instagram.com/" target="_blank"><img src="{{ $type == "sidebar" ? 'https://dd63psqcl1xsv.cloudfront.net/images/instagram_red.svg' : 'https://dd63psqcl1xsv.cloudfront.net/images/instagram.svg' }}" alt="Instagram"> </a> </li>
        <li><a href="https://www.linkedin.com/" target="_blank"><img src="{{ $type == "sidebar" ? 'https://dd63psqcl1xsv.cloudfront.net/images/linkedin_red.svg' : 'https://dd63psqcl1xsv.cloudfront.net/images/linkedin.svg' }}" alt="Linkedin"> </a> </li>
        <li><a href="https://www.twitter.com/" target="_blank"><img src="{{ $type == "sidebar" ? 'https://dd63psqcl1xsv.cloudfront.net/images/twitter_red.svg' : 'https://dd63psqcl1xsv.cloudfront.net/images/twitter.svg' }}" alt="Twitter"> </a> </li>
    </ul>
</div>
