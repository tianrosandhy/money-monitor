@extends ('core::layouts.master')
@section ('content')
	@include ('core::components.header-box', [
		'control_buttons' => [
			[
				'url' => $back_url ?? admin_url('/'),
				'label' => 'Back',
				'icon' => 'arrow-left'
			],
		]
	])
	<form action="" method="post" class="pos-rel">
		{{ csrf_field() }}
		@if(isset($skeleton->multi_language))
			@if($skeleton->multi_language)
				@include ('core::components.language-toggle')
			@endif
		@endif

		<?php
		$forms = $skeleton->output();
		$tabs = array_unique(Arr::pluck($forms, 'tab_group'));
		?>

		@if(method_exists($data, 'slugTarget'))
		<div class="card card-body">
			<span>Public URL</span>
			<div class="input-group">
				<div class="input-group-prepend">
					<span class="input-group-text">{{ url('/') }}/</span>
				</div>
				<input slug-master type="text" name="slug_master" class="form-control" placeholder="your-url-slug" readonly data-target="#input-{{ $data->slugTarget()  }}" value="{{ $data->getCurrentSlug() }}" {{ $data->hasSavedSlug() ? 'saved-slug' : '' }}>
				<div class="input-group-append">
					<button type="button" class="btn btn-secondary btn-change-slug">Change Manually</button>
				</div>
			</div>
		</div>
		@endif


		@if(count($tabs) > 0)
		<div class="card mb-0">
			@if(count($tabs) > 1 || isset($seo))
			<ul class="nav nav-tabs" id="myTab" role="tablist">
				@foreach($tabs as $tabname)
					<li class="nav-item">
						<a class="nav-link {{ $loop->first ? 'active' : '' }}" id="{{ slugify($tabname) }}-tab" data-toggle="tab" href="#form-tab-{{ slugify($tabname) }}" role="tab">{{ $tabname }}</a>
					</li>
				@endforeach
				@if(isset($seo))
				<li class="nav-item">
					<a href="#form-tab-seo" class="nav-link" id="seo-tab" data-toggle="tab" role="tab">SEO</a>
				</li>
				@endif
			</ul>
			@endif
		</div>
		<div class="tab-content card" id="myTabContent">
			@foreach($tabs as $tabname)
			<div class="tab-pane card-body fade {{ $loop->first ? 'show active' : '' }}" id="form-tab-{{ slugify($tabname) }}" role="tabpanel">
				<div class="row">
					<?php
					$width = 0;
					?>
					@foreach(collect($forms)->where('tab_group', $tabname) as $row)
						@if($row->getHideForm() == true)
							@php continue; @endphp
						@endif
						<?php
						$width += $row->getFormColumn();
						if($width > 12){ //kalo lebarnya lebih dari 12 kolom, langsung tutup
							$width = 0;
							echo '</div><div class="row">'; //bikin baris baru
						}
						?>
						<div class="col-md-{{ $row->getFormColumn() }} col-sm-12">
							@if($row->getView())
								@if(view()->exists($row->getView()))
									@include ($row->getView())
								@else
									{!! $row->getView() !!}
								@endif
							@else
								<?php
								if(isset($data->id)){
									$validation_rule = $row->getUpdateValidation();
								}
								else{
									$validation_rule = $row->getCreateValidation();
								}
								?>
								<div class="form-group custom-form-group {!! $row->getInputType() == 'radio' ? 'radio-box' : '' !!}" data-crud="{{ $row->getField() }}">
									<label for="{{ $row->input_attribute['id'] }}" class="{{ strpos($validation_rule, 'required') !== false ? 'required' : '' }}">
										{{ $row->name }}
										<span class="label-language-holder text-uppercase"></span>
									</label>
									{!! $row->createInput($data, ($skeleton->multi_language ?? false)) !!}
								</div>
							@endif
						</div>
						<?php
						if($width == 12){
							$width = 0;
							echo '</div><div class="row">'; //bikin baris baru
						}
						?>
					@endforeach
				</div>
			</div>
			@endforeach
			@if(isset($seo))
			<div class="tab-pane fade" id="form-tab-seo" role="tabpanel">
				{!! $seo !!}
			</div>
			@endif
		</div>			
		@endif


		<div class="save-buttons">
			<button type="submit" class="btn btn-lg btn-primary"><i data-feather="save"></i> {{ __('core::module.form.save_and_exit') }}</button>
		</div>

	</form>

@stop