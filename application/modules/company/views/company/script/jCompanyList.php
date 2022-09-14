<script type="text/javascript">

    // Evnet Click Detail
    $('.xWCmpAddrDetail').click(function(){
        poElement = this;
        if (poElement.getAttribute("data-dblclick") == null) {
            poElement.setAttribute("data-dblclick", 1);
            $(poElement).select();
            setTimeout(function () {
                if (poElement.getAttribute("data-dblclick") == 1) {
                    var nStaSession = JCNxFuncChkSessionExpired();
                    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                        var aDataWhereAddress   = {
                            'ptAddLngId'    : $(poElement).parents('.xWCompDataAddr').data('addrlngid'),
                            'ptAddGrpType'  : $(poElement).parents('.xWCompDataAddr').data('addrgrptpe'),
                            'ptAddRefCode'  : $(poElement).parents('.xWCompDataAddr').data('addrefcode'),
                            'ptAddSeqNo'    : $(poElement).parents('.xWCompDataAddr').data('addrseqno')
                        };
                        JCNoCmpCallAddressDataInfo(aDataWhereAddress);
                    }else{
                        JCNxShowMsgSessionExpired();
                    }
                }
                poElement.removeAttribute("data-dblclick");
            }, 300);
        }
    });

    // Function : Call Modal Address Info
    function JCNoCmpCallAddressDataInfo(paDataWhereAddress){
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "companyEventCallAddress",
            data: paDataWhereAddress,
            success: function(tResult){
                let aDataReturn = JSON.parse(tResult);
                if(aDataReturn['nStaEvent'] == 1){
                    $('#odvModalAddressList #odvCompDataAddressInfo').html(aDataReturn['tViewModalAddrInfo']);
                    $('#odvModalAddressList #odvCompDataAddressMap').html(aDataReturn['tViewModalAddrMap']);
                    setTimeout(function(){
                        $('#odvModalAddressList').modal('show');
                        $('#odvModalAddressList').on('hidden.bs.modal',function(){
                            $('#odvModalAddressList #odvCompDataAddressInfo').empty();
                            $('#odvModalAddressList #odvCompDataAddressMap').empty();
                            $('body').removeClass('modal-open');
                            $('.modal-backdrop').remove();
                        });
                        JCNxCloseLoading();
                    },1000)
                }else{
                    var tMessageError   = aDataReturn['tStaMessg'];
                    FSvCMNSetMsgErrorDialog(tMessageError);
                    JCNxCloseLoading();
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }


    // Get Data FTCmpCode
    //Functionality : Event Check oliInforSettingConTab 
    // Create By Witsarut 19/10/2019
    $('#oliInforSettingConTab').click(function(){
        JSxCompSettingConnect();
    });

    function JSxCompSettingConnect(){
        // Check Login Expried
        var nStaSession = JCNxFuncChkSessionExpired();
        //if have Session
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            $.ajax({
                type    : "POST",
                url     : "CompSettingCon",
                data    : {
                    tCompCode : '',
                },
                cache : false,
                timeout : 0,
                success : function (tResult){
                    $('#odvInforSettingConTab').html(tResult);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }else{
            JCNxShowMsgSessionExpired();
        }
    }

</script>