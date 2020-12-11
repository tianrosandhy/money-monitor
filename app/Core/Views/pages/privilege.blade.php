@extends ('core::layouts.master')
@section ('content')

	@include ('core::components.header-box', [
		'control_buttons' => [
			[
				'url' => admin_url('/'),
				'label' => __('core::module.global.back_to_homepage'),
				'icon' => 'home'
			],
			[
				'url' => '#',
				'label' => 'Create New Privilege',
				'type' => 'primary',
				'icon' => "user",
				'attr' => [
					'data-action' => 'add',
					'data-target' => route('admin.privilege.create')
				]
			]
		]
	])

	<div class="card card-body">
		<table class="table">
			<thead>
				<tr>
					<th>Privilege Name</th>
					<th></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				@foreach($role_structure->role_list as $row)
				<tr class="close-target">
					<td>{{ str_repeat('-', $row['level']) }} {{ $row['label'] }}</td>
					<td>
						@if($row['is_sa'])
						<div>
							<small>This privilege has <strong>all</strong> permission</small>
						</div>
						@else
							<a href="#" data-target="{{ route('admin.privilege.manage', ['id' => $row['id']]) }}" data-action="add" class="btn btn-sm btn-primary">Manage Privileges ({{ count($row['priviledge_list']) }})</a>
						@endif
					</td>
					<td>
						<div class="btn-group">
							@if(!$row['is_sa'])
							<a href="#" data-target="{{ route('admin.privilege.edit', ['id' => $row['id']]) }}" data-action="add" class="btn btn-sm btn-info">Edit</a>
							<a href="{{ route('admin.privilege.delete', ['id' => $row['id']]) }}" class="btn btn-sm btn-danger delete-button">Delete</a>
							@endif
						</div>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
@stop

@push ('modal')
<div class="modal fade" tabindex="-1" role="dialog" id="privilege-crud" data-backdrop="static">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Manage Privilege</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">

			</div>
		</div>
	</div>
</div>
@endpush

@push ('script')
<script>
$(function(){
	$("[data-action='add']").on('click', function(e){
		e.preventDefault();
		loadPrivilegeCrud($(this).attr('data-target'));
	});



	$(document).on('change', '.priviledge-check input[type=checkbox]', function(){
		inputCheckEvent($(this));
		groupCheckCondition();
	});

	$(document).on('change', '.group-checkbox', function(){
		items = $(this).closest('td').next('td').find('.priviledge-check');
		condition = $(this).is(':checked');
		$.each(items, function(){
			$(this).find('input[type=checkbox]').prop('checked', condition).change();
		});
	});

});

function loadCheckEvent(){
	$(".priviledge-check").each(function(){
		input = $(this).find('input[type=checkbox]');
		inputCheckEvent(input);
	});
	groupCheckCondition();
}

function groupCheckCondition(){
	$(".group-checkbox").each(function(){
		items = $(this).closest('td').next('td').find('.priviledge-check');
		cond = true;
		$.each(items, function(){
			cond = cond && $(this).find('input[type=checkbox]').prop('checked');
		});

		if(cond == true){
			$(this).prop('checked', true);
		}
		else{
			$(this).prop('checked', false);
		}
	});
}

function inputCheckEvent(input){
	paren = input.closest('.priviledge-check');
	if(input.is(':checked')){
		paren.addClass('active');
	}
	else{
		paren.removeClass('active');
	}
}


function loadPrivilegeCrud(target){
	showLoading();
	$.ajax({
		url : target,
		type : 'GET',
		dataType : 'html',
		success : function(resp){
			hideLoading();
			$("#privilege-crud").modal('show');
			$("#privilege-crud .modal-body").html(resp);
			initPlugins();
		},
		error : function(resp){
			error_handling(resp);
		}
	});
}


</script>
@endpush