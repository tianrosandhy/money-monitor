@include ('core::components.datatable.filter-box')
<div class="card card-body" style="overflow-x:scroll;">
	<table class="table datatable" data-skeleton="{{ $skeleton->name() }}">
		<thead>
			<tr>
				@foreach($skeleton->output() as $row)
					@if(!$row->getHideTable())
					<th data-field="{{ $row->getField() }}" data-orderable="{{ $row->getOrderable() }}"  id="datatable-{{ $skeleton->name() }}-{{ $row->getField() }}">{!! $row->getName() !!}</th>
					@endif
				@endforeach
				<th data-field="action" data-orderable="false" id="datatable-{{ $skeleton->name() }}-action"></th>
			</tr>
		</thead>
		<tbody></tbody>
	</table>
</div>