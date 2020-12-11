@extends ('core::layouts.box')
@section ('content')
	<h6 class="h5 mb-0 mt-4">{{ $title }}</h6>
	<p class="text-muted mt-1 mb-4">Just one step again before you can access your account. <br>Please type your new password below</p>

	<div class="form-group">
		<label class>Your Email</label>
		<input readonly type="text" class="form-control" disabled value="{{ $user->email }}">
	</div>
	<form action="" method="post">
		{{ csrf_field() }}
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group">
					<label>Your New Password</label>
					<input type="password" name="password" class="form-control" maxlength="50">
				</div>
			</div>
			<div class="col-sm-6">
				<div class="form-group">
					<label>Repeat New Password</label>
					<input type="password" name="password_confirmation" class="form-control" maxlength="50">
				</div>
			</div>
		</div>

		<button type="submit" class="btn btn-primary">
			<i data-feather="save"></i> Save New Password
		</button>
	</form>
@stop