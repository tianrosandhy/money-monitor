@if(isset($data->id))
<div class="py-2 text-right">
	<a href="#" class="btn btn-info btn-change-password"><i data-feather="key"></i> Change Password</a>
</div>
<script>
$(function(){
	$("[data-crud='password'], [data-crud='password_confirmation']").hide();
	$("[data-crud='password'] input, [data-crud='password_confirmation'] input").attr('type', 'password').val('');
	$(".btn-change-password").on('click', function(e){
		e.preventDefault();
		$(this).slideUp();
		$("[data-crud='password'], [data-crud='password_confirmation']").slideDown();
		$("[data-crud='password'] input, [data-crud='password_confirmation'] input").attr('type', 'password').val('');
	});
});
</script>
@else
<script>
$(function(){
	$("[data-crud='password'] input, [data-crud='password_confirmation'] input").attr('type', 'password').val('');
});
</script>
@endif

<?php
$current_user_sa = $data->role->is_sa ?? null;
?>
@if($current_user_sa)
<script>
$(function(){
	$("[data-crud='role_id']").hide();
});
</script>
@endif