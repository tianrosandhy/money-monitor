<script>
$(function(){
    $(document).on('click', '.update-balance', function(e){
        e.preventDefault();
        showLoading();
        target_url = window.BASE_URL + '/wallet-record/create/' + $(this).attr('data-wallet');
        if($(this).attr('data-tanggal')){
            target_url += '?tanggal=' + $(this).attr('data-tanggal');
        }
        $.ajax({
            url : target_url,
            dataType : 'html',
            success : function(resp){
                $("#wallet-modal .modal-body").html(resp);
                initPlugins();
                $("#wallet-modal").modal();
                hideLoading();
                refreshNewBalance();
            },
            error : function(resp){
                toastr.error('Sorry, we cannot process your request right now');
                hideLoading();
            }
        });
    });

    $(document).on('change', '[data-balance-date]', function(e){
        $.ajax({
            url : window.BASE_URL + '/get-wallet-balance',
            data : {
                date : $(this).val(),
                wallet_id : $(".balance-form input[name='wallet_id']").val()
            },
            dataType : 'json',
            success : function(resp){
                console.log(resp);
                $(".wallet-balance-per-date").html(resp.data.formatted_balance);
                $(".wallet-balance-per-date").attr('balance', resp.data.balance);
                refreshNewBalance();
            },
            error : function(resp){

            }
        })
    });

    $(document).on('keyup blur', '.balance-form input[name=plus], .balance-form input[name=minus]', function(){
        cval = $(this).val();
        if(cval.substring(0, 1) == '0'){
            if(cval.length > 1){
                $(this).val(cval.substring(1));
            }
        }
        refreshNewBalance();
    });
    $(document).on('keyup blur', '.balance-form input[name=nominal]', function(){
        cval = $(this).val();
        if(cval.substring(0, 1) == '0'){
            if(cval.length > 1){
                $(this).val(cval.substring(1));
            }
        }
        refreshPlusMinus();
    });


    $(document).on('submit', '.balance-form', function(e){
        e.preventDefault();
        showLoading();
        $.ajax({
            url : $(this).attr('action'),
            type : 'POST',
            dataType : 'json',
            data : $(".balance-form").serialize(),
            success : function(resp){
                if(resp.type == 'success'){
                    window.location.reload();
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

function refreshPlusMinus(){
    initial = parseInt($(".wallet-balance-per-date").attr('balance'));
    final = parseInt($(".balance-form input[name='nominal']").val());
    if(isNaN(final)){
        final = 0;
    }

    selisih = final - initial;
    if(selisih < 0){
        $(".balance-form input[name='plus']").val('');
        $(".balance-form input[name='minus']").val(Math.abs(selisih));
    }
    else{
        $(".balance-form input[name='minus']").val('');
        $(".balance-form input[name='plus']").val(Math.abs(selisih));
    }
}

function refreshNewBalance(){
    initial = parseInt($(".wallet-balance-per-date").attr('balance'));
    plus = parseInt($(".balance-form input[name=plus]").val());
    minus = parseInt($(".balance-form input[name=minus]").val());
    if(isNaN(plus)){
        plus = 0;
    }
    if(isNaN(minus)){
        minus = 0;
    }
    newval = initial +  plus - minus;
    if(newval < 0){
        $(".balance-form input[name=minus]").val(initial);
        newval = 0;
    }
    $(".balance-form input[name='nominal']").val(newval);
}
</script>