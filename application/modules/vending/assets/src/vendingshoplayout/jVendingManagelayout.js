
$('ducument').ready(function() {
    // $('.xWolibtnsave2').css('display','none');
});

//View
function JSnVendingShoplayoutManageProduct(pnCode){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        JCNxOpenLoading();
        JStCMMGetPanalLangSystemHTML('', '');
        $.ajax({
            type    : "POST",
            url     : "VendingmanagePageAdd",
            cache   : false,
            data    : { nID : pnCode},
            timeout : 0,
            success : function(tResult) {
                $('#odvContentPageVendingShoplayout').html(tResult);
                JCNxCloseLoading();
            },
            error: function(data) {
                console.log(data);
            }
        });
    }else{
        JCNxShowMsgSessionExpired();
    }
}

//Insert
function JSxInsertPDTintoDatabase(){
    var aDataPDT = [];
    for($i=1; $i<=tRowHD; $i++){
        var tUseRow = $('#odvContentPDTRow'+$i+' #odvContentPDTRowDetail'+$i+' .xCNRow'+$i+'').length;
       
        if(tUseRow != 0){

            var tSetHeight = $('.ohdValueSetHeightByRow'+$i).val();
            // if(tSetHeight == 0 || tSetHeight == undefined){
            //     alert('กรุณาเพิ่มความสูงของชั้นที่ ' + $i);
            //     var tStatuspass = 'fail';
            // }else{
                $('.xCNRow'+$i).each(function(i, obj) {
                    var tRowwidth        = $(obj).attr('data-rowwidth');
                    var tRowStart        = $(obj).attr('data-rowstart');
                    var tStartCol        = $(obj).attr('data-rowstartcol');
                    var tPDTDim          = $(obj).attr('data-rowdim');
                    var tPDTCode         = $(obj).attr('data-rowcode');
                    var tBarcode         = $(obj).attr('data-barcode');
                    
                    if(tSetHeight == '' || tSetHeight == null){
                        tSetHeight = 1;
                    }
                    
                    var aPackValue =[
                        tRowStart,{
                            'FTShpCode'     : $('#ohdShopHD').val(),
                            'FTPdtCode'     : tPDTCode,
                            'FNLayRow'      : $i,
                            'FNLayCol'      : tStartCol - 1,
                            'FCLayDim'      : tPDTDim,
                            'FCLayHigh'     : tSetHeight,
                            'FCLayWide'     : tRowwidth,
                            'FTLayStaUse'   : $('#ohdStatusHD').val(),
                            'FCLayColQtyMax': $('#ohdFTLayColQtyMax').val(),
                            'FTLayBarCode'  : tBarcode,
                            'FTBchCode'     : $('#oetBranchCodeVSL').val(),
                            'CountBch'      : $('#oetCountBranchVSL').val()
                        }
                    ]
    
                    aDataPDT.push(aPackValue);
                });
                var tStatuspass = 'pass';
            //}
        }
    }

    if(aDataPDT.length == 0){
        if(tStatuspass != 'fail'){
            var aPackValueNULL =[
                '0',{
                    'FTShpCode'     : $('#ohdShopHD').val()
                }
            ];
            aDataPDT.push(aPackValueNULL);
            $.ajax({
                type    : "POST",
                url     : 'VendingmanageEventAdd',
                data    : {aData : aDataPDT},
                cache   : false,
                timeout : 0,
                success : function(tResult) {
                    var aReturn = JSON.parse(tResult);
                    if(aReturn['nStaEvent'] == 1){
                        JSnVendingShoplayoutManageProduct(aReturn['tCodeReturn']);
                        aDataPDT = '';
                    }
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }
    }else{
        if(tStatuspass == 'pass'){
            $.ajax({
                type    : "POST",
                url     : 'VendingmanageEventAdd',
                data    : {aData : aDataPDT},
                cache   : false,
                timeout : 0,
                success : function(tResult) {
                    var aReturn = JSON.parse(tResult);
                    if(aReturn['nStaEvent'] == 1){
                        //switch(aReturn['nStaCallBack']) {
                            // case '1': //if บันทึกเเละดู
                            //     //JSnVendingShoplayoutManageProduct(aReturn['tCodeReturn']);
                            //     break;
                            // case '2': //if บันทึกและเพิ่มใหม่
                            //     //JSnVendingShoplayoutManageProduct(aReturn['tCodeReturn']);
                            //     break;
                            // case '3': //if บันทึกและกลับ
                            //     JSvCallPageVendingShoplayoutList();
                            //     break;
                            // default:
                                JSnVendingShoplayoutManageProduct(aReturn['tCodeReturn']);
                        //}
                    }
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }
    }
       
}

