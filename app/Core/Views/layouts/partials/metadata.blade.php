<meta charset="utf-8" />
<title>{{ isset($title) ? $title .' - ' . setting('general.title') : setting('general.title') }}</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />

<link rel="shortcut icon" href="{{ setting('general.favicon', admin_asset('images/logo.png')) }}">

<link href="{{ admin_asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ admin_asset('libs/bootstrap-tagsinput/bootstrap-tagsinput.css') }}" rel="stylesheet" />
<link href="{{ admin_asset('libs/bootstrap-touchspin/jquery.bootstrap-touchspin.css') }}" rel="stylesheet" />
<link href="{{ admin_asset('libs/flatpickr/flatpickr.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ admin_asset('libs/dropzone/dropzone.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ admin_asset('css/icons.min.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="{{ admin_asset('libs/toastr/toastr.min.css') }}">
<link rel="stylesheet" href="{{ admin_asset('libs/select2/select2.min.css') }}">

<link href="{{ admin_asset('css/app.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ admin_asset('libs/switchery/css/switchery.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ admin_asset('css/additional.css') }}" rel="stylesheet" type="text/css" />
<script src="{{ admin_asset('js/vendor.js') }}"></script>

@if(isset($custom_css))
<link rel="stylesheet" href="{{ $custom_css }}">
@endif

@stack ('style')