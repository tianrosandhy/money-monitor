@extends ('core::layouts.master')

@section ('content')

	@include ('core::components.header-box')
    @include ('wallet::partials.global-alert')

    <p class="mb-4">Berikut ini adalah data record balance wallet Anda per tanggal <strong class="date-wallet">{{ date('d M Y') }}</strong></p>

    @if(isset($total_wallet['total']))
    <div class="row">
        <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="card card-body">
                <strong>Total Money</strong>
                <h4 class="my-0">IDR {{ number_format($total_wallet['total']) }}</h4>
            </div>
        </div>
    </div>
    @endif

    <div class="content-box">
        @foreach($wallets as $category => $wallet)
        <div class="card">
            <div class="card-header bg-secondary text-white">
                <div class="float-left">
                    {{ strtoupper($category) }} 
                </div>
                <div class="float-right">
                    @if(isset($total_wallet['category'][$category]))
                    <span class="badge bg-white text-dark">{{ 'IDR '. number_format($total_wallet['category'][$category]) }}</span>
                    @endif
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    @foreach($wallet as $wall)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            @if($wall['wallet_type'] == 'credit')
                            <i title="Credit" data-feather="plus" class="text-success"></i>
                            @else
                            <i title="Debit" data-feather="minus" class="text-danger"></i>
                            @endif
                            <strong>{{ $wall['title'] }}</strong> 
                            <em class="d-none d-sm-inline"><small>{{ strlen($wall['description']) > 0 ? ( strlen($wall['description']) > 50 ? ' - ' . substr($wall['description'], 0, 50).'...' : ' - ' . $wall['description'] ) : '' }}</small></em>
                        </div>
                        <div class="btn-group">
                            <span class="btn btn-white btn-sm font-weight-bold" style="min-width:140px; text-align:left;">IDR {{ number_format($wall['balance']) }}</span>
                            <a href="#" class="btn btn-primary btn-sm update-balance" data-wallet="{{ $wall['id'] }}">
                                <i data-feather="edit"></i>
                                <span class="d-none d-md-inline">Update Balance</span>
                            </a>
                        </div>
                    </li>
                    @endforeach
                </ul>            
            </div>
        </div>
        @endforeach
    </div>
@stop

@push ('modal')
    @include ('wallet::partials.update-balance-modal')
@endpush

@push ('script')
    @include ('wallet::partials.record-asset')
@endpush