@push ('style')
<style>
.box-loader{
    position:absolute;
    top:0;
    left:0;
    width:100%;
    height:100%;
    z-index:2;
    display:flex;
    display:-moz-flex;
    justify-content:center;
    align-items:center;
}
.box-loader svg{
    color:#000;
    animation : spin 1s linear infinite;
    -moz-animation : spin 1s linear infinite;
    -webkit-animation : spin 1s linear infinite;
    -ms-animation : spin 1s linear infinite;
}
</style>
@endpush

@section ('content')
    <script src="{{ admin_asset('libs/chart.js/Chart.min.js') }}"></script>
    <form with-loader action="" class="dashboard-form my-4">
        <div class="card card-body">
            <div class="row">
                <div class="col-sm-8">
                    <div class="form-group custom-form-group">
                        <label>Date Filter</label>
                        <?php
                        $period = old('period', request()->period);
                        $period_a = $period[0] ?? date('Y-m-d', strtotime('-7 days'));
                        $period_b = $period[1] ?? date('Y-m-d');
                        ?>
                        {!! Input::dateRange('period', [
                            'value' => [
                                $period_a,
                                $period_b
                            ]
                        ]) !!}
                    </div>
                </div>
                <div class="col-sm-4 d-none">
                    <div class="form-group custom-form-group">
                        <label>Max Data per Table Report</label>
                        <input type="number" name="max_result" class="form-control" min=5 max=50 placeholder="Default : 10" value="{{ old('max_result', request()->max_result) }}">
                    </div>					
                </div>
                <div class="col-sm-4 pt-1">
                    <button class="mt-4 btn btn-primary btn-block" type="submit"><i class="fa fa-filter"></i> Filter Dashboard</button>
                </div>
            </div>

            @if(request()->period)
            <a href="{{ admin_url('/') }}" class="btn btn-block btn-danger"><i class="fa fa-times-circle-o"></i> Reset Filter</a>
            @endif
        </div>
    </form>

    <div class="dashboard-container" style="position:relative; min-height:200px;">
        <div class="box-loader">
            <i class="icon" data-feather="refresh-cw"></i>
        </div>
        <div class="dashboard-holder"></div>
    </div>
@stop

@push ('script')
<script>
$(function(){
    loadDashboard();
    $("[with-loader]").on('submit', function(e){
        e.preventDefault();
        loadDashboard();
    });

});

function loadDashboard(){
    formdata = $(".dashboard-form").serialize();
    $(".dashboard-container .box-loader").show();
    $(".dashboard-container .dashboard-holder").hide();
    
    $.ajax({
        url : window.BASE_URL + '/analytic-dashboard',
        dataType : 'html',
        data  : formdata,
        success : (data) => {
            $(".dashboard-holder").html(data);
            $(".dashboard-container .dashboard-holder").fadeIn();
            $(".dashboard-container .box-loader").hide();
            $("html, body").animate({
                scrollTop : 0
            });
        },
        error : (err) => {
            $(".dashboard-container .box-loader").hide();
            $(".dashboard-container .dashboard-holder").fadeIn();
            toastr.error('Sorry, we cannot contact to the server right now');
        }
    });
}
</script>
@endpush