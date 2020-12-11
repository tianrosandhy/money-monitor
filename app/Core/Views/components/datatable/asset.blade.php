<link rel="stylesheet" href="{{ admin_asset('libs/datatables/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ admin_asset('libs/datatables/responsive.bootstrap4.min.css') }}">
<script type="text/javascript" src="{!! admin_asset('libs/datatables/jquery.dataTables.min.js') !!}"></script>
<script type="text/javascript" src="{!! admin_asset('libs/datatables/extensions/dataTables.responsive.min.js') !!}"></script>

<script>
var tb_data;
$(function(){
	//fixing bug err 500 on first load
	setTimeout(function(){
		tb_data = $("table.datatable").DataTable({
			'processing': true,
			'serverSide': true,
			'autoWidth' : false,
			'searching'	: false,
			'filter'	: false,
			'stateSave'	: true,
			'ajax'		: {
				type : 'POST',
				url	: '{{ $skeleton->route() }}',
				dataType : 'json',
				data : function(data){
					{!! $skeleton->generateSearchQuery() !!}
					data._token = window.CSRF_TOKEN
				},
			},
			createdRow: function( row, data, dataIndex ) {
		        // Set the data-status attribute, and add a class
		        $( row ).addClass('close-target');
		    },

			"drawCallback": function(settings) {
		        initPlugins();
			},
			'columns' : [
				{!! $skeleton->datatableColumns() !!}
			],
			'columnDefs' : [
				{!! $skeleton->datatableOrderable() !!}
			],
			"aaSorting": [{!! $skeleton->datatableDefaultOrder() !!}],
		});

	}, 500);


	$(".search-box input, .search-box select").on('change', function(){
		$(".reset-filter").fadeIn();
		refreshDataTable();
	});

	$(".reset-filter").on('click', function(e){
		e.preventDefault();
		$(this).closest('.search-box').find('input, select').val('').trigger('change');
		$(this).fadeOut();
	});



	$(document).on('change', '#checker_all_datatable', function(){
		cond = $(this).is(':checked');
		$(".multichecker_datatable").each(function(){
			$(this).prop('checked', cond);
		});
		toggleBatchMode();
	});

	$(document).on('change', '.multichecker_datatable', function(){
		toggleBatchMode();
	});

	$(".multi-delete").on('click', function(e){
		e.preventDefault();
		output = '<p>Are you sure? Once deleted, you will not be able to recover the data</p><button class="btn btn-primary" data-dismiss="modal">Cancel</button> <button class="btn btn-danger" onclick="runRemoveBatch()">Yes, Delete</button>';
		toastr.info(output);
	});

});

function refreshDataTable(){
	tb_data.ajax.reload();
}

function toggleBatchMode(){
	cond = false;
	$(".multichecker_datatable").each(function(){
		if($(this).is(':checked')){
			cond = true;
		}
	});

	if(cond){
		//toggle down
		$(".batchbox").slideDown();
	}
	else{
		//toggle up
		$(".batchbox").slideUp();
		$("#checker_all_datatable").prop('checked', false);
	}
}

function runRemoveBatch(){
	//prepare selected ids
	ids = [];
	$(".multichecker_datatable").each(function(){
		if($(this).is(':checked')){
			ids.push($(this).attr('data-id'));
		}
	});

	if(ids.length > 0){
		$.ajax({
			url : $(".multi-delete").attr('href'),
			type : 'POST',
			dataType : 'json',
			data : {
				_token : window.CSRF_TOKEN,
				list_id : ids
			},
			success : function(resp){
				if(resp.type == 'success'){
					toastr.success(resp.message);
					//refresh datatable
					refreshDataTable();
					$("#checker_all_datatable").prop('checked', false);
					$(".batchbox").slideUp();
				}
				else{
					toastr.error(resp.message);
				}
			},
			error : function(resp){
				toastr.error('Sorry, we cannot process your request now.');
			}
		});			
	}
	else{
		toastr.error('No data selected');
	}


}
</script>