<?php
$base_class = ['form-control'];
if(isset($attr['class'])){
  $class = $attr['class'];
}
if(isset($class)){
  $base_class = array_merge($base_class, $class);
}

$cleaned_name = str_replace('[]', '', $name);

if(!isset($type)){
  $type = 'text';
}
if($type == 'tags'){
  $type = 'text';
  $attr['data-role'] = 'tagsinput';
}

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
      <input touchspin type="{{ $type }}" name="{!! $input_name !!}" class="{!! implode(' ', $base_class) !!}" {!! isset($attr) ? array_to_html_prop($attr, ['class', 'type', 'name', 'id']) : null !!} value="{{ old($cleaned_name.'.'.$lang, (isset($value[$lang]) ? $value[$lang] : null)) }}" id="input-{{ $cleaned_name }}-{{ $lang }}">
    </div>
  @endforeach
@else
  <input touchspin type="{{ $type }}" name="{{ $name }}" class="{!! implode(' ', $base_class) !!}" {!! isset($attr) ? array_to_html_prop($attr, ['class', 'type', 'name', 'id']) : null !!} id="input-{{ $cleaned_name }}" value="{{ old($cleaned_name, isset($value) ? $value : null) }}">
@endif
