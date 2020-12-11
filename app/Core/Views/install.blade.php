@extends ('core::layouts.box')
@section ('content')
	<h2>CMS Install</h2>

	@if(!$has_install)
		<p class="lead">Welcome to CMS installation page. Please fill the steps below to complete the CMS installation.</p>
		@if($db)
			<div class="alert alert-danger">
				<strong class="text-uppercase">Database Connection Error</strong>
				<br>
				<p>Manage your database connection in <em><u>.env</u></em> file. Please make sure the database name provided is exists. The problem usually consist within these : </p>
				<ul>
					<li>Invalid database connection in .env</li>
					<li>Database is still not created</li>
					<li>Different database host or port. The default is 127.0.0.1:3306</li>
					<li>You just have a bad luck</li>
				</ul>
			</div>
		@endif
		

		@if(!$db)
			<div class="alert alert-primary">Fill these form below to install the CMS</div>

			<form action="" method="post">
				{{ csrf_field() }}
				<div class="form-group">
					<label>Default Admin Full Name  *</label>
					<input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Your Name">
				</div>
				<div class="form-group">
					<label>Default Admin Email *</label>
					<input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="your@email.com">
				</div>

				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label>Default Admin Password *</label>
							<input type="password" name="password" class="form-control">
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label>Admin Password Confirmation *</label>
							<input type="password" name="password_confirmation" class="form-control">
						</div>
					</div>
				</div>
				<button class="btn btn-primary">Run Installation</button>
			</form>
		@endif

		<br>
	@else
	<div class="alert alert-info">The CMS has been installed.</div>
	<a href="{{ url('/') }}" class="btn btn-primary">Go To Homepage</a>
	<a href="{{ admin_url('/') }}" class="btn btn-success">Go To Admin Panel</a>
	@endif
@stop