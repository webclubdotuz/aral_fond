<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <title>Tolegenov CRM</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Tolegenov CRM" name="description" />
        <meta content="DBC24.UZ" name="author" />

        <!-- App favicon -->
        <link rel="shortcut icon" href="/assets/images/favicon.ico">

        <!-- Theme Config Js -->
        <script src="/assets/js/hyper-config.js"></script>

        <!-- App css -->
        <link href="/assets/css/app-saas.min.css" rel="stylesheet" type="text/css" id="app-style" />

        <!-- Icons css -->
        <link href="/assets/css/icons.min.css" rel="stylesheet" type="text/css" />

        @stack('css')

    </head>

    <body>
        <!-- Begin page -->
        <div class="wrapper">


            <!-- ========== Topbar Start ========== -->
                <x-topbar />
            <!-- ========== Topbar End ========== -->

            <!-- ========== Left Sidebar Start ========== -->
                <x-left-sidebar />
            <!-- ========== Left Sidebar End ========== -->


            <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->

            <div class="content-page">
                <div class="content">

                    <!-- Start Content-->
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    @yield('right-button')
                                    <h4 class="page-title">
                                        @yield('title')
                                    </h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        @yield('content')

                    </div> <!-- container -->

                </div> <!-- content -->

                <!-- Footer Start -->
                    <x-footer />
                <!-- end Footer -->

            </div>

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->

        </div>
        <!-- END wrapper -->

        <!-- Theme Settings -->
            <x-theme-settings />

        <!-- Vendor js -->
        <script src="/assets/js/vendor.min.js"></script>

        <!-- App js -->
        <script src="/assets/js/app.min.js"></script>

        @include('sweetalert::alert')
        <script src="{{ asset('vendor/helper.js') }}"></script>
        @stack('js')

    </body>
</html>
