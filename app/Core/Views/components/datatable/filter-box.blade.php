<div class="card card-body collapse" id="searchBox-{{ $skeleton->name() }}">
	<!-- for datatable components -->
	<div class="search-box my-2">
		<div class="row">
			@foreach($skeleton->output() as $row)
				@if($row->getSearchable() && !$row->getHideTable())
				<div class="col-lg-4 col-md-6">
					<div class="form-group">
						<label>Filter {{ $row->getName() }}</label>
						<?php
						$rfield = str_replace('[]', '', $row->getField());
						?>
						@if($row->getDataSource() == 'text')
							@if(in_array($row->getInputType(), ['date', 'daterange', 'datetime']))
								{!! Input::dateRange('datatable_filter['.$rfield.'][]', [
									'attr' => [
										'data-id' => 'datatable-filter-' . $rfield
									]
								]) !!}
							@else
								{!! Input::text('datatable_filter['.$rfield.']', [
									'attr' => [
										'data-id' => 'datatable-filter-' . $rfield
									]
								]) !!}
							@endif
						@else
							<?php
							$source = $row->getDataSource();
							if(is_callable($source)){
								$source = call_user_func($source);
								if($source instanceof \Illuminate\Support\Collection){
									$source = collect()->unwrap($source);
								}
							}
							?>
							@if(is_array($source))
							{!! Input::select('datatable_filter['.$rfield.']', [
								'source' => $source,
								'attr' => [
									'data-id' => 'datatable-filter-' . $rfield
								]
							]) !!}
							@endif
						@endif
					</div>
				</div>
				@endif
			@endforeach
			<div class="col-lg-4 col-md-6">
				<div class="form-group">
					<label style="visibility:hidden">.</label>
					<div>
					<a href="#" class="btn btn-block btn-danger reset-filter" style="display:none;">
						<i data-feather="x"></i>
						Reset Filter
					</a>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>