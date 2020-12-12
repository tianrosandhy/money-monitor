<form action="{{ route('admin.wallet-record.store') }}" method="post" class="balance-form">
	{{ csrf_field() }}
	<input type="hidden" name="wallet_id" value="{{ $wallet->id }}">
	<div class="row">
		<div class="col-6">
			<div class="form-group">
				<label>Wallet Name</label>
				<h5 class="my-0 text-uppercase">{{ $wallet->title }}</h5>
			</div>
		</div>
		<div class="col-6">
			<div class="form-group">
				<label class="my-0">Date</label>
				{!! Input::date('tanggal', [
					'attr' => [
						'data-balance-date' => 1,
						'data-maxdate' => date('Y-m-d')
					],
					'value' => $tanggal
				]) !!}
			</div>
		</div>
	</div>

	<div class="form-group">
		<label>Old Balance</label>
		<h5 class="my-0">IDR <span balance="{{ $wallet_balance }}" class="wallet-balance-per-date">{{ number_format($wallet_balance) }}</span></h5>
	</div>

	<div class="row mb-3">
		<div class="col-6">
			<div class="input-group">
				<div class="input-group-prepend">
					<button class="btn btn-success">+</button>
				</div>
				<input type="number" class="form-control" name="plus" placeholder="Addition">
			</div>
		</div>
		<div class="col-6">
			<div class="input-group">
				<div class="input-group-prepend">
					<button class="btn btn-danger">-</button>
				</div>
				<input type="number" class="form-control" name="minus" placeholder="Substraction">
			</div>
		</div>
	</div>

	<div class="form-group">
		<label>New Balance</label>
		<div class="input-group">
			<div class="input-group-prepend">
				<div class="input-group-text">IDR</div>
			</div>
			<input type="number" class="form-control nominal" name="nominal" value="0">
		</div>
	</div>

	<button class="btn btn-primary">
		<i data-feather="save"></i> Save Wallet Record
	</button>

</form>
