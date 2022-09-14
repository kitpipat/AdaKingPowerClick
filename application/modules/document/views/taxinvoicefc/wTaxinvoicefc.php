<div id="odvTAXMainMenu">
    <div class="main-menu">
        <div class="xCNMrgNavMenu">
            <div class="row xCNavRow" style="width:inherit;">
                <div class="col-xs-12 col-sm-4 col-md-6 col-lg-6">
                    <ol class="breadcrumb">
                        <?php FCNxHADDfavorite('dcmTXFC/0/0');?>
                        <li style="cursor:pointer;"  onclick="JSvTAXCallPageTaxinvoice()"><?=language('document/taxinvoicefc/taxinvoicefc', 'tTitleMenu'); ?></li>
                        <li class="active xCNCreate xCNHide"><a><?= language('document/taxinvoicefc/taxinvoicefc', 'tCreate'); ?></a></li>
                    </ol>
                </div>
                <div class="col-xs-12 col-sm-8 col-md-6 col-lg-6 text-right p-r-0">
                    <div class="xCNBtngroup" style="width:100%;">
                        <div>
                            <div style="width:100%;">
                                <button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button" id="obtPrintPreviewDocumentABB" onclick="JSxTaxPrintPreviewDocABB();"><?=language('document/taxinvoicefc/taxinvoicefc', 'tTAXPrintABB'); ?></button>
                                <button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button" id="obtCancleDocument"><?=language('common/main/main', 'tCancel'); ?></button>
                                <button class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button" id="obtApproveDocument"><?=language('common/main/main', 'tCMNApprove'); ?></button>
                                <button class="btn xCNBTNDefult xCNBTNDefult2Btn xCNHide" type="button" id="obtPrintDocument" onclick="JSxTaxPrintDoc();"><?=language('document/taxinvoicefc/taxinvoicefc', 'tTAXPrint'); ?></button>
                                <button class="btn xCNBTNDefult xCNBTNDefult2Btn xCNHide" type="button" id="obtPrintPreviewDocument" onclick="JSxTaxPrintPreviewDoc();"><?=language('document/taxinvoicefc/taxinvoicefc', 'tTAXPrintPreview'); ?></button>
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
                <label class="xCNTextModalHeard" style="font-weight: bold; font-size: 20px;"><?=language('document/taxinvoicefc/taxinvoicefc', 'tTAXwarning')?></label>
			</div>
			<div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
						<span><?=language('document/taxinvoicefc/taxinvoicefc', 'tTAXCancleDoucment')?></span>
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
                        <li><?=language('document/taxinvoicefc/taxinvoicefc','tMainApproveStatus1'); ?></li>
                        <li><?=language('document/taxinvoicefc/taxinvoicefc','tMainApproveStatus2'); ?></li>
                        <li><?=language('document/taxinvoicefc/taxinvoicefc','tMainApproveStatus3'); ?></li>
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
                    <label class="form-check-label" for="orbPrint1">&nbsp;<?=language('document/taxinvoicefc/taxinvoicefc', 'tTAXPrintAll'); ?></label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input xCNRadioPrint" type="radio" name="orbPrint"  id="orbPrint2" value="2">
                    <label class="form-check-label" for="orbPrint2">&nbsp;<?=language('document/taxinvoicefc/taxinvoicefc', 'tTAXPrintBypage'); ?></label>
                </div>

                <div class="form-group xCNPrintByPage" style="display:none;">
                    <label class="xCNLabelFrm" style="margin-top: 5px;"><?=language('document/taxinvoicefc/taxinvoicefc', 'tTAXPrintBypageKey'); ?></label>
                    <input type="text" class="form-control xWTooltipsBT xCNInputWithoutSpcNotThai xCNInputWithoutSingleQuote xCNInputNumericWithDecimal" id="oetPrintAgain" name="oetPrintAgain" maxlength="2" value=""
                            placeholder="<?=language('document/taxinvoicefc/taxinvoicefc', 'tTAXPrintBypageKey'); ?>">
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
    });

    //โหลดหน้าจอ list
    JSxLoadContentList();
    function JSxLoadContentList(){
        $.ajax({
            type    : "POST",
            url     : "dcmTXFCLoadList",
            cache   : false,
            Timeout : 0,
            success : function (oResult) {
                $('#odvTaxContentPageDocument').html(oResult);
                JCNxCloseLoading();
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
            url     : "dcmTXFCLoadPageAdd",
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
        if($('#oetTAXDocDate').val() == ''){
            $('#oetTAXDocDate').focus();
            return;
        }

        if($('#oetTAXDocTime').val() == ''){
            $('#oetTAXDocTime').focus();
            return;
        }

        if($('#oetTAXABBCode').val() == ''){
            $('#oetTAXABBCode').focus();
            return;
        }

        if($('#oetTAXCusNameCusABB').val() == ''){
            $('#oetTAXCusNameCusABB').focus();
            return;
        }

        if($('#oetTAXNumber').val() == ''){
            $('#oetTAXNumber').focus();
            return;
        }

        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof nStaSession !== "undefined" && nStaSession == 1){
            try{

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
                        tDocABB : $('#oetTAXABBCode').val(),
                        tBrowseBchCode : $('#oetBrowseBchCode').val()
                    }

                    //ส่งเข้า Q ไปหาเลขที่เอกสารก่อน
                    $.ajax({
                        type    : "POST",
                        url     : "dcmTXFCApprove",
                        cache   : false,
                        data    : { 'aPackData' : aPackData , 'tType' : 'MQ'},
                        Timeout : 0,
                        success : function (oResult) {
                          aResult = JSON.parse(oResult);
                          if(aResult.nStaEvent == 500){
                                alert('เกิดข้อผิดพลาด กรุณาลองทำรายการใหม่อีกครั้ง');
                            }else if(aResult.nStaEvent == 550){
                                alert('เกิดข้อผิดพลาด กรุณาลองตรวจสอบเลขที่ใบกำกับภาษีอย่างย่อ ใหม่อีกครั้ง');
                                $('#odvModalAproveDocument').modal("hide");
                                $('#obtConfirmApprDoc').attr("disabled",false);
                                $('#obtApproveDocument').attr("disabled",false);
                                //JCNxOpenLoading();

                            }else{
                                $('#odvModalAproveDocument').modal("hide");
                                $('#obtConfirmApprDoc').attr("disabled",false);
                                $('#obtApproveDocument').attr("disabled",false);
                                var tBCH    = aResult.tBCHDoc;
                                var tDoctype    = aResult.tDoctype;
                                JCNxOpenLoading();
                                var tDocABB = $('#oetTAXABBCode').val();
                                JSxINMSubScribeQName(tBCH,tDoctype);
                            }

                        },
                        error: function (jqXHR, textStatus, errorThrown) {
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
    });

    //วิ่งเข้า MQ หาเลขที่เอกสาร
    function JSxINMSubScribeQName(ptBCH,ptDocType){
        // var tUserCode  = '<?=$this->session->userdata("tSesUserCode")?>';
        // var oImnclient = Stomp.client('ws://' + oSTOMMQConfig.host +':15674/ws');
        // var on_connect = function(x){
        //     oImnclient.subscribe('/queue/CN_QRetGenTaxNo_'+ptDocumentNumber+'_'+tUserCode,function(res){
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

        //         oImnclient.disconnect();
        //     });
        // }
        // var on_error = function(x) {
        //     console.log(x);
        // }
        // oImnclient.connect(oSTOMMQConfig.user, oSTOMMQConfig.password, on_connect, on_error, oSTOMMQConfig.vhost);

    var tUserCode  = '<?=$this->session->userdata("tSesUserCode")?>';
    var tTaxQname =  'CN_QRetGenTaxNo_'+ptBCH+'_'+ptDocType;

    oGetResponse = setInterval(function() {
        $.ajax({
        url     : 'GetMassageQueue',
        type    : 'post',
        data    : {tQName:tTaxQname},
        success:function(res){
            try {
                let aRes = JSON.parse(res.trim());
                console.log(aRes);

                if(aRes.rtCode == '001'){
                    $('#oetTAXDocNo').val(aRes.rtDocNo);

                    //ปิดปุ่ม ย้อนกลับ + อนุมัติ // เปิดปุ่ม พิมพ์ + เพิ่มใหม่
                    $('#obtCancleDocument').addClass('xCNHide');
                    $('#obtApproveDocument').addClass('xCNHide');
                    $('#obtPrintDocument').removeClass('xCNHide');
                    $('#obtPrintPreviewDocument').removeClass('xCNHide');
                    $('#obtSaveDocument').removeClass('xCNHide');
                    JSxApprove(aRes.rtDocNo);
                    JCNxCloseLoading();
                    JSxTaxStopCalling();
                }else{
                    alert('Something worng !')
                }

            } catch (err) {
                console.log("Listening rabbit mq server: ", err);
            }
          }
            });

         }, 3000); //10000 milliseconds = 10 seconds



    }



    function JSxTaxStopCalling() {
         clearInterval(oGetResponse);
    }


    //อัพเดทของจริง
    function JSxApprove(ptTaxNumberFull){
        var tBrowseBchCode  = $('#oetBrowseBchCode').val();
        var aPackData = {
            tBrowseBchCode  : $('#oetBrowseBchCode').val(),
            tTaxNumberFull  : ptTaxNumberFull,
            dDocDate        : $('#oetTAXDocDate').val(),
            dDocTime        : $('#oetTAXDocTime').val(),
            tDocABB         : $('#oetTAXABBCode').val(),
            tCstCode        : $('#oetTAXCusCode').val(),
            tCstName        : $('#oetTAXCusName').val(),
            tCstNameABB     : $('#oetTAXCusNameCusABB').val(),
            tTaxnumber      : $('#oetTAXNumber').val(),
            tTypeBusiness   : $('#ocmTAXTypeBusiness option:selected').val(),
            tBusiness       : $('#ocmTAXBusiness option:selected').val(),
            tBranch         : $('#oetTAXBranch').val(),
            tTel            : $('#oetTAXTel').val(),
            tFax            : $('#oetTAXFax').val(),
            tAddress1       : $('#otxAddress1').val(),
            tAddress2       : $('#otxAddress2').val(),
            tReason         : $('#otxReason').val(),
            tSeqAddress     : $('#ohdSeqAddress').val()
        };

        if(ptTaxNumberFull == '' || ptTaxNumberFull == null){
            //เลขที่ใบกำกับภาษีไม่ได้
            alert('เกิดข้อผิดพลาด:908 ไม่สามารถบันทึกใบกำกับภาษีได้');
        }else{
            $.ajax({
                type    : "POST",
                url     : "dcmTXFCApprove",
                cache   : false,
                data    : { 'aPackData' : aPackData , 'tType' : 'insert' },
                Timeout : 0,
                success : function (oResult) {
                    var oReturn = JSON.parse(oResult);
                    console.log(oReturn);
                    if(oReturn.nStaEvent == 500){
                        alert('เกิดข้อผิดพลาด กรุณาลองทำรายการใหม่อีกครั้ง');
                    }else{
                        console.log('กำลังลบ Q : ' + oResult);
                        alert('สร้างเอกสารใบกำกับภาษีสมบูรณ์');
                        JSvTAXLoadPageAddOrPreview(tBrowseBchCode,tTaxNumberFull);
                    }

                    // console.log('กำลังลบ Q : ' + oResult);
                    // alert('สร้างเอกสารใบกำกับภาษีสมบูรณ์');
                    // JSvTAXLoadPageAddOrPreview(ptTaxNumberFull);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }
    }

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
            url     : "dcmTXFCCheckBranchInComp",
            cache   : false,
            async   : true,
            data    : { 'tDocBch' : $('#ohdBCHDocument').val() },
            Timeout : 0,
            success : function (tResult) {
                var oResult         = JSON.parse(tResult);
                var tBCH            = oResult.tBCH;
                
                var aInfor = [
                    {"Lang":'<?=FCNaHGetLangEdit(); ?>'},
                    {"ComCode":'<?=FCNtGetCompanyCode(); ?>'},
                    {"BranchCode":tBCH},
                    {"DocCode":tDocCode},
                    {"DocBchCode":tDocBCH}
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
                url     : "dcmTXFCCheckBranchInComp",
                cache   : false,
                async   : true,
                data    : { 'tDocBch' : $('#ohdBCHDocument').val() },
                Timeout : 0,
                success : function (tResult) {
                    var oResult         = JSON.parse(tResult);
                    var tBCH            = oResult.tBCH;
                    
                    var aInfor = [
                        {"Lang":'<?=FCNaHGetLangEdit(); ?>'},
                        {"ComCode":'<?=FCNtGetCompanyCode(); ?>'},
                        {"BranchCode":tBCH},
                        {"DocCode":tDocCode},
                        {"DocBchCode"    :tDocBCH}
                    ];
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

        var tCode = $('#oetTAXABBCode').val();
        if(tCode == ''){
            $('#oetTAXABBCode').focus();

            var tCheckDisabled = $('#oetTAXABBCode').is('[disabled=disabled]');
            if(tCheckDisabled == true){
                alert('ไม่พบเลขที่ใบกำกับภาษีอย่างย่อ');
            }else{
                $('#oetTAXABBCode').focus();
            }
        }else{
            var tDocBCH            = $('#ohdBCHDocument').val();
            var tDocCode        = $('#oetTAXABBCode').val();
            var tGrandText      = $("#olbGrandText").text();

             //เอาสาขาไปค้นหาก่อนว่ามีที่อยู่ยังถ้ายังต้องเอาสาขาของที่อยู่ส่งไปหา from
             $.ajax({
                type    : "POST",
                url     : "dcmTXFCCheckBranchInComp",
                cache   : false,
                async   : true,
                data    : { 'tDocBch' : $('#ohdBCHDocument').val() },
                Timeout : 0,
                success : function (tResult) {
                    var oResult         = JSON.parse(tResult);
                    var tBCH            = oResult.tBCH;
                    
                    var aInfor = [
                        {"Lang":'<?=FCNaHGetLangEdit(); ?>'},
                        {"ComCode":'<?=FCNtGetCompanyCode(); ?>'},
                        {"BranchCode":tBCH},
                        {"DocCode":tDocCode},
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

</script>
