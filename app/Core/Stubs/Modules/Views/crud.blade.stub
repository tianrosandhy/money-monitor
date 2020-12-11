@extends ('core::layouts.master')
@section ('content')
	@include ('core::components.header-box', [
		'control_buttons' => [
			[
				'url' => route('admin.[LOWERCASE_MODULE_NAME].index'),
				'label' => 'Back',
				'icon' => 'arrow-left'
			],
		]
	])

	<form action="" method="post">
		{{ csrf_field() }}
		<?php
		$forms = $skeleton->output();
		$tabs = array_unique(Arr::pluck($forms, 'tab_group'));
		?>
		@if(count($tabs) > 0)
		<div class="card">
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

						if(isset($data->id)){
							$validation_rule = $row->getUpdateValidation();
						}
						else{
							$validation_rule = $row->getCreateValidation();
						}
						?>
						<div class="col-md-{{ $row->getFormColumn() }} col-sm-12">
							<div class="form-group custom-form-group {!! $row->getInputType() == 'radio' ? 'radio-box' : '' !!}">
								<label for="{{ $row->input_attribute['id'] }}" class="{{ strpos($validation_rule, 'required') !== false ? 'required' : '' }}">{{ $row->name }}</label>
								{!! $row->createInput($data) !!}
							</div>
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
			<button type="submit" name="save_only" value="1" class="btn btn-lg btn-success"><i class="fa fa-save"></i> Save</button>
			<button type="submit" class="btn btn-lg btn-primary"><i class="fa fa-save"></i> {{ __('core::module.form.save_and_exit') }}</button>
		</div>

	</form>

@stop