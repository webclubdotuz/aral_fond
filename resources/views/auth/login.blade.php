<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <title>{{ env('APP_NAME') }} - Авторизация</title>
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
                                <a href="/">
                                    {{-- <span><img src="/assets/images/logo.png" alt="logo" height="22"></span> --}}
                                    <h1 class="text-white m-0">{{ config('app.name') }}</h1>
                                </a>
                            </div>

                            <div class="card-body p-4">

                                <div class="text-center w-75 m-auto">
                                    <h4 class="text-dark-50 text-center pb-0 fw-bold">Авторизация</h4>
                                </div>

                                @if ($errors->any())
                                    <div class="toast show align-items-center text-white bg-danger border-0 mb-4" role="alert" aria-live="assertive" aria-atomic="true">
                                        <div class="d-flex">
                                        <div class="toast-body">
                                            @foreach ($errors->all() as $error)
                                                {{ $error }}
                                            @endforeach
                                        </div>
                                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                                        </div>
                                    </div>
                                @endif


                                <form action="{{ route('authenticate') }}" method="POST">
                                    @csrf
                                    <div class="mb-2">
                                        <label for="username" class="form-label">Логин или телефон номер</label>
                                        <input class="form-control" type="text" name="username" id="username" required="" placeholder="Логин или телефон">
                                    </div>

                                    <div class="mb-2">
                                        <label for="password" class="form-label">Пароль</label>
                                        <div class="input-group input-group-merge">
                                            <input type="password" id="password" class="form-control" name="password" placeholder="Введите пароль">
                                            <div class="input-group-text" data-password="false">
                                                <span class="password-eye"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-2">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="checkbox-signin" checked>
                                            <label class="form-check-label" for="checkbox-signin">Запомнить меня</label>
                                        </div>
                                    </div>

                                    <div class="mb-2 mb-0 text-center">
                                        <button class="btn btn-primary" type="submit"><i class="mdi mdi-login"></i> Войти </button>
                                    </div>

                                </form>
                            </div> <!-- end card-body -->
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
            <script>document.write(new Date().getFullYear())</script> © Created by <a href="https://dbc24.uz" class="text-muted">DBC24</a>
        </footer>
        <!-- Vendor js -->
        <script src="/assets/js/vendor.min.js"></script>

        <!-- App js -->
        <script src="/assets/js/app.min.js"></script>
        <script src="{{ asset('vendor/helper.js') }}"></script>

    </body>
</html>
