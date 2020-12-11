<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Server Error - {{ setting('general.title') }}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <link rel="shortcut icon" href="{{ setting('general.favicon', admin_asset('images/logo.png')) }}">
        
        <!-- App css -->
        <link href="{{ admin_asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ admin_asset('css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ admin_asset('css/app.min.css') }}" rel="stylesheet" type="text/css" />
    </head>

    <body class="authentication-bg">

        <div class="account-pages my-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-4 col-lg-5 col-8">
                        <div class="text-center">
                            
                            <div>
                                <img src="{{ admin_asset('images/server-down.png') }}" alt="" class="img-fluid" />
                            </div>
                        </div>

                    </div>
                </div>

                <div class="row">
                    <div class="col-12 text-center">
                        <h3 class="mt-3">Oops, something went wrong</h3>
                        <p class="text-muted mb-5">Server Error 500. We apologise and will fix the problem.<br/> Please try again later.</p>
                        <a href="{{ is_admin_login() ? admin_url('/') : url('/') }}" class="btn btn-lg btn-primary mt-4">Take me back to Home</a>
                    </div>
                </div>
            </div>
            <!-- end container -->
        </div>
        <!-- end account-pages -->

        <script src="{{ admin_asset('js/vendor.min.js') }}"></script>
        <script src="{{ admin_asset('js/app.min.js') }}"></script>
    </body>
</html>