<!DOCTYPE html>
<html lang="en">

    @include('admin/includes/head')
    @stack('styles')

    <body>
        <div class="container-scroller">

            @include('admin/includes/header')

                <div class="container-fluid page-body-wrapper">

                    {{-- @include('admin/includes/setting-panel') --}}

                    @include('admin/includes/sidebar')

                    <!--- Main content wrapper --->
                    <div class="main-panel">

                        <!--- Inner content wrapper --->
                        <div class="content-wrapper">
                            @yield('content')
                        </div>
                        <!--- /. Inner content wrapper --->

                        @include('admin/includes/footer')
                    </div>
                    <!--- /.Main content wrapper --->

                </div>
        </div>

        @include('admin/includes/scripts')
        @stack('scripts')

    </body>
</html>
