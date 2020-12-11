<!-- Vendor js -->
<script src="{{ admin_asset('js/app.js') }}"></script>
<script src="{{ admin_asset('libs/toastr/toastr.min.js') }}"></script>
<script src="{{ admin_asset('libs/switchery/js/switchery.min.js') }}"></script>
<script src="{{ admin_asset('libs/bootstrap-tagsinput/bootstrap-tagsinput.min.js') }}"></script>
<script src="{{ admin_asset('libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js') }}"></script>
<script src="{{ admin_asset('libs/select2/select2.min.js') }}"></script>
<script src="{{ admin_asset('libs/flatpickr/flatpickr.min.js') }}"></script>
<script src="{{ admin_asset('libs/flatpickr/monthselect.js') }}"></script>
<script src="{{ admin_asset('libs/tinymce/tinymce.min.js') }}"></script>
<script src="{{ admin_asset('libs/tinymce/jquery.tinymce.min.js') }}"></script>
<script src="{{ admin_asset('libs/jquery-mask/jquery.mask.min.js') }}"></script>
<script src="{{ admin_asset('libs/dropzone/dropzone.min.js') }}"></script>
<script src="{{ admin_asset('js/dropzone-input.js') }}"></script>
<script src="{{ admin_asset('js/additional.js') }}"></script>
<script>
var BASE_URL = '{{ admin_url('/') }}';
var SITE_URL = '{{ url('/') }}';
var STORAGE_URL = '{{ Storage::url('/') }}';
var CSRF_TOKEN = '{{ csrf_token() }}';
var DEFAULT_LANGUAGE = '{{ Language::default() }}';
</script>
@include ('core::layouts.include.error-management')
{!! Media::assets() !!}
@stack ('script')
@yield ('datatable_script')
@if(isset($custom_js))
<script type="text/javascript" src="{{ $custom_js }}"></script>
@endif

@include ('core::layouts.partials.pwa')