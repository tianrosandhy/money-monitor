<!DOCTYPE html>
<html lang="en">
    <head>
        @include ('core::layouts.partials.metadata')
    </head>

    <body class="authentication-bg">
        
        <div class="account-pages my-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-8 col-lg-10">
                        <div class="card">
                            <div class="card-body">
                                <div class="mx-auto mb-5">
                                    @include ('core::layouts.include.logo', ['height' => 50])
                                </div>
                                @yield ('content')
                                
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
        @include ('core::layouts.partials.script')
    </body>
</html>