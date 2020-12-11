<?php

function model($alias, $param=null){
  //ga pake app(config('model.nama_model')) lagi karena sedikit nambah beban query 

  //translate model alias -> class
  $class_alias = strtolower($alias);
  if(config('model.'.$class_alias)){
    $class_name = config('model.'.$class_alias);
    if($param){
      return new $class_name($param);
    }
    return new $class_name;
  }
  //translate class string -> class object
  if(class_exists($alias)){
    if($param){
      return new $alias($param);
    }
    return new $alias;
  }

  //if the classname or alias not found, throw an error
  throw new Exception('Class alias ' . $alias .' is not exists');
}


function generateAdminRoute($url_name, $controller, $route_name=null){
  $bs_url = $url_name;
  $bs_route = strlen($route_name) > 0 ? $route_name : $url_name;
  $bs_controller = $controller;
  
  include (base_path('app/Core/Routes/autocrud.php'));
}

function setting($hint, $default=''){
  return Setting::get($hint, $default);
}

function admin_url($url=''){
  $prefix = admin_prefix();
  if(strlen($prefix) <= 1){
    return url($url);
  }
  return url($prefix . '/'. $url);
}

function storage_url($path=''){
  return Storage::url($path);
}

function admin_prefix($path=''){
  return config('cms.admin.prefix', 'p4n3lb04rd') . (strlen($path) > 0 ? '/' . $path : '');
}

function api_response($type, $message=''){
  return response()->json([
    'type' => $type,
    'message' => $message
  ]);
}

function ajax_response($type, $message=''){
  return api_response($type, $message);
}


function def_lang(){
  return Language::default();
}

function canSendPushNotif(){
  //push notif can be sent if all .env below is filled
  return env('FCM_SERVER_KEY') && env('FCM_SENDER_ID') && env('FCM_API_KEY') && env('FCM_PROJECT_ID') && env('FCM_APP_ID');
}