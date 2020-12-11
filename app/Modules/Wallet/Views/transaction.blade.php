@extends ('core::layouts.master')

@push ('style')
<style>
.list-group .full-link{
    position:absolute;
    top:0;
    left:0;
    width:100%;
    height:100%;
}
.btn-remove-record{
    z-index:2;
    position:relative;
}
</style>
@endpush

@section ('content')
	@include ('core::components.header-box')
    @include ('wallet::partials.global-alert')
    <p>You can check, update, or remove the transaction records below</p>
    <div class="card">
        <div class="card-header bg-primary text-white">
            Transaction Filters
        </div>
        <div class="card-body">
            <form class="transaction-form">
                <div class="row">
                    <div class="col-sm-6 col-md-4">
                        <div class="form-group">
                            <label>Filter Wallet</label>
                            {!! Input::selectMultiple('wallets[]', [
                                'source' => $wallets->pluck('title', 'id')->toArray()
                            ]) !!}
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-5">
                        <div class="form-group">
                            <label>Filter Transaction Date</label>
                            {!! Input::dateRange('periode[]') !!}
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-3">
                        <div class="form-group">
                            <label style="visibility:hidden">.</label>
                            <button class="btn btn-primary btn-block">Filter</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card card-body transaction-result">
        Please wait...
    </div>
@stop

@push ('modal')
    @include ('wallet::partials.update-balance-modal')
@endpush

@push ('script')
    @include ('wallet::partials.record-asset')
    <script>
    window.CURRENT_PAGE = 1;
    $(function(){
        setTimeout(function(){
            loadTransaction(1, 'no');
        }, 500);
        $(".transaction-form").on('submit', function(e){
            e.preventDefault();
            loadTransaction();
        });

        $(document).on('click', ".transaction-pagination a", function(e){
            e.preventDefault();
            if($(this).attr('data-page')){
                loadTransaction($(this).attr('data-page'));
            }
        });

        $(document).on('click', '.btn-remove-record', function(e){
            e.preventDefault();
            toastr.warning('Are you sure you want to delete this record? This action cannot be undone. <br><a href="#" class="btn btn-secondary btn-proceed-delete" data-id="'+ $(this).attr('data-id') +'">Yes, Delete</a>');
        });

        $(document).on('click', '.btn-proceed-delete', function(e){
            e.preventDefault();
            showLoading();
            $.ajax({
                url : window.BASE_URL + '/remove-wallet-record',
                type : 'POST',
                dataType : 'json',
                data : {
                    _token : window.CSRF_TOKEN,
                    id : $(this).attr('data-id')
                },
                success : function(resp){
                    if(resp.type == 'success'){
                        toastr.success('Wallet record data has been removed.');
                        loadTransaction();
                    }
                    else{
                        toastr.error(resp.message);
                        hideLoading();
                    }
                },
                error : function(resp){
                    hideLoading();
                    toastr.error('Sorry, we cannot process your request right now');
                }
            });
        });
    });

    function loadTransaction(page, scroll){
        page = page || window.CURRENT_PAGE;
        scroll = scroll || 'yes';
        window.CURRENT_PAGE = page;
        showLoading();
        $.ajax({
            url : window.BASE_URL + '/get-transaction-list',
            dataType : 'html',
            cache : false,
            data : $(".transaction-form").serialize() + '&page=' + page,
            success : function(resp){
                $(".transaction-result").html(resp);
                hideLoading();
                feather.replace();
                if(scroll == 'yes'){
                    $("html, body").animate({
                        scrollTop : 200
                    });
                }
            },
            error : function(resp){
                hideLoading();
            }
        });
    }
    </script>
@endpush