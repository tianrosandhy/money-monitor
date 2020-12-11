<div class="header-box">
	<div class="pull-left float-left">
		<h2>{{ $title }}</h2>
	</div>
	<div class="pull-right float-right">
		@include ('core::components.breadcrumb')
	</div>
	<div class="clearfix"></div>
	<div class="my-3">
		@if(isset($control_buttons))
			@foreach($control_buttons as $btn)
				@if(isset($btn['label']))
				<a href="{{ $btn['url'] ?? '#' }}" class="btn btn-{{ $btn['type'] ?? 'secondary' }}" {!! isset($btn['attr']) ? array_to_html_prop($btn['attr']) : '' !!}>
					@if(isset($btn['icon']))
					<i class="icon" data-feather="{{ $btn['icon'] }}"></i>
					@endif
					<span>{{ $btn['label'] ?? '-' }}</span>
				</a>
				@endif
			@endforeach
		@endif
		@if(isset($batch_delete_url))
		<div style="display:inline-block;">
			<a href="{{ $batch_delete_url }}" class="btn btn-danger multi-delete batchbox" style="display:none;">
				<i data-feather="x"></i> {{ __('core::module.form.delete_selected') }}
			</a>
		</div>
		@endif
	</div>
</div>
