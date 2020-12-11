<script>
var tb_data;
var in_progress = false;
var has_pending_progress = false;
$(function(){
    setTimeout(function(){
        loadCustomDatatable();
    }, 500);

    $(".custom-datatable-filter, .search-box input, .search-box select").on('change', function(){
        setTimeout(function(){
            $("#{{ $skeleton->getSkeletonName() }}-page").val(1);
            loadCustomDatatable();
        }, 100);
    });

    $(document).on('click', '.custom-pagination a.page-link', function(){
        $("#{{ $skeleton->getSkeletonName() }}-page").val($(this).attr('data-page'));
        loadCustomDatatable();
    });

	$(".search-box input, .search-box select").on('change', function(){
		$(".reset-filter").fadeIn();
	});

	$(".reset-filter").on('click', function(e){
		e.preventDefault();
		$(this).closest('.search-box').find('input, select').val('').trigger('change');
		$(this).fadeOut();
	});

    $('#{{ $skeleton->getSkeletonName() }}-perpage').on('change', function(e){
        current_perpage = parseInt($(this).val());
        if(isNaN(current_perpage)){
            $(this).val($(this).attr('min')).trigger('change');
        }
        if(current_perpage > parseInt($(this).attr('max'))){
            e.preventDefault();
            $(this).val($(this).attr('max')).trigger('change');
        }
        if(current_perpage < parseInt($(this).attr('min'))){
            e.preventDefault();
            $(this).val($(this).attr('min')).trigger('change');
        }
        $("#{{ $skeleton->getSkeletonName() }}-page").val(1);
    });
});

function loadCustomDatatable(){
    if(window.in_progress){
        window.has_pending_progress = true;
        return; //dont load anything when still in progress
    }

    window.in_progress = true;
    objTarget = $("#{{ $skeleton->getSkeletonName() }}");
    objTarget.addClass('in-progress');
    send_data = {!! $skeleton->generateJsonSearchQuery() !!};
    dlength = parseInt($("#{{ $skeleton->getSkeletonName() }}-perpage").val());
    page = parseInt($("#{{ $skeleton->getSkeletonName() }}-page").val());
    send_data.page = page;
    send_data.start = (page - 1) * dlength;
    send_data.length = dlength;
    send_data.order = [{
        column : $("#{{ $skeleton->getSkeletonName() }}-sortby").val(),
        dir : $("#{{ $skeleton->getSkeletonName() }}-sortdir").val()
    }];
    send_data._token = window.CSRF_TOKEN;

    $.ajax({
        url : '{{ $skeleton->route() }}',
        type : 'POST',
        dataType : 'json',
        data : send_data,
        success : function(resp){
            window.in_progress = false;
            if(resp.error){
                toastr['error'](resp.error);
                objTarget.removeClass('in-progress');
            }
            else{
                objTarget.html(resp.html);
                objTarget.prev('.custom-pagination').html(resp.pagination);
                objTarget.next('.custom-pagination').html(resp.pagination);
                if(window.has_pending_progress){
                    window.has_pending_progress = false;
                    loadCustomDatatable();
                }
                else{
                    objTarget.removeClass('in-progress');
                    refreshPlugins();
                }
            }
        },
        error : function(resp){
            window.in_progress = false;
            objTarget.removeClass('in-progress');
            toastr['error']('Sorry, we cannot process your request right now because of Server Error');
        }
    });
}
</script>