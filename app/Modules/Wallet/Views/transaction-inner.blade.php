@include ('wallet::partials.transaction-inner-pagination')

<div class="list-group">
    @foreach($transactions['data'] as $row)
    <div class="list-group-item">
        <a href="#" class="full-link update-balance" data-wallet="{{ $row->wallet_id }}" data-tanggal="{{ date('Y-m-d', strtotime($row->tanggal)) }}"></a>
        <div class="float-left">
            <?php
            $wlt = $wallets->where('id', $row->wallet_id)->first();
            ?>
            @if(isset($wlt->title))
            <span class="badge badge-primary">{{ $wlt->title }}</span>
            @endif
        </div>
        <div class="float-left mx-2">
            <small>{{ date('d M Y', strtotime($row->tanggal)) }}</small>
        </div>
        <div class="float-right">
            <a href="#" class="btn btn-sm btn-danger btn-remove-record" data-id="{{ $row->id }}"><i data-feather="trash"></i> <span class="d-none d-md-inline">Remove This Record</span></a>
        </div>
        <div class="clearfix"></div>
        <h5 class="my-0">IDR {{ number_format($row->nominal) }}</h5>
    </div>
    @endforeach
    @if($transactions['data']->count() == 0)
    <div align="center">
        <img src="{{ admin_asset('images/not-found.png') }}" alt="Data Not Found" style="height:150px;">
        <h5>Oops, there are no transaction data to be shown yet.</h5>
    </div>
    @endif
</div>

@include ('wallet::partials.transaction-inner-pagination')