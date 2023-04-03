<!-- partial:partials/_navbar.html -->
<nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex align-items-top flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
        <div class="me-3">
            <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-bs-toggle="minimize">
                <span class="icon-menu"></span>
            </button>
        </div>
        <div>
            <a class="navbar-brand brand-logo" href="{{ route('dashboard') }}">
                <img src="https://dd63psqcl1xsv.cloudfront.net/images/logo.svg" alt="Biginstore">
            </a>
            <a class="navbar-brand brand-logo-mini" href="{{ route('dashboard') }}">
                <img src="{{ asset('adminlogin/images/favicon.png') }}" alt="Biginstore" />
            </a>
        </div>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-top">

        <ul class="navbar-nav ms-auto">


            <li class="nav-item dropdown">


            </li>
            <li class="nav-item dropdown d-none d-lg-block user-dropdown">
                <a class="nav-link" id="UserDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                    <img class="img-xs rounded-circle" src="https://dd63psqcl1xsv.cloudfront.net/team/James.webp"
                        alt="Profile image"> </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                    <div class="dropdown-header text-center">
                        <div style="width: 41px; height: 40px; margin: 0 auto;">
                            <img class="img-md rounded-circle" style="max-width: 100%;" src="https://dd63psqcl1xsv.cloudfront.net/team/James.webp"
                            alt="Profile image"></div>
                        <p class="mb-1 mt-3 font-weight-semibold">James Boatwright</p>
                    </div>
                    <a class="dropdown-item" href="{{ route('admin.logout') }}"><i
                            class="dropdown-item-icon fa-solid fa-power-off text-primary me-2"></i>Sign Out</a>
                </div>
            </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
            data-bs-toggle="offcanvas">
            <span class="fa-solid fa-bars"></span>
        </button>
    </div>
</nav>
