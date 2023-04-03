<footer class="site_footer">
    <div class="container">
        <div class="footer_menus">
            <div class="footer_widget">
                <h3 class="d-block">CONTACT US</h3>
                <div class="widget_box">
                    <p>Phone number:</p>
                    <a href="tel:090244 76960">090244 76960</a>
                </div>
                <a href="mailto:info@tribondinfosystem.com">info@tribondinfosystem.com</a>
                <div class="follow_us d-sm-block d-none">
                    <h4>Follow us on</h4>
                    <ul>
                        <li>
                            <a href="https://www.instagram.com/big_instore" target="_blank" aria-label="instagram"><img src="https://dd63psqcl1xsv.cloudfront.net/images/insta.svg" alt="Instagram"> </a>
                        </li>
                        <li>
                            <a href="https://www.linkedin.com/" target="_blank" aria-label="linkdin"><img src="https://dd63psqcl1xsv.cloudfront.net/images/in.svg" alt="Linkedin"> </a>
                        </li>
                        <li>
                            <a href="https://www.tiktok.com/" target="_blank" aria-label="tiktok"><img src="https://dd63psqcl1xsv.cloudfront.net/images/tick_tok.svg" alt="Tiktok" loading="lazy"> </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="footer_widget">
                <h3>ADDRESS</h3>
                <div class="address_box">
                    <h4>OFFICE</h4>
                    <p>Plot No-72, New Grain Mandi, Kota, Rajasthan 324007</p>
                </div>
                <!-- <div class="address_box">
                    <h4>LONDON OFFICE</h4>
                    <p>Tallis House, 2 Tallis St, Blackfriars, <br/>London EC4Y 0AB</p>
                </div> -->
            </div>
            <div class="follow_us d-sm-none d-block">
                <ul>
                    <li>
                        <a href="https://www.instagram.com/big_instore" aria-label="instagram"><img src="https://dd63psqcl1xsv.cloudfront.net/images/insta.svg" alt="Instagram"> </a>
                    </li>
                    <li>
                        <a href="https://www.linkedin.com/" aria-label="linkdin"><img src="https://dd63psqcl1xsv.cloudfront.net/images/in.svg" alt="Linkedin"> </a>
                    </li>
                    <li>
                        <a href="https://www.tiktok.com/" aria-label="tiktok"><img src="https://dd63psqcl1xsv.cloudfront.net/images/tick_tok.svg" alt="tiktok" loading="lazy"> </a>
                    </li>
                </ul>
            </div>
            <div class="footer_widget">
                <h3>SITE PAGES</h3>
                <ul>
                    <li {{ currentMenuItem('frontend.pos') }}>
                        <a href="{{ route('frontend.pos') }}">POINT OF PURCHASE</a>
                    </li>
                    <li {{ currentMenuItem('frontend.projects') }}>
                        <a href="{{ route('frontend.projects') }}">PROJECTS</a>
                    </li>
                    <li {{ currentMenuItem('frontend.blog') }}>
                        <a href="{{ route('frontend.blog') }}">BLOG</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="copy_right">
            <p><?php echo date("Y") ?> All rights reserved by Boatwright & Egan Ltd trading as BigInstore</p>
        </div>
    </div>
</footer>
<?php if(!isset($_COOKIE['acceptCookies']) || $_COOKIE['acceptCookies'] == 0){ ?>
<div class="cookies_bar">
    <div class="container">
      <div class="cookies_content">
        We use cookies to give you the best experience possible. Check our <a href="{{ route('frontend.privacy') }}" target="_blank"> Privacy Policy</a>
      </div>
      <div class="cookies_btn">
          <button class="btn_primary accept-cokkie">Accept</button>
      </div>
      <button type="button" class="btn_close cookie-btn" aria-label="close">
        <span></span>
        <span></span>
    </button>
    </div>

  </div>
<?php } ?>
