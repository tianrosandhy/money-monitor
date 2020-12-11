<!DOCTYPE html>
<html lang="{{ Language::current() }}">
<head>
	@include ('core::layouts.partials.metadata')
</head>
<body class="left-side-menu-dark">
    <div id="wrapper">
		@include ('core::layouts.partials.header')
		@include ('core::layouts.partials.sidebar')

        <div class="content-page">
            <div class="content">
                <div class="container-fluid mt-3">
                	@yield ('content')
                </div> <!-- container-fluid -->
            </div> <!-- content -->
            @include ('core::layouts.partials.footer')
        </div>
    </div>
    @include ('core::layouts.partials.modal')
    <div id="page-loader">
        <i class="icon" data-feather="refresh-cw"></i>
    </div>
	@include ('core::layouts.partials.script')
</body>
</html>