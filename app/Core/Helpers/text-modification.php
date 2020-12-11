<?php

function slugify($input, $delimiter='-'){
  $input = preg_replace("/[^a-zA-Z0-9- &]/", "", $input);
  $string = strtolower(str_replace(' ', $delimiter, $input));
  if(strpos($string, '&') !== false){
    $string = str_replace('&', 'and', $string);
  }
  return $string;
}

function prettify($slug, $delimiter='-'){
  return str_replace($delimiter, ' ', $slug);
}

function tagToHtml($tags, $label_class='label-default'){
  $out = explode(',', $tags);
  $html = '';
  foreach($out as $item){
    $html .= '<span class="label '.$label_class.'">'.trim($item).'</span> ';
  }
  return $html;
}

function descriptionMaker($txt, $length=30){
  $txt = strip_tags($txt);
  $pch = explode(' ', $txt);
  $out = '';
  for($i=0; $i<$length; $i++){
    if(isset($pch[$i])){
      $out .= $pch[$i].' ';
    }
  }

  if(count($pch) > $length){
    $out .= '...';
  }

  return $out;
}

function random_color() {
    return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
}

function color_transparent($hex, $opacity=1){
  $colorcode = str_replace('#', '', $hex);
  $r = substr($colorcode, 0, 2);
  $g = substr($colorcode, 2, 2);
  $b = substr($colorcode, 4, 2);
  $ri = hexdec($r);
  $gi = hexdec($g);
  $bi = hexdec($b);
  return 'rgba('.$ri.', '.$gi.', '.$bi.', '.$opacity.')';
}

function array_to_html_prop($arr=[], $ignore_key=[]){
  if(empty($arr)){
    return '';
  }
  $out = '';
  foreach($arr as $key => $value){
    if(is_array($value)){
      $value = implode(' ',$value);
    }
    elseif(is_object($value)){
      $value = json_encode($value);
    }

    if(in_array(strtolower($key), $ignore_key)){
      continue;
    }

    $out.= $key.'="'.$value.'" ';
  }

  return $out;
}
