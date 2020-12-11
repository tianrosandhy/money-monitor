@extends ('core::layouts.master')

@section ('content')
	@include ('core::components.header-box')

    @include ('wallet::partials.global-alert')
    <form class="card card-body report-form">
        <div class="row">
            <div class="col-md-8">
                {!! Input::dateRange('periode[]', [
                    'value' => [
                        $start_date,
                        $end_date
                    ]
                ]) !!}
            </div>
            <div class="col-md-4">
                <button class="btn btn-primary btn-block">Show Report</button>
            </div>
        </div>
    </form>

    @if(empty($report['wallet_report']))
    <div class="alert alert-warning">Oops, there is still no data to be shown. </div>
    @else
    <div class="content-box">
        <div class="card mb-3">
            <div class="card-header bg-secondary text-white">
                Total Wallet Report
            </div>
            <div class="card-body">
                <canvas id="total-wallet-report" style="width:100%; height:300px;"></canvas>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header bg-secondary text-white">
                All Wallets Report
            </div>
            <div class="card-body">
                <canvas id="all-wallet" style="width:100%; height:300px;"></canvas>
            </div>
        </div>

        <div class="row">
            @foreach($report['wallet_report'] as $wallet_id => $wallet_data)
                <?php
                $grab_wallet = $wallets->where('id', $wallet_id)->first();
                ?>
                @if(!empty($grab_wallet))
                <div class="col-sm-4">
                    <div class="card mb-3">
                        <div class="card-header">
                            {{ $grab_wallet->title }} ({{ ucwords($grab_wallet->category) }})
                            @if($grab_wallet->wallet_type == 'credit')
                            <span class="badge badge-success">+</span>
                            @else
                            <span class="badge badge-danger">-</span>
                            @endif
                        </div>
                        <div class="card-body">
                            <canvas id="wallet-report-{{ $wallet_id }}" style="width:100%; height:200px;"></canvas>
                        </div>
                    </div>
                </div>
                @endif
            @endforeach
        </div>
    </div>
    @endif
@stop

@push ('script')
    @if(!empty($report['wallet_report']))
        <script src="{{ admin_asset('libs/chart.js/Chart.min.js') }}"></script>
        <?php
        $total_dataset = [
            [
                'label' => 'Total Balance',
                'borderColor' => '#7E8BE8',
                'backgroundColor' => color_transparent('#7E8BE8', '.15'),
                'data' => array_values($report['total_report'])
            ],
        ];
        foreach($report['category_report'] as $catname => $cdata){
            $color = random_color();
            $total_dataset[] = [
                'label' => 'Total '.ucfirst($catname),
                'borderColor' => $color,
                'backgroundColor' => color_transparent($color, '.15'),
                'data' => array_values($cdata)
            ];
        }
        ?>
        @include ('core::components.analytic.script', [
            'type' => 'line',
            'title' => 'Total Wallet Report',
            'canvas_id' => 'total-wallet-report',
            'label' => array_keys($report['total_report']),
            'dataset' => $total_dataset
        ])

        <?php
        $all_wallets = [];
        ?>
        @foreach($report['wallet_report'] as $wallet_id => $wallet_data)
            <?php
            $grab_wallet = $wallets->where('id', $wallet_id)->first();
            $color = random_color();
            $current_dataset = [
                'label' => $grab_wallet->title,
                'borderColor' => $color,
                'backgroundColor' => color_transparent($color, '.15'),
                'data' => array_values($wallet_data)
            ];
            $all_wallets[] = $current_dataset;
            ?>
            @if(!empty($grab_wallet))
            @include ('core::components.analytic.script', [
                'type' => 'line',
                'title' => $grab_wallet->title,
                'canvas_id' => 'wallet-report-' . $wallet_id,
                'label' => array_keys($wallet_data),
                'dataset' => [
                    $current_dataset
                ]
            ])
            @endif
        @endforeach

        @if(isset($wallet_data))
        @include ('core::components.analytic.script', [
            'type' => 'line',
            'title' => 'All Wallets',
            'canvas_id' => 'all-wallet',
            'label' => array_keys($wallet_data),
            'dataset' => $all_wallets
        ])
        @endif

    @endif
@endpush