<!DOCTYPE html>
<html lang="en" dir="ltr">
{{-- Head tag CSS  --}}
@include('frontend/partials/head-blog')
@stack('styles')

<body {{ request()->routeIs('frontend.home') || request()->routeIs('frontend.home1')? 'home' : 'class=project_page'; }}>
    <div id="sample-dom" style="font-size: 1px;text-align:center;width:100%;color:white;">Welcom to BigInStore</div>
    <script>
        const SITE_URL = '{{ asset('/') }}'
    </script>
   
    @include('frontend/partials/header')

    {{-- Main content --}}
    @yield('content')
    {{-- /.Main Content --}}

    @include('frontend/partials/footer')

    {{-- Scroll to top --}}
    @yield('scrolltotop')
    {{-- /.Scroll to top --}}

    @include('frontend/partials/scripts')
    @stack('scripts')

</body>

</html>
