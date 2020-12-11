@if(isset($analytic->error))
<div class="alert alert-danger">
    <strong>Google Analytic Fatal Error</strong> : {{ $analytic->error }}
    <br>
    <a href="#" class="btn btn-secondary btn-sm" data-toggle="collapse" data-target=".ga-helper">Show Help</a>
</div>
<div class="collapse ga-helper bg-white p-3">
    <p><strong>Please make sure important things to do below : </strong></p>
    <ol style="font-size:1.1rem">
        <li style="margin-bottom:.75em">
            You need to set the right <strong>ANALYTICS_VIEW_ID in .env</strong> based on your targetted dashboard View ID<br>
            (Check in : Google Analytic Dashboard >> Admin >> View Settings)<br>
            <img src="{{ admin_asset('images/dashboard-help-01.jpg') }}" style="max-width:100%">
        </li>
        <li style="margin-bottom:.75em">
            Check the <strong>client_email</strong> in <strong>{{ config('analytics.service_account_credentials_json') }}</strong>. Make sure that the email in service account is have the read access in your targeted Google Analytic.<br>
            (Check in : Google Analytic Dashboard >> Admin >> View User Management)<br>
            <img src="{{ admin_asset('images/dashboard-help-02.jpg') }}" style="max-width:100%">
            <br>
        </li>
        <li style="margin-bottom:.75em">
            Last, you can <a href="https://console.cloud.google.com/iam-admin/serviceaccounts/create" target="_blank" class="text-dark font-weight-bold" style="text-decoration:underline!important;">generate new service account</a> and replace the file in <strong>{{ config('analytics.service_account_credentials_json') }}</strong> if you cannot do all steps above.
            <br>
        </li>
    </ol>
</div>
@elseif(isset($analytic->report))

    @if(isset($analytic->report['ranged']))
    <div class="card mt-3">
        <div class="card-header bg-secondary text-white">
            Pageview & Visitor Report {{ $period_string }}
        </div>
        <div class="card-body">
            <div style="position:relative; width:100%; height:300px" height="300">
                <canvas class="mb-5" id="analytic-ranged-pageview" style="width:100%; height:300px;" ></canvas>
            </div>
        </div>
    </div>
    @endif

    @include ('core::components.analytic.script', [
        'type' => 'line',
        'title' => 'Filtered Date Pageview Report',
        'canvas_id' => 'analytic-ranged-pageview',
        'label' => $analytic->report['ranged']['label'],
        'dataset' => [
            [
                'label' => 'Page View',
                'borderColor' => '#7E8BE8',
                'backgroundColor' => 'rgba(126,139,232, .15)',
                'data' => $analytic->report['ranged']['pageview']
            ],
            [
                'label' => 'Visitors',
                'borderColor' => '#3744A1',
                'backgroundColor' => 'rgba(55,68,161, .15)',
                'data' => $analytic->report['ranged']['visitor']
            ],
        ]
    ])



    <div class="row">
    @if(isset($analytic->report['most_visited']))
        <div class="col-sm-6">
            <div class="card mt-3">
                <div class="card-header bg-secondary text-white">Most Visited Pages {{ $period_string }}</div>
                <div class="card-body" style="overflow-x:scroll">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Title</th>
                                <th>Pageviews</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $total_pageview = 0;
                            ?>
                            @foreach($analytic->report['most_visited'] as $row)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <a target="_blank" href="{{ url($row['url']) }}">{{ $row['pageTitle'] }}</a>
                                </td>
                                <td align="right">{{ number_format($row['pageViews']) }}</td>
                                <?php
                                $total_pageview += $row['pageViews'];
                                ?>
                            </tr>
                            @endforeach
                        </tbody>
                        @if($total_pageview > 0)
                        <tfoot>
                            <tr>
                                <td></td>
                                <td></td>
                                <td align="right"><strong>{{ number_format($total_pageview) }}</strong></td>
                            </tr>
                        </tfoot>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    @endif

    @if(isset($analytic->report['top_landing']))
        <div class="col-sm-6">
            <div class="card mt-3">
                <div class="card-header bg-secondary text-white">Top Landing Page {{ $period_string }}</div>
                <div class="card-body" style="overflow-x:scroll">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Title</th>
                                <th><i class="fa fa-sign-in" title="Entrance"></i></th>
                                <th><i class="fa fa-sign-out" title="Bounce"></i></th>
                                <th><i class="fa fa-percent" title="Bounce Rate"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($analytic->report['top_landing'] as $row)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <a target="_blank" href="{{ url($row['url']) }}">{{ $row['title'] }}</a>
                                </td>
                                <td align="right">{{ number_format($row['entrances']) }}</td>
                                <td align="right">{{ number_format($row['bounces']) }}</td>
                                <td align="right">{{ number_format($row['bounce_rate']) }}%</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
    </div>

@else
<div class="card card-body">
    <p class="lead">To use the Google Analytic Dashboard, please provide the Google Service Account Credentials & Google Analytic View ID.</p>
</div>
@endif