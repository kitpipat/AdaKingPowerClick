<input type="hidden" name="ohdTaxCheckOutCallTaxNo" id="ohdTaxCheckOutCallTaxNo" value="0">
<div id="odvTAXMainMenu">
    <div class="main-menu">
        <div class="xCNMrgNavMenu">
            <div class="row xCNavRow" style="width:inherit;">
                <div class="col-xs-12 col-sm-4 col-md-6 col-lg-6">
                    <ol class="breadcrumb">
                        <?php FCNxHADDfavorite('dcmTXIN/0/0');?>
                        <li style="cursor:pointer;"  onclick="JSvTAXCallPageTaxinvoice()"><?=language('document/taxinvoice/taxinvoice', 'tTitleMenu'); ?></li>
                        <li class="active xCNCreate xCNHide"><a><?= language('document/taxinvoice/taxinvoice', 'tCreate'); ?></a></li>
                    </ol>
                </div>
                <div class="col-xs-12 col-sm-8 col-md-6 col-lg-6 text-right p-r-0">
                    <div class="xCNBtngroup" style="width:100%;">
                        <div>
                            <div style="width:100%;">
                                <a href="" download="" class="xWETaxOnDownload xCNHide"></a>
                                <button class="btn xCNBTNDefult xCNBTNDefult2Btn xCNHide" type="button" id="obtTAXCancleETax"><?=language('common/main/main', 'ยกเลิกเอกสาร'); ?></button>
                                <button class="btn xCNBTNPrimery xCNBTNPrimery2Btn xCNHide" type="button" id="obtTAXApvETax"><?=language('common/main/main', 'tCMNApprove'); ?></button>
                                <button class="btn xCNBTNDefult xCNBTNDefult2Btn xCNHide" type="button" id="obtPrintPreviewDocumentABB"><?=language('document/taxinvoice/taxinvoice', 'tTAXPrintABB'); ?></button>
                                <button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button" id="obtCancleDocument"><?=language('common/main/main', 'tCancel'); ?></button>
                                <button class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button" id="obtApproveDocument"><?=language('common/main/main', 'tCMNApprove'); ?></button>
                                <button class="btn xCNBTNDefult xCNBTNDefult2Btn xCNHide" type="button" id="obtPrintDocument"><?=language('document/taxinvoice/taxinvoice', 'tTAXPrint'); ?></button>
                                <button class="btn xCNBTNDefult xCNBTNDefult2Btn xCNHide" type="button" id="obtPrintPreviewDocument" onclick="JSxTaxPrintPreviewDoc();"><?=language('document/taxinvoice/taxinvoice', 'tTAXPrintPreview'); ?></button>
                                <button class="btn xCNBTNPrimery xCNBTNPrimery2Btn xCNHide" type="button" id="obtSaveDocument"><?=language('common/main/main', 'tSave'); ?></button>
                            </div>
                        </div>
                    </div>
                    <div class="xCNBtnInsert">
                        <button id="obtTransferReceiptAdd" class="xCNBTNPrimeryPlus" type="button" onclick="JSvTAXLoadPageAddOrPreview('','')">+</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="xCNMenuCump xCNPIBrowseLine" id="odvMenuCump">&nbsp;</div>
    <div class="main-content">
        <div id="odvTaxContentPageDocument">
        </div>
    </div>
<div>


<iframe id="oifPrint" height="0"></iframe>
<iframe id="oifPrintABB" height="0"></iframe>


<!--- ============================================================== ยกเลิกเอกสาร ============================================= -->
<div id="odvCancleDocument" class="modal fade" tabindex="-1" role="dialog" data-toggle="modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" style="margin: 1.75rem auto;">
		<div class="modal-content">
			<div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard" style="font-weight: bold; font-size: 20px;"><?=language('document/taxinvoice/taxinvoice', 'tTAXwarning')?></label>
			</div>
			<div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
						<span><?=language('document/taxinvoice/taxinvoice', 'tTAXCancleDoucment')?></span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="osmConfirmCancleDocument" type="button" class="btn xCNBTNPrimery" data-dismiss="modal">
					<?=language('common/main/main', 'tModalConfirm'); ?>
				</button>
				<button type="button" class="btn xCNBTNDefult xCNBTNDefult2Btn" data-dismiss="modal">
					<?=language('common/main/main', 'tCMNClose'); ?>
				</button>
			</div>
		</div>
	</div>
</div>

<!--- ============================================================== อนุมัติเอกสาร ============================================= -->
<div id="odvModalAproveDocument" class="modal fade" tabindex="-1" role="dialog" data-toggle="modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="xCNHeardModal modal-title" style="display:inline-block"><?=language('common/main/main','tApproveTheDocument'); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><?=language('common/main/main','tMainApproveStatus'); ?></p>
                    <ul>
                        <li><?=language('document/taxinvoice/taxinvoice','tMainApproveStatus1'); ?></li>
                        <li><?=language('document/taxinvoice/taxinvoice','tMainApproveStatus2'); ?></li>
                        <li><?=language('document/taxinvoice/taxinvoice','tMainApproveStatus3'); ?></li>
                    </ul>
                <p><?=language('common/main/main','tMainApproveStatus5'); ?></p>
                <p><strong><?=language('common/main/main','tMainApproveStatus6'); ?></strong></p>
            </div>
            <div class="modal-footer">
                <button  id="obtConfirmApprDoc" type="button" class="btn xCNBTNPrimery"><?=language('common/main/main', 'tModalConfirm'); ?></button>
                <button  id="obtCloseApprDoc" type="button" class="btn xCNBTNDefult" data-dismiss="modal"><?=language('common/main/main', 'tModalCancel'); ?></button>
            </div>
        </div>
    </div>
</div>

<!--- ======================================================== พิมพ์บางใบ + พิมพ์ทั้งหมด ======================================== -->
<div id="odvModalPrintDocument" class="modal fade" tabindex="-1" role="dialog" data-toggle="modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="xCNHeardModal modal-title" style="display:inline-block"><?=language('common/main/main','tTAXPrint'); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">



                <div class="form-check form-check-inline">
                    <input class="form-check-input xCNRadioPrint" type="radio" name="orbPrint"  id="orbPrint1"  value="1" checked>
                    <label class="form-check-label" for="orbPrint1">&nbsp;<?=language('document/taxinvoice/taxinvoice', 'tTAXPrintAll'); ?></label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input xCNRadioPrint" type="radio" name="orbPrint"  id="orbPrint2" value="2">
                    <label class="form-check-label" for="orbPrint2">&nbsp;<?=language('document/taxinvoice/taxinvoice', 'tTAXPrintBypage'); ?></label>
                </div>

                <div class="form-group xCNPrintByPage" style="display:none;">
                    <label class="xCNLabelFrm" style="margin-top: 5px;"><?=language('document/taxinvoice/taxinvoice', 'tTAXPrintBypageKey'); ?></label>
                    <input type="text" class="form-control xWTooltipsBT xCNInputWithoutSpcNotThai xCNInputWithoutSingleQuote xCNInputNumericWithDecimal" id="oetPrintAgain" name="oetPrintAgain" maxlength="2" value=""
                            placeholder="<?=language('document/taxinvoice/taxinvoice', 'tTAXPrintBypageKey'); ?>">
                </div>

                <script>
                    $('.xCNRadioPrint').change(function(e) {
                        var nValue = $(this).val();
                        if(nValue == 2){
                            $('.xCNPrintByPage').css('display','block');
                        }else{
                            $('.xCNPrintByPage').css('display','none');
                        }
                    });
                </script>
            </div>
            <div class="modal-footer">
                <button  id="obtConfirmPrintFullTax" type="button" class="btn xCNBTNPrimery" data-dismiss="modal"><?=language('common/main/main', 'tModalConfirm'); ?></button>
                <button type="button" class="btn xCNBTNDefult" data-dismiss="modal"><?=language('common/main/main', 'tModalCancel'); ?></button>
            </div>
        </div>
    </div>
</div>


<script>
    $('document').ready(function() {
        localStorage.removeItem('LocalItemData');
        JSxCheckPinMenuClose();

        $('.xCNBtngroup').hide();

        var nBrowseType = '<?=$nBrowseType?>';
        // console.log('nBrowseType: ' + nBrowseType);

        switch(nBrowseType){
            case '1':
                var tDocNo      = '<?=$aParams['tDocNo']?>';
                var tBchCode    = '<?=$aParams['tBchCode']?>';
                // console.log(tDocNo);
                // console.log(tBchCode);
                JSvTAXLoadPageAddOrPreview(tBchCode,tDocNo); 
                break;
            default:
                //โหลดหน้าจอ list
                JSxLoadContentList();
        }

    });


    function JSxLoadContentList(){
        JCNxOpenLoading();
        $.ajax({
            type    : "POST",
            url     : "dcmTXINLoadList",
            cache   : false,
            Timeout : 0,
            success : function (oResult) {
                $('#odvTaxContentPageDocument').html(oResult);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    //โหลดหน้าจอเพิ่ม + เเก้ไข
    function JSvTAXLoadPageAddOrPreview(tDocumentBchCode,ptDocument){
        $.ajax({
            type    : "POST",
            url     : "dcmTXINLoadPageAdd",
            data    : { 'tDocument' : ptDocument,tDocumentBchCode:tDocumentBchCode },
            cache   : false,
            Timeout : 0,
            success : function (oResult) {
                $('#odvTaxContentPageDocument').html(oResult);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    //โหลดกลับหน้าเเรก
    function JSvTAXCallPageTaxinvoice(){
        JCNxOpenLoading();
        JSxLoadContentList();

        $('.xCNBtngroup').hide();
        $('.xCNCreate').addClass('xCNHide');
        $('.xCNBtnInsert').show();
    }

    //ยกเลิกเอกสาร
    $('#obtCancleDocument').on('click',function(){
        $('#odvCancleDocument').modal('show');

        $('#osmConfirmCancleDocument').off();
        $('#osmConfirmCancleDocument').on('click',function(){
            setTimeout(function(){
                JSvTAXCallPageTaxinvoice();
            }, 100);
        });
    });

    //อนุมัติเอกสาร
    $('#obtApproveDocument').on('click',function(){

        $('.form-group').removeClass("has-success").removeClass("has-error");

        var nCountValidate = 0;
        nCountValidate = JSxTAXValidateInput('#oetTAXDocDate',nCountValidate);
        nCountValidate = JSxTAXValidateInput('#oetTAXDocTime',nCountValidate);
        nCountValidate = JSxTAXValidateInput('#oetTAXABBCode',nCountValidate);
        nCountValidate = JSxTAXValidateInput('#oetTAXCusNameCusABB',nCountValidate);
        nCountValidate = JSxTAXValidateInput('#oetTAXNumber',nCountValidate);

        nCountValidate = JSxTAXValidateInput('#otxAddress1',nCountValidate);
        nCountValidate = JSxTAXValidateInput('#oetFTAddV1PvnName',nCountValidate);
        nCountValidate = JSxTAXValidateInput('#oetFTAddV1DstName',nCountValidate);
        nCountValidate = JSxTAXValidateInput('#oetFTAddV1SubDistName',nCountValidate);
        nCountValidate = JSxTAXValidateInput('#oetFTAddV1PostCode',nCountValidate);

        var tTaxABBType = $("#oetTAXABBTypeDocuement").val();
        if( tTaxABBType == '9' ){  // CN-ABB
            nCountValidate = JSxTAXValidateInput('#oetTAXRsnName',nCountValidate);
        }
        
        if( nCountValidate > 0 ){
            return;
        }else{
            JSxTAXComfirmApprove();
        }
    });

    function JSxTAXComfirmApprove(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof nStaSession !== "undefined" && nStaSession == 1){
            try{

                $('.form-group').removeClass("has-success").removeClass("has-error");

                $('#odvModalAproveDocument').modal("show");
                $('#obtConfirmApprDoc').off();

                $('#obtCloseApprDoc').on('click',function(){
                    $('#obtApproveDocument').attr("disabled",false);
                    $('#obtConfirmApprDoc').attr("disabled",false);
                });

                $('#obtConfirmApprDoc').on('click',function(){
                    $('#obtConfirmApprDoc').attr("disabled",true);
                    $('#obtApproveDocument').attr("disabled",true);

                    var aPackData = {
                        tDocABB         : $('#oetTAXABBCode').val(),
                        tBrowseBchCode  : $('#oetBrowseBchCode').val(),
                        tStaETax        : $('#oetTXIStaETax').val(),
                        tTAXApvType     : $('#ohdTAXApvType').val()
                    }

                    //ส่งเข้า Q ไปหาเลขที่เอกสารก่อน
                    JCNxOpenLoading();
                    $.ajax({
                        type    : "POST",
                        url     : "dcmTXINApprove",
                        cache   : false,
                        data    : { 'aPackData' : aPackData , 'tType' : 'MQ'},
                        Timeout : 0,
                        success : function (oResult) {
                            var aResult = JSON.parse(oResult);

                            if(aResult.nStaEvent == 500){
                                FSvCMNSetMsgWarningDialog('เกิดข้อผิดพลาด กรุณาลองทำรายการใหม่อีกครั้ง');
                                JCNxCloseLoading();
                            }else if(aResult.nStaEvent == 550){
                                FSvCMNSetMsgWarningDialog('เกิดข้อผิดพลาด กรุณาลองตรวจสอบเลขที่ใบกำกับภาษีอย่างย่อ ใหม่อีกครั้ง');
                                $('#odvModalAproveDocument').modal("hide");
                                $('#obtConfirmApprDoc').attr("disabled",false);
                                $('#obtApproveDocument').attr("disabled",false);
                                JCNxCloseLoading();
                            }else if(aResult.nStaEvent == 800){
                                JSvCMNSetMsgErrorDialog(aResult.tStaMessg);
                                JCNxCloseLoading();
                            }else{
                                $('#odvModalAproveDocument').modal("hide");
                                $('#obtConfirmApprDoc').attr("disabled",false);
                                $('#obtApproveDocument').attr("disabled",false);
                                // var tBCH    = aResult.tBCHDoc;
                                // JCNxOpenLoading();
                                // var tDocABB = $('#oetTAXABBCode').val();
                                // JSxINMSubScribeQName(tBCH,tDocABB);
                                JSxControlGetMassageByServer();
                            }
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            // FSvCMNSetMsgWarningDialog('เกิดข้อผิดพลาด กรุณาลองทำรายการใหม่อีกครั้ง');
                            JCNxResponseError(jqXHR, textStatus, errorThrown);
                            $('#obtConfirmApprDoc').attr("disabled",false);
                            $('#obtApproveDocument').attr("disabled",false);
                        }
                    });

                });
            } catch (err){
                console.log("Approve Error: ", err);
            }
        }else{
            JCNxShowMsgSessionExpired();
        }
    }

    function JSxTAXValidateInput(ptElem,nCountValidate){
        if( $(ptElem).val() == '' ){
            $(ptElem).closest('.form-group').removeClass("has-success").addClass("has-error");
            $(ptElem).focus();
            nCountValidate++;
            return nCountValidate;
        }else{
            $(ptElem).closest('.form-group').addClass("has-success").removeClass("has-error");
            return nCountValidate;
        }
    }

    //วิ่งเข้า MQ หาเลขที่เอกสาร
    function JSxINMSubScribeQName(ptBCH,ptDocumentNumber){
        // var tUserCode  = '<?=$this->session->userdata("tSesUserCode")?>';
        // var tDocBchCode = $('#ohdDocBchCode').val();
        // var tDocType = $('#ohdDocType').val();
        // var oImnclient = Stomp.client('ws://' + oSTOMMQConfig.host +':15674/ws');
        // var on_connect = function(x){
        //     oImnclient.subscribe('/queue/CN_QRetGenTaxNo_'+tDocBchCode+'_'+tDocType,function(res){
        //         let aRes = JSON.parse(res.body);

        //         if(aRes.rtCode == 001){
        //             $('#oetTAXDocNo').val(aRes.rtDocNo);

        //             //ปิดปุ่ม ย้อนกลับ + อนุมัติ // เปิดปุ่ม พิมพ์ + เพิ่มใหม่
        //             $('#obtCancleDocument').addClass('xCNHide');
        //             $('#obtApproveDocument').addClass('xCNHide');
        //             $('#obtPrintDocument').removeClass('xCNHide');
        //             $('#obtPrintPreviewDocument').removeClass('xCNHide');
        //             $('#obtSaveDocument').removeClass('xCNHide');
        //             JSxApprove(aRes.rtDocNo);
        //             JCNxCloseLoading();
        //         }else{
        //             alert('Something worng !')
        //         }

        //         res.ack();
        //         oImnclient.disconnect();
        //     },
        //     {ack:'client'}
        //     );
        // }
        // var on_error = function(x) {
        //     console.log(x);
        //     JSxControlGetMassageByServer();
        // }
        // oImnclient.connect(oSTOMMQConfig.user, oSTOMMQConfig.password, on_connect, on_error, oSTOMMQConfig.vhost);

        JSxControlGetMassageByServer();
    }

    //กรณีไม่สารถ GetMassage ได้จาก Stomp ให้ไป Get Massate ผ่าน Server
    function JSxControlGetMassageByServer(){
        let nTaxCheckOutCallTaxNo =  parseFloat($('#ohdTaxCheckOutCallTaxNo').val())+1;
        console.log('ไม่สำเร็จครั้งที่ '+nTaxCheckOutCallTaxNo);
        if(nTaxCheckOutCallTaxNo<5){
            setTimeout(function(){
                JSxTAXGetTaxNumberByServer();
                $('#ohdTaxCheckOutCallTaxNo').val(nTaxCheckOutCallTaxNo);
            },3000);
        }else{
            let tMessageError = 'เครือข่ายมีปัญหา กรุณาตรวจสอบเครือข่าย';
            FSvCMNSetMsgErrorDialog(tMessageError);
            $('#ohdTaxCheckOutCallTaxNo').val(0);
        }


    }

    //กรณีไม่สารถ GetMassage ได้จาก Stomp ให้ไป Get Massate ผ่าน Server
    function JSxTAXGetTaxNumberByServer(){
        console.log('JSxTAXGetTaxNumberByServer Processing');
        var tBrowseBchCode  = $('#oetBrowseBchCode').val();
        var tStaETax        = $('#oetTXIStaETax').val();
        var tTAXApvType     = $('#ohdTAXApvType').val();

        var aPackData = {
            tTAXApvType         : tTAXApvType,
            tCurretTaxDocNo     : $('#oetTAXDocNo').val(),
            tOriginTaxDocNo     : $('#oetTAXRefAE').val(),
            tBrowseBchCode      : $('#oetBrowseBchCode').val(),
            dDocDate            : $('#oetTAXDocDate').val(),
            dDocTime            : $('#oetTAXDocTime').val(),
            tDocABB             : $('#oetTAXABBCode').val(),
            tTaxnumber          : $('#oetTAXNumber').val(),
            tTypeBusiness       : $('#ocmTAXTypeBusiness option:selected').val(),
            tBusiness           : $('#ocmTAXBusiness option:selected').val(),
            tBranch             : $('#oetTAXBranch').val(),
            tTel                : $('#oetTAXTel').val(),
            tFax                : $('#oetTAXFax').val(),
            tEmail              : $('#oetTAXEmail').val(),
            tStaETax            : tStaETax,
            tPosCode            : $('#oetTAXPos').val(),

            tCstCode            : $('#oetTAXCusCode').val(),
            tCstName            : $('#oetTAXCusNameCusABB').val(),
            tCstNameABB         : $('#oetTAXCusNameCusABB').val(),
        
            tAddress1           : $('#otxAddress1').val(),
            tAddress2           : $('#otxAddress2').val(),
            
            tAddV1PvnCode       : $('#oetFTAddV1PvnCode').val(),
            tAddV1DstCode       : $('#oetFTAddV1DstCode').val(),
            tAddV1SubDistCode   : $('#oetFTAddV1SubDistCode').val(),
            tAddV1PostCode      : $('#oetFTAddV1PostCode').val(),
            tRemark             : $('#otaTAXRemark').val(),
            tReason             : $('#oetTAXRsnCode').val(),
            // tSeqAddress     : $('#ohdSeqAddress').val(),
            // tAddVersion         : $('input[name=orbTAXAddVersion]:checked').val(),
            // tAddV1No            : $('#oetFTAddV1No').val(),
            // tAddV1Soi           : $('#oetFTAddV1Soi').val(),
            // tAddV1Village       : $('#oetFTAddV1Village').val(),
            // tAddV1Road          : $('#oetFTAddV1Road').val(),
        };

        if( tTAXApvType == '2' ){
            aPackData['tReason']            = $('#oetTAXModalCancelRsnCode').val();
            aPackData['tCstCode']           = $('#oetTAXModalCancelCstCode').val();
            aPackData['tCstName']           = $('#oetTAXModalCancelCstName').val();
            aPackData['tCstNameABB']        = $('#oetTAXModalCancelCstName').val();
            aPackData['tAddress1']          = $('#otxTAXModalCancelAddress1').val();
            aPackData['tAddress2']          = $('#otxTAXModalCancelAddress2').val();
            aPackData['tAddV1PvnCode']      = $('#oetTAXModalCancelPvnCode').val();
            aPackData['tAddV1DstCode']      = $('#oetTAXModalCancelDstCode').val();
            aPackData['tAddV1SubDistCode']  = $('#oetTAXModalCancelSubDistCode').val();
            aPackData['tAddV1PostCode']     = $('#oetTAXModalCancelPostCode').val();
            aPackData['dDocDate']           = '<?=date('Y-m-d');?>';
            aPackData['dDocTime']           = '<?=date('H:i:s')?>';
        }

        // console.log(aPackData);

        $.ajax({
            type    : "POST",
            url     : "dcmTXINCallTaxNoLastDoc",
            cache   : false,
            data    : { aPackData : aPackData },
            Timeout : 0,
            success:function(oResult){
                var oReturn = JSON.parse(oResult);
                console.log(oReturn);
                if(oReturn.nStaEvent == '800'){
                    // var tBCH    = oReturn.tBCHDoc;
                    // var tDocABB = $('#oetTAXABBCode').val();
                    // JSxINMSubScribeQName(tBCH,tDocABB);
                    JSxControlGetMassageByServer();
                }else{
                    // console.log('กำลังลบ Q : ' + oResult);
                    if( tStaETax == '1' ){ // E-tax
                        JSxTAXSubscribeMQ(oReturn.tTaxNumberFull);
                    }else{
                        var tTaxNumberFull    = oReturn.tTaxNumberFull;
                        FSvCMNSetMsgSucessDialog('สร้างเอกสารใบกำกับภาษีสมบูรณ์');
                        JSvTAXLoadPageAddOrPreview(tBrowseBchCode,tTaxNumberFull);
                    }
                    
                }

            },
            error: function (jqXHR, textStatus, errorThrown) {
                // JCNxResponseError(jqXHR, textStatus, errorThrown);
                JSxControlGetMassageByServer();
            }
        });

    }

    //อัพเดทของจริง
    // function JSxApprove(ptTaxNumberFull){
    //     var tBrowseBchCode = $('#oetBrowseBchCode').val();
    //     var aPackData = {
    //         tTaxNumberFull  : ptTaxNumberFull,
    //         tBrowseBchCode  : tBrowseBchCode,
    //         dDocDate        : $('#oetTAXDocDate').val(),
    //         dDocTime        : $('#oetTAXDocTime').val(),
    //         tDocABB         : $('#oetTAXABBCode').val(),
    //         tCstCode        : $('#oetTAXCusCode').val(),
    //         tCstName        : $('#oetTAXCusNameCusABB').val()/*$('#oetTAXCusName').val()*/,
    //         tCstNameABB     : $('#oetTAXCusNameCusABB').val(),
    //         tTaxnumber      : $('#oetTAXNumber').val(),
    //         tTypeBusiness   : $('#ocmTAXTypeBusiness option:selected').val(),
    //         tBusiness       : $('#ocmTAXBusiness option:selected').val(),
    //         tBranch         : $('#oetTAXBranch').val(),
    //         tTel            : $('#oetTAXTel').val(),
    //         tFax            : $('#oetTAXFax').val(),
    //         tEmail          : $('#oetTAXEmail').val(),
    //         tAddress1       : $('#otxAddress1').val(),
    //         tAddress2       : $('#otxAddress2').val(),
    //         tReason         : $('#otaTAXRemark').val(),
    //         tSeqAddress     : $('#ohdSeqAddress').val(),
    //         tStaETax        : $('#oetTXIStaETax').val(),
    //         tPosCode        : $('#oetTAXPos').val(),

    //         tAddVersion         : $('input[name=orbTAXAddVersion]:checked').val(),
    //         tAddV1Soi           : $('#oetFTAddV1Soi').val(),
    //         tAddV1Village       : $('#oetFTAddV1Village').val(),
    //         tAddV1Road          : $('#oetFTAddV1Road').val(),
    //         tAddV1PvnCode       : $('#oetFTAddV1PvnCode').val(),
    //         tAddV1DstCode       : $('#oetFTAddV1DstCode').val(),
    //         tAddV1SubDistCode   : $('#oetFTAddV1SubDistCode').val(),
    //         tAddV1PostCode      : $('#oetFTAddV1PostCode').val(),
    //     };

    //     if(ptTaxNumberFull == '' || ptTaxNumberFull == null){
    //         //เลขที่ใบกำกับภาษีไม่ได้
    //         FSvCMNSetMsgWarningDialog('เกิดข้อผิดพลาด:908 ไม่สามารถบันทึกใบกำกับภาษีได้');
    //     }else{
    //         $.ajax({
    //             type    : "POST",
    //             url     : "dcmTXINApprove",
    //             cache   : false,
    //             data    : { 'aPackData' : aPackData , 'tType' : 'insert' },
    //             Timeout : 0,
    //             success : function (oResult) {
    //                 var oReturn = JSON.parse(oResult);
    //                 console.log(oReturn);
    //                 if(oReturn.nStaEvent == 500){
    //                     FSvCMNSetMsgWarningDialog('เกิดข้อผิดพลาด กรุณาลองทำรายการใหม่อีกครั้ง');
    //                 }else if(oReturn.nStaEvent == 550){
    //                     JSvTAXLoadPageAddOrPreview(tBrowseBchCode,oReturn.tXshDocVatFull);
    //                 }else if(aResult.nStaEvent == 800){
    //                     JSvCMNSetMsgErrorDialog(aResult.tStaMessg);
    //                 }else{
    //                     console.log('กำลังลบ Q : ' + oResult);
    //                     FSvCMNSetMsgSucessDialog('สร้างเอกสารใบกำกับภาษีสมบูรณ์');
    //                     JSvTAXLoadPageAddOrPreview(tBrowseBchCode,ptTaxNumberFull);
    //                 }

    //                 // console.log('กำลังลบ Q : ' + oResult);
    //                 // alert('สร้างเอกสารใบกำกับภาษีสมบูรณ์');
    //                 // JSvTAXLoadPageAddOrPreview(ptTaxNumberFull);
    //             },
    //             error: function (jqXHR, textStatus, errorThrown) {
    //                 JCNxResponseError(jqXHR, textStatus, errorThrown);
    //             }
    //         });
    //     }
    // }

    //ตรวจสอบก่อนพิมพ์ - เต็มรูป
    function JSxTaxPrintPreviewDoc(){
        var tDocBCH            = $('#ohdBCHDocument').val();
        var tDocCode        = $('#oetTAXDocNo').val();
        var tGrandText      = $("#olbGrandText").text();
        var tTypeABB        = $("#oetTAXABBTypeDocuement").val();
        var tOrginalRight   = 0;
        var tCopyRight      = 0;
        var tPrintByPage    = 1;

        //เอาสาขาไปค้นหาก่อนว่ามีที่อยู่ยังถ้ายังต้องเอาสาขาของที่อยู่ส่งไปหา from
        $.ajax({
            type    : "POST",
            url     : "dcmTXINCheckBranchInComp",
            cache   : false,
            async   : true,
            data    : { 'tBCH' : $('#ohdBCHDocument').val() },
            Timeout : 0,
            success : function (tResult) {
                var oResult         = JSON.parse(tResult);
                var tBCH            = oResult.tBCH;
                var aInfor = [
                    {"Lang"         : '<?=FCNaHGetLangEdit(); ?>'},
                    {"ComCode"      : '<?=FCNtGetCompanyCode(); ?>'},
                    {"BranchCode"   : tBCH},
                    {"DocCode"      : tDocCode},
                    {"DocBchCode"   : tDocBCH}
                ];

                if(tTypeABB == 4){//เอกสารขาย
                    window.open("<?=base_url(); ?>formreport/TaxInvoice?StaPrint=0&infor=" + JCNtEnCodeUrlParameter(aInfor) + "&Grand="+tGrandText + "&PrintOriginal="+tOrginalRight + "&PrintCopy="+tCopyRight + "&PrintByPage=" + 'ALL' , '_blank');
                }else{ //เอกสารคืน
                    window.open("<?=base_url(); ?>formreport/TaxInvoice_refund?StaPrint=0&infor=" + JCNtEnCodeUrlParameter(aInfor) + "&Grand="+tGrandText + "&PrintOriginal="+tOrginalRight + "&PrintCopy="+tCopyRight + "&PrintByPage=" + 'ALL', '_blank');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    //ปริ้นเอกสาร - เต็มรูป
    function JSxTaxPrintDoc(){

        $('#odvModalPrintDocument').modal('show');

        $('#obtConfirmPrintFullTax').off();
        $('#obtConfirmPrintFullTax').on('click',function(){
            var nValue = $('input[name=orbPrint]:checked').val();

            if(nValue == 2){ //พิมพ์บางหน้า
                var nOnlyPage = $('#oetPrintAgain').val();
                if(nOnlyPage == '' || nOnlyPage == null){
                    var nPrintOnlyPage = 1;
                }else{
                    var nPrintOnlyPage = nOnlyPage;
                }
            }else{
                var nPrintOnlyPage = 'ALL';
            }

            var tDocBCH            = $('#ohdBCHDocument').val();
            var tDocCode        = $('#oetTAXDocNo').val();
            var tGrandText      = $("#olbGrandText").text();
            var tTypeABB        = $("#oetTAXABBTypeDocuement").val();
            var tOrginalRight   = '<?=$aAlwConfigForm[0]->FTSysStaUsrValue?>';
            var tCopyRight      = '<?=$aAlwConfigForm[0]->FTSysStaUsrRef?>';
            var nPrintOnlyPage  = nPrintOnlyPage;

            //เอาสาขาไปค้นหาก่อนว่ามีที่อยู่ยังถ้ายังต้องเอาสาขาของที่อยู่ส่งไปหา from
            $.ajax({
                type    : "POST",
                url     : "dcmTXINCheckBranchInComp",
                cache   : false,
                async   : true,
                data    : { 'tBCH' : $('#ohdBCHDocument').val() },
                Timeout : 0,
                success : function (tResult) {
                    var oResult         = JSON.parse(tResult);
                    var tBCH            = oResult.tBCH;
                    var aInfor = [
                        {"Lang"         : '<?=FCNaHGetLangEdit(); ?>'},
                        {"ComCode"      : '<?=FCNtGetCompanyCode(); ?>'},
                        {"BranchCode"   : tBCH},
                        {"DocCode"      : tDocCode},
                        {"DocBchCode"   : tDocBCH}
                    ];
                    // console.log(aInfor);
                    JCNxOpenLoading();

                    if(tTypeABB == 4){//เอกสารขาย
                        $("#oifPrint").prop('src', "<?=base_url();?>formreport/TaxInvoice?StaPrint=1&infor=" + JCNtEnCodeUrlParameter(aInfor) + "&Grand="+tGrandText + "&PrintOriginal="+tOrginalRight + "&PrintCopy="+tCopyRight + "&PrintByPage=" + nPrintOnlyPage);
                    }else{ //เอกสารคืน
                        $("#oifPrint").prop('src', "<?=base_url();?>formreport/TaxInvoice_refund?StaPrint=1&infor=" + JCNtEnCodeUrlParameter(aInfor) + "&Grand="+tGrandText + "&PrintOriginal="+tOrginalRight + "&PrintCopy="+tCopyRight + "&PrintByPage=" + nPrintOnlyPage);
                    }

                    JCNxCloseLoading();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });

        });
    }

    //ปริ้นเอกสาร - อย่างย่อ
    function JSxTaxPrintPreviewDocABB(){
        var tDocBCH            = $('#ohdBCHDocument').val();
        var tCode = $('#oetTAXABBCode').val();
        if(tCode == ''){
            $('#oetTAXABBCode').focus();

            var tCheckDisabled = $('#oetTAXABBCode').is('[disabled=disabled]');
            if(tCheckDisabled == true){
                FSvCMNSetMsgWarningDialog('ไม่พบเลขที่ใบกำกับภาษีอย่างย่อ');
            }else{
                $('#oetTAXABBCode').focus();
            }
        }else{

            //เอาสาขาไปค้นหาก่อนว่ามีที่อยู่ยังถ้ายังต้องเอาสาขาของที่อยู่ส่งไปหา from
            $.ajax({
                type    : "POST",
                url     : "dcmTXINCheckBranchInComp",
                cache   : false,
                async   : true,
                data    : { 'tBCH' : $('#ohdBCHDocument').val() },
                Timeout : 0,
                success : function (tResult) {
                    var oResult         = JSON.parse(tResult);
                    var tBCH            = oResult.tBCH;
                    var tDocCode        = $('#oetTAXABBCode').val();
                    var tGrandText      = $("#olbGrandText").text();

                    var aInfor = [
                        {"Lang"         :'<?=FCNaHGetLangEdit(); ?>'},
                        {"ComCode"      :'<?=FCNtGetCompanyCode(); ?>'},
                        {"BranchCode"   :tBCH},
                        {"DocCode"      :tDocCode},
                        {"DocBchCode":tDocBCH}
                    ];

                    JCNxOpenLoading();

                    $("#oifPrintABB").prop('src', "<?=base_url();?>formreport/InvoiceSaleABB?infor=" + JCNtEnCodeUrlParameter(aInfor) + "&Grand="+tGrandText);
                    JCNxCloseLoading();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });

        }
    }

    // Call MQ Progress
    function JSxTAXSubscribeMQ(ptTaxDocNo){
        // Document variable
        var tLangCode                   = <?=$this->session->userdata("tLangEdit")?>;
        var tUsrApv                     = '<?=$this->session->userdata("tSesUserCode")?>';
        var tUsrBchCode                 = $("#ohdBCHDocument").val();
        var tDocNo                      = ptTaxDocNo;
        var tPrefix                     = "RESETAX";
        var tStaApv                     = '';
        var tStaDelMQ                   = '1'/*$("#ohdXthStaDelMQ").val()*/;
        var tQName                      = tPrefix + "_" + tDocNo + "_" + tUsrApv;

        // MQ Message Config
        var poDocConfig = {
            tLangCode                   : tLangCode,
            tUsrBchCode                 : tUsrBchCode,
            tUsrApv                     : tUsrApv,
            tDocNo                      : tDocNo,
            tPrefix                     : tPrefix,
            tStaDelMQ                   : tStaDelMQ,
            tStaApv                     : tStaApv,
            tQName                      : tQName,
            tVhostType                  : 'I'
        };

        // Update Status For Delete Qname Parameter
        var poUpdateStaDelQnameParams = {
            ptDocTableName              : "",
            ptDocFieldDocNo             : "",
            ptDocFieldStaApv            : "",
            ptDocFieldStaDelMQ          : "",
            ptDocStaDelMQ               : tStaDelMQ,
            ptDocNo                     : tDocNo
        };

        // Callback Page Control(function)
        var poCallback = {
            tCallPageEdit               : "JSxTAXEventCallBackMQ",
            tCallPageList               : "JSvTAXCallPageTaxinvoice"
        };

        //Check Show Progress %
        FSxCMNRabbitMQMessage(
            poDocConfig,
            '',
            poUpdateStaDelQnameParams,
            poCallback
        );

    }

    function JSxTAXEventCallBackMQ(poObj){
        // console.log(poObj);
        var oResponse = poObj;
        // var oResponse   = JSON.parse(poObj);
        // console.log(oResponse);

        // ขา insert ดึงจาก session bch default
        // ขา edit ดึงจาก HD
        var tUsrBchCode = $("#ohdBCHDocument").val();
        if( tUsrBchCode == '' ){
            tUsrBchCode = $('#oetBrowseBchCode').val();
        }
        switch(oResponse['rtStatus']){
            case '1':
                JSvTAXLoadPageAddOrPreview(tUsrBchCode,oResponse['rtDocNo']);
                break;
            case '2':
                FSvCMNSetMsgWarningDialog('<?=language('document/document/document','tDocETaxErrorPC')?>','JSvTAXLoadPageAddOrPreview',tUsrBchCode);
                $('#odvModalBodyWanning .xWBtnOK').attr('onclick',"JSvTAXLoadPageAddOrPreview('"+tUsrBchCode+"','"+oResponse['rtDocNo']+"')");
                break;
            default:
                FSvCMNSetMsgWarningDialog(oResponse['rtMsgError'],'JSvTAXLoadPageAddOrPreview',tUsrBchCode);
                $('#odvModalBodyWanning .xWBtnOK').attr('onclick',"JSvTAXLoadPageAddOrPreview('"+tUsrBchCode+"','"+oResponse['rtDocNo']+"')");
                JCNxCloseLoading();
        }
    }

</script>
