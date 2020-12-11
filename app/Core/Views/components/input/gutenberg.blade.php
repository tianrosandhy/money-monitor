<?php
$base_class = ['form-control'];
if(isset($attr['class'])){
  $class = $attr['class'];
}
if(isset($class)){
  $base_class = array_merge($base_class, $class);
}

if(!isset($attr['hidden'])){
  $attr['hidden'] = 1;
}
if(!isset($attr['data-gutenberg'])){
  $attr['data-gutenberg'] = 1;
}

$cleaned_name = str_replace('[]', '', $name);

if(!isset($multi_language)){
  $multi_language = false;
}
?>
@if($multi_language)
  @foreach(Language::available() as $lang => $langname)
    <?php
    if(strpos($name, '[]') !== false){
      $input_name = str_replace('[]', '['.$lang.'][]', $name);
    }
    else{
      $input_name = $name.'['.$lang.']';
    }
    ?>
    <div class="input-language" data-lang="{{ $lang }}" style="{!! def_lang() == $lang ? '' : 'display:none;' !!}">
      <textarea data-textarea name="{!! $input_name !!}" class="{!! implode(' ', $base_class) !!}" {!! isset($attr) ? array_to_html_prop($attr, ['class', 'type', 'name', 'id']) : null !!}>{!! old($cleaned_name.'.'.$lang, (isset($value[$lang]) ? $value[$lang] : null)) !!}</textarea>
      <span class="feedback"></span>
    </div>
  @endforeach
@else
  <textarea data-textarea name="{!! $name !!}" class="{!! implode(' ', $base_class) !!}" {!! isset($attr) ? array_to_html_prop($attr, ['class', 'type', 'name', 'id']) : null !!}>{!! old($cleaned_name, (isset($value) ? $value : null)) !!}</textarea>
  <span class="feedback"></span>
@endif
