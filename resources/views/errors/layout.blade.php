<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <title>Error 404</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />

        <!-- App favicon -->
        <link rel="shortcut icon" href="/assets/images/favicon.ico">

        <!-- Theme Config Js -->
        <script src="/assets/js/hyper-config.js"></script>

        <!-- App css -->
        <link href="/assets/css/app-saas.min.css" rel="stylesheet" type="text/css" id="app-style" />

        <!-- Icons css -->
        <link href="/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    </head>

    <body class="authentication-bg">

        <div class="account-pages pt-2 pt-sm-5 pb-4 pb-sm-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xxl-4 col-lg-5">
                        <div class="card">
                            <!-- Logo -->
                            <div class="card-header py-4 text-center bg-primary">
                                <a href="index.html">
                                    <span><img src="/assets/images/logo.png" alt="logo" height="22"></span>
                                </a>
                            </div>

                            @yield('content')

                        </div>
                        <!-- end card -->
                    </div> <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end page -->

        <footer class="footer footer-alt">
            <script>document.write(new Date().getFullYear())</script> © Created by <a href="https://dbc24.uz" class="text-black-50 ml-1">DBC24.UZ</a>
        </footer>
        <!-- Vendor js -->
        <script src="/assets/js/vendor.min.js"></script>

        <!-- App js -->
        <script src="/assets/js/app.min.js"></script>

    </body>
</html>
