<div class="row" style="width:inherit;">
    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
        <div class="row">
            <div class="input-group">
                <input 
                class="form-control xCNInputWithoutSingleQuote" 
                type="text" id="oetSearchAllStep3" 
                name="oetSearchAllStep3" 
                placeholder="<?= language('document/RefillProductVD/RefillProductVD', 'tRVDFillTextSearch') ?>" 
                onkeypress="if (event.keyCode == 13) {return false;}"
                autocomplete="off">
                <span class="input-group-btn">
                    <button type="button" class="btn xCNBtnDateTime">
                        <img src="<?=base_url('application/modules/common/assets/images/icons/search-24.png') ?>">
                    </button>
                </span>
            </div>
        </div>
    </div>
    <!--ตาราง-->
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div id="odvContentStep3" class="row" style="margin-top: 10px;"></div>
    </div>
</div>

<script>
    $(document).ready(function(){
        //เช็คว่าเอกสารอนุมัติ หรือ ยกเลิกหรือเปล่า
        JSxControlWhenApproveOrCancel();
    });

    //ค้นหาใน Step2
    $("#oetSearchAllStep3").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#otdTBodyTableStep3 tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

    //ถ้า Step1 ไม่มีข้อมูล จะกด step3 ไม่ได้
    $('.xCNRefillVDStep3').click(function() {
        var tCheckClassTbody = $('.xCNTableStep1 #otdTBodyTableStep1 tr').hasClass('otrDataNotFound');
        if(tCheckClassTbody == true){
            //ไม่มีข้อมูลใน step1
            setTimeout(function(){
                $('#odvPDTInStep1IsEmpty').modal('show');
            }, 500);
        }else{
            var tCheckClassTbody = $('.xCNTableStep2 #otdTBodyTableStep2 tr').hasClass('otrDataNotFound');
            if(tCheckClassTbody == true){
                //ไม่มีข้อมูลใน step2
                setTimeout(function(){
                    $('#odvPDTInStep2IsEmpty').modal('show');
                }, 500);
            }else{
                //มีข้อมูลใน step2 โหลดหน้าจอ -> step3
                JSvRVDCallTableStep3();

                //กด Step3
                $('#ohdClickStep').val(3);

                $('.xCNRefillBackStep').show(); //ย้อนกลับโชว์
                $('.xCNRefillNextStep').show(); //ถัดไปโชว์
            }
        }
    });

    //โหลดข้อมูล step3
    function JSvRVDCallTableStep3(){
        try{
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                JCNxOpenLoading();
                $.ajax({
                    type    : "POST",
                    url     : "docRVDRefillPDTVDLoadTableStep3",
                    cache   : false,
                    data    : { tDocumentNumber : $('#oetRVDDocNo').val() },
                    timeout : 0,
                    success: function(oResult) {
                        JCNxCloseLoading();
                        var aReturnData = JSON.parse(oResult);
                        if (aReturnData['nStaEvent'] == '1') {
                            $('#odvContentStep3').html(aReturnData['tViewer']);
                        }else {
                            var tMessageError = aReturnData['tStaMessg'];
                            FSvCMNSetMsgErrorDialog(tMessageError);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(jqXHR, textStatus, errorThrown);
                    }
                });
            }else{
                JCNxShowMsgSessionExpired();
            }
        }catch(err){
            console.log('JSvRVDCallTableStep3 Error: ', err);
        }
    }
</script>