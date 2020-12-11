@if(count(Language::available()) > 1)
<div class="language-toggle mb-2 text-right">
	@foreach(Language::available() as $code => $name)
	<a href="#" data-lang="{{ $code }}" class="btn btn-success {{ $loop->first ? 'active default' : '' }}" title="{{ $loop->first ? 'Default Language' : '' }}">{{ $name }}</a>
	@endforeach
</div>
<script>
$(function(){
	$(document).on('click', '.language-toggle a[data-lang]', function(e){
		e.preventDefault();
		lang = $(this).attr('data-lang');
		$("form .input-language:not([data-lang='"+lang+"'])").slideUp(250);
		$("form .input-language[data-lang='"+lang+"']").slideDown(250);

		$(".language-toggle a:not([data-lang='"+lang+"'])").removeClass('active');
		$(this).addClass('active');
		$("form label .label-language-holder").html(' (' + lang + ')');
	});
	$(".language-toggle a[data-lang].active").click();
});
</script>
@endif