<div class="row" style="width:inherit;">
    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
        <div class="row">
            <div class="input-group">
                <input 
                class="form-control xCNInputWithoutSingleQuote" 
                type="text" id="oetSearchAllStep2" 
                name="oetSearchAllStep2" 
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
    <!--ลบทั้งหมด-->
    <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 text-right p-r-0 xCNhideWhenApproveOrCancel">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="btn-group xCNDropDrownGroup">
                    <button type="button" class="btn xCNBTNMngTable" data-toggle="dropdown">
                        <?= language('common/main/main', 'tCMNOption') ?>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li id="oliBtnDeleteAllStep2" class="disabled">
                            <a data-toggle="modal" data-target="#odvRVDModalDelPDTMultipleStep2"><?= language('common/main/main', 'tCMNDeleteAll') ?></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!--ตาราง-->
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div id="odvContentStep2" class="row" style="margin-top: 10px;"></div>
    </div>
</div>

<script>
    //เช็คว่าเอกสารอนุมัติ หรือ ยกเลิกหรือเปล่า
    JSxControlWhenApproveOrCancel();

    //ค้นหาใน Step2
    $("#oetSearchAllStep2").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#otdTBodyTableStep2 tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

    //ถ้า Step1 ไม่มีข้อมูล จะกด step2 ไม่ได้
    $('.xCNRefillVDStep2').click(function() {
        var tCheckClassTbody = $('.xCNTableStep1 #otdTBodyTableStep1 tr').hasClass('otrDataNotFound');
        if(tCheckClassTbody == true){
            //ไม่มีข้อมูลใน step1
            setTimeout(function(){
                $('#odvPDTInStep1IsEmpty').modal('show');
            }, 500);
        }else{
            //มีข้อมูลใน step1 โหลดหน้าจอ -> step2
            if($('#ohdRefillVDDontRefresh').val() != 1){
                //โหลด step2 ได้
                JSvRVDCallTableStep2();

                //กด Step2
                $('#ohdClickStep').val(2);

                $('.xCNRefillBackStep').show(); //ย้อนกลับโชว์
                $('.xCNRefillNextStep').show(); //ถัดไปโชว์
            }else{
                //ถ้าเกิดใน step2 มีการเเก้ข้อมูล หรือ ลบข้อมูลจะไม่ต้องโหลด step2 ใหม่
            }
        }
    });

    //Call Table Step2
    function JSvRVDCallTableStep2(){
        try{
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                JCNxOpenLoading();
                $.ajax({
                    type    : "POST",
                    url     : "docRVDRefillPDTVDLoadTableStep2",
                    cache   : false,
                    data    : { 
                        tDocumentNumber         : $('#oetRVDDocNo').val() , 
                        tTypepage               : '<?=$tTypePage?>' ,
                        tTypeClickPDT           : $('#ohdClickConfirmPDTStep1').val() ,
                        tTypeFlagCheckSTKBal    : $('#ocbRVDStaFullRefillPos:checked').val() ,
                        
                    },
                    timeout : 0,
                    success: function(oResult) {
                        JCNxCloseLoading();
                        var aReturnData = JSON.parse(oResult);
                        if (aReturnData['nStaEvent'] == '1') {
                            $('#odvContentStep2').html(aReturnData['tViewer']);
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
            console.log('JSvRVDCallTableStep2 Error: ', err);
        }
    }
</script>