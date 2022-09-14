<div class="row" style="width:inherit;">
    <!--ตาราง-->
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div id="odvContentStep4" class="row" style="margin-top: 10px;"></div>
    </div>
</div>

<!-- กรุณาเลือกคลังปลายทาง-->
<div class="modal fade" id="odvSelectWahouseIsEmpty">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header xCNModalHead">
				<label class="xCNTextModalHeard"><?=language('document/document/document', 'tDocStawarning') ?></label>
			</div>
			<div class="modal-body">
				<p><?= language('document/RefillProductVD/RefillProductVD','tSelectWahouseIsEmpty')?></p>
			</div>
			<div class="modal-footer">
                <button type="button" class="btn xCNBTNPrimery"  data-dismiss="modal" onclick="JSxRVDBackToStep2()">
					<?=language('common/main/main', 'tModalConfirm'); ?>
				</button>
			</div>
		</div>
	</div>
</div>

<script>
    $(document).ready(function(){
        //เช็คว่าเอกสารอนุมัติ หรือ ยกเลิกหรือเปล่า
        JSxControlWhenApproveOrCancel();
    });

    //ถ้า Step1 ไม่มีข้อมูล จะกด step4 ไม่ได้
    $('.xCNRefillVDStep4').click(function() {
        var tCheckClassTbody = $('.xCNTableStep1 #otdTBodyTableStep1 tr').hasClass('otrDataNotFound');
        if(tCheckClassTbody == true){
            //ไม่มีข้อมูลใน step1
            setTimeout(function(){
                $('#odvPDTInStep1IsEmpty').modal('show');
            }, 500);
        }else{
            var tCheckClassInTable2 = $('#odvRVDDataPdtTableDTTemp .tab-content #odvRefillVDStep2 #odvContentStep2').hasClass('xCNTableStep2');
            if( $('#ohdClickStep').val() <= 1){
                $('#odvPDTInStep2IsEmpty').modal('show');
                return;
            }

            var tCheckClassTbody = $('.xCNTableStep2 #otdTBodyTableStep2 tr').hasClass('otrDataNotFound');
            if(tCheckClassTbody == true){
                //ไม่มีข้อมูลใน step2
                setTimeout(function(){
                    $('#odvPDTInStep2IsEmpty').modal('show');
                }, 500);
            }else{
                //มีข้อมูลใน step2 โหลดหน้าจอ -> step4
                if($('#oetRVDWahTransferCode').val() == '' || $('#oetRVDWahTransferCode').val() == null){
                    $('#odvSelectWahouseIsEmpty').modal('show');
                }else{
                    JSvRVDCallTableStep4();

                    //กด Step4
                    $('#ohdClickStep').val(4);

                    $('.xCNRefillBackStep').show(); //ย้อนกลับโชว์
                    $('.xCNRefillNextStep').hide(); //ถัดไปไม่ต้องโชว์
                }
            }
        }
    });

    //โหลดข้อมูล step4
    function JSvRVDCallTableStep4(){
        try{
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                JCNxOpenLoading();
                $.ajax({
                    type    : "POST",
                    url     : "docRVDRefillPDTVDLoadTableStep4",
                    cache   : false,
                    data    : { tDocumentNumber : $('#oetRVDDocNo').val() },
                    timeout : 0,
                    success: function(oResult) {
                        JCNxCloseLoading();
                        var aReturnData = JSON.parse(oResult);
                        if (aReturnData['nStaEvent'] == '1') {
                            $('#odvContentStep4').html(aReturnData['tViewer']);
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
            console.log('JSvRVDCallTableStep4 Error: ', err);
        }
    }
</script>