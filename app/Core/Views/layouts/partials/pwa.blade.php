<div id="offline-overlay" style="display:none;"></div>

<!-- service worker offline/online notification -->
<div id="offline-notification" class="online">
  <div class="offline-wrapper bg-danger text-white">
    <div class="container-fluid">
      {{ __('core::module.global.internet_disconnect') }}
    </div>
  </div>
</div>

<!-- <script src="{{ admin_asset('js/service-worker-controller.js') }}"></script> -->
<script>
//   new SW();
  if(navigator){
    var ONLINE_STAT = navigator.onLine ?? false;
  }
  else{
    var ONLINE_STAT = true;
  }
  window.addEventListener('online', (evt) => {
    if(!window.ONLINE_STAT){
      //change to online action
      $("#offline-overlay").fadeOut();
      $("#offline-notification").addClass('online');
    }
    window.ONLINE_STAT = true;
  });
  window.addEventListener('offline', (evt) => {
    if(window.ONLINE_STAT){
      //change to offline action
      $("#offline-overlay").fadeIn();
      $("#offline-notification").removeClass('online');
    }
    window.ONLINE_STAT = false;
  });
</script>