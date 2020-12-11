@if($wallet_count == 0)
<div class="alert alert-warning">You need to make at least 1 wallet to start using this application. <br><a href="{{ route('admin.wallet.create') }}" class="btn btn-secondary">Create Master Wallet Data</a></div>
@endif
