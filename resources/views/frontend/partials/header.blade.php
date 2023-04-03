<!-- <link rel="stylesheet" href="{{ asset('frontend/css/stylesheet.css') }}" type="text/css" rel="preload"> -->
<header class="site_header">
    <div class="menu_top">
        <div class="container">
            <nav>
                <div class="site_logo">
                    <a href="{{ route('frontend.home') }}">
                        <img src="https://dd63psqcl1xsv.cloudfront.net/images/logo.svg" alt="Biginstore">
                        <img class="white_logo" src="https://dd63psqcl1xsv.cloudfront.net/images/white_logo.svg" alt="Biginstore">
                    </a>
                </div>
                <div class="menu_toggle d-sm-none">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <div class="mobile_menu d-sm-none">
                    <div class="top_menu">
                        <ul>
                            <li {{ currentMenuItem('frontend.home') }}>
                                <a href="{{ route('frontend.home') }}">HOME</a>
                            </li>
                            <li {{ currentMenuItem('frontend.projects') }}>
                                <a href="{{ route('frontend.projects') }}">PROJECTS</a>
                            </li>
                            <li {{ currentMenuItem('frontend.blog') }}>
                                <a href="{{ route('frontend.blog') }}">BLOG</a>
                            </li>
                        </ul>
                    </div>
                    <div class="bottom_menu">
                        <ul class="call_mail">
                            <li><a href="mailto:info@tribondinfosystem.com">E-MAIL US</a></li>
                            <li><a href="tel:090244 76960">CALL US</a></li>
                        </ul>
                        <p>Follow Us On</p>
                        <ul class="mobile_social">
                            <li><a href="https://www.linkedin.com/" target="_blank" aria-label="linkedin"><img src="https://dd63psqcl1xsv.cloudfront.net/images/linkedin_red.svg" alt="Linkedin"> </a> </li>
                            <li><a href="https://www.instagram.com/big_instore" target="_blank" aria-label="instagram"><img src="https://dd63psqcl1xsv.cloudfront.net/images/instagram_red.svg" alt="Instagram"> </a> </li>
                            <li><a href="https://www.tiktok.com/" target="_blank" aria-label="tiktok"><img src="https://dd63psqcl1xsv.cloudfront.net/images/tick_tok_red.svg" alt="TickTok" loading="lazy"> </a> </li>
                        </ul>
                    </div>
                </div>
                <div class="right_nav">
                    <ul>
                        <li {{ currentMenuItem('frontend.home') }}>
                            <a href="{{ route('frontend.home') }}">HOME</a>
                        </li>
                        <li {{ currentMenuItem('frontend.projects') }}>
                            <a href="{{ route('frontend.projects') }}">PROJECTS</a>
                        </li>
                        <li {{ currentMenuItem('frontend.blog') }}>
                            <a href="{{ route('frontend.blog') }}">BLOG</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
    {{-- Bottom header --}}
    {{-- @yield('bottomheader') --}}
    <div class="menu_bottom">
        <div class="container">
            <ul>
                <li>Phone number:<a href="tel:090244 76960">090244 76960</a></li>
                <li>Email:<a href="mailto:info@tribondinfosystem.com">info@tribondinfosystem.com</a></li>
            </ul>
        </div>
    </div>
    {{-- /.Bottom header --}}
</header>
