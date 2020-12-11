<form action="{{ $target }}" method="post">
	{{ csrf_field() }}
	<table class="table">
		<tbody>
			@foreach($all as $group => $data)
				@foreach($data as $title => $list)
				@if($loop->iteration == 1)
				<tr>
					<td colspan="2" style="background-color:#eee;"><strong>{{ $group }}</strong></td>
				</tr>
				@endif
				<tr>
					<td><label>
						<input type="checkbox" class="group-checkbox">
						{{ $title }}
					</label></td>
					<td>
						@foreach($list as $item)
						<div class="priviledge-check">
							<label class="d-block"><input type="checkbox" name="check[]" value="{{ $item }}" {{ in_array($item, $checked) ? 'checked' : '' }}><?php
								//penamaan yg dimunculkan ambil explode terakhir aja
								$exp = explode('.', $item);
								$nm = $exp[(count($exp)-1)];
								echo $nm;
							?></label>
						</div>
						@endforeach
					</td>
				</tr>
				@endforeach
			@endforeach
		</tbody>
	</table>
	<div class="padd">
		<button class="btn btn-primary">Save Permission Data</button>
	</div>
</form>
<script>
$(function(){
	groupCheckCondition();
	loadCheckEvent();
});
</script>