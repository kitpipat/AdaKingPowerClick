<style>
    .xWIMPSALHeadPanel{
        border-bottom:1px solid #cfcbcb8a !important;
        padding-bottom:0px !important;
    }

    .xWIMPSALTextNumber{
        font-size: 25px !important;
        font-weight: bold;
    }
    
    .xWIMPSALPanelMainRight{
        padding-bottom:0px;
        min-height:300px;
        overflow-x: auto;
    }

    .xWIMPSALFilter{
        cursor: pointer;
    }

    .xWIMPSALRequest{
        cursor: pointer;
    }
    .xWOverlayLodingChart{
        position: absolute;
	    min-width: 100%;
	    min-height: 100%;
	    width: 100%;
	    background: #FFFFFF;
	    z-index: 2500;
	    display: none;
	    top: 0%;
        margin-left: 0px;
        left: 0%;
    }
</style>

<div class="col-xs-12 col-md-12 col-lg-12">
  

    <div class="row ">
    <div class="col-xs-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="xCNLabelFrm"><?=language('sale/salemonitor/salemonitor', 'tSTLToolsOption')?></label>
                            <select class=" form-control "  name="ocbSTLOptionType" id="ocbSTLOptionType">
                            <option value="1" ><?=language('sale/salemonitor/salemonitor', 'tSTLToolsCheckSaleShift')?></option>
                            <option value="2" selected><?=language('sale/salemonitor/salemonitor', 'tSTLToolsImportBill')?></option>
                            </select>
                </div>
     </div>    

     <div class="col-xs-12 col-md-6 col-lg-6">
            <div class="form-group">
             <label class="xCNLabelFrm"><?=language('sale/salemonitor/salemonitor', 'tIMPImportBill')?></label>
                <div class="input-group input-file" name="Fichier1">
                    <input type="text" class="form-control" placeholder='<?=language('sale/salemonitor/salemonitor', 'tIMPISelectBrowsFile')?>' />			
                    <span class="input-group-btn">
                     <button class="btn btn-info btn-choose" type="button"><i class="fa fa-folder-open" aria-hidden="true"></i> &nbsp;<?=language('sale/salemonitor/salemonitor', 'tIMPISelectBrows')?></button>
                    </span>
                </div>
            </div>
     </div>   

      <div class="col-xs-12 col-md-2 col-lg-2 text-right" style="margin-top:25px;">   
            <button type="button" id="obtConfirmImport" class="btn btn-primary xCNBTNMngTable" data-toggle="dropdown">
            <i class="fa fa-cloud-upload" aria-hidden="true"></i> &nbsp; <?=language('sale/salemonitor/salemonitor', 'tIMPIImportConfirm')?>			
            </button>
      </div>
     </div>




    <div class="row"   id="odvImportDataPageFrom">


    </div>


</div>

<script type="text/javascript">
    $(document).ready(function(){
        // JCNxCloseLoading();

        function JSvIMPInputFile() {
            $(".input-file").before(
                function() {
                    if ( ! $(this).prev().hasClass('input-ghost') ) {
                        var oElement = $("<input type='file' name='oefSaleImportBillFile' id='oefSaleImportBillFile' class='input-ghost' style='visibility:hidden; height:0'>");
                        oElement.attr("name",$(this).attr("name"));
                        oElement.change(function(){
                            oElement.next(oElement).find('input').val((oElement.val()).split('\\').pop());
                        });
                        $(this).find("button.btn-choose").click(function(){
                            oElement.click();
                        });
                        $(this).find("button.btn-reset").click(function(){
                            oElement.val(null);
                            $(this).parents(".input-file").find('input').val('');
                        });
                        $(this).find('input').css("cursor","pointer");
                        $(this).find('input').mousedown(function() {
                            $(this).parents('.input-file').prev().click();
                            return false;
                        });
                        return oElement;
                    }
                }
            );
    }
    $(function() {
        JSvIMPInputFile();
    });

        JCNxIMPCallPageFrom();
    });

            // Function: Confirm Filter DashBoard
            // Parameters: Document Ready Or Parameter Event
            // Creator: 06/02/2020 Nattakit
            // Return: View Data Table
            // ReturnType: View
            function JCNxIMPCallPageFrom(){
                $.ajax({
                    type: "POST",
                    url: "dasIMPCallPageFrom",
                    data: {tIMPSearch:''},
                    cache: false,
                    timeout: 0,
                    success : function(paDataReturn){
                        $('#odvImportDataPageFrom').html(paDataReturn);
                        JCNxCloseLoading();
                    },
                    error : function (jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR,textStatus,errorThrown);
                    }
                });
            }



$('#obtConfirmImport').click(function(){
        if(confirm('<?=language('sale/salemonitor/salemonitor', 'tIMPIImportConfirmDecistion')?>')==true){
            JCNxOpenLoading();
            var tImpXthDocNo = $('#oetXthDocNo').val();
            $.ajax({
                    type: "POST",
                    url: "dasIMPInsertBillData",
                    data: {tImpXthDocNo:tImpXthDocNo},
                    cache: false,
                    timeout: 0,
                    success : function(paDataReturn){
                        var paDataReturn = JSON.parse(paDataReturn);
                        if(paDataReturn['nStaEvent']==1){
                         JCNxCloseLoading();
                         FSvCMNSetMsgSucessDialog('<?=language('sale/salemonitor/salemonitor', 'tIMPIImportSuccess')?>');
                        }
                    },
                    error : function (jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR,textStatus,errorThrown);
                    }
                });

        }
});


$('#ocbSTLOptionType').change(function(){
      var  nSTLOptionType = $(this).val();

      if(nSTLOptionType==1){
        JCNxSMTCallSaleTools();
      }else{
        JCNxSMTCallSaleImport();
      }
})

function JSxSaleImportUploadFile(){

    var file_data = $('#oefSaleImportBillFile').prop('files')[0];   
    var form_data = new FormData();                  
    form_data.append('oefSaleImportBillFile', file_data);
    // alert(form_data);                             
    $.ajax({
        url: 'dasIMPUploadFile', // point to server-side PHP script 
        dataType: 'text',  // what to expect back from the PHP script, if anything
        cache: false,
        Timeout : 0,
        contentType: false,
        processData: false,
        data: form_data,                         
        type: 'post',
        success: function(res){
            JCNxCloseLoading();
         var paDataReturn = JSON.parse(res);
           if(paDataReturn['nStaEvent']=='1'){
            FSvCMNSetMsgSucessDialog(paDataReturn['tStaMessg']);
            JSxIMPRanderHDDT(paDataReturn['tCodeReturn'],1);
           }else{
            FSvCMNSetMsgErrorDialog(paDataReturn['tStaMessg']);
           }
            // alert(res); 
            // display response from the PHP script, if any
        },
        error: function (jqXHR, textStatus, errorThrown) {
                // JCNxResponseError(jqXHR, textStatus, errorThrown);
                JSxSaleImportUploadFile();
            }
     });
}

    //rander view - HD DT (รายละเอียด)
    function JSxIMPRanderHDDT(ptDocumentNumber,pnPage){

        JCNxOpenLoading();

        var tSearchPDT = $('#oetSearchSpaPdtPri').val();

        $.ajax({
            type    : "POST",
            url     : "dasIMPLoadDatatable",
            data    : { 'tDocumentNumber' : ptDocumentNumber , 'tSearchPDT' : tSearchPDT , 'nPage' : pnPage },
            cache   : false,
            Timeout : 0,
            success : function (oResult) {
                var tHTML = JSON.parse(oResult);
                $('#odvImpDataTable').html(tHTML['tContentPDT']);
                $('#odvRowDataEndOfBill').html(tHTML['tContentSumFooter']);
                JCNxCloseLoading();

                //เอาข้อมูล HD มาลง
                var aHD = tHTML['aDetailHD'];
                if(aHD.rtCode == '800'){
                    //ไม่พบข้อมูล
                    $('#oetTAXTypeVat').val('');
                    $('#oetTAXCountPrint').val(0);
                    $('#oetTAXTypepay').val('');
                    $('#oetTAXPos').val('');
                    $('#oetTAXRefIntDoc').val('');
                    $('#oetTAXRefIntDocDate').val('');
                    $('#oetTAXRefExtDoc').val('');
                    $('#oetTAXRefExtDocDate').val('');
                    $('#otxReason').text('');

                    //ข้อมูลส่วนที่อยู่
                    $('#oetTAXCusNameCusABB').val('');
                    $('#oetTAXNumber').val('');
                    $('#otxAddress1').val('');
                    $('#otxAddress2').val('');
                    $('#oetTAXTel').val('');
                    $('#oetTAXFax').val('');
                    $('#oetTAXBranch').val('');
                    $('#ocmTAXTypeBusiness option[value=1]').attr('selected','selected');
                    $('#ocmTAXBusiness option[value=1]').attr('selected','selected');
                    $('.selectpicker').selectpicker('refresh');
                }else{
                    var tTypeVAT    = aHD.raItems[0].FTXshVATInOrEx //ประเภท
                    var tPrintCount = aHD.raItems[0].FNXshDocPrint //ปริ้น 
                    var tTypePay    = aHD.raItems[0].FTXshCshOrCrd //ชำระโดย
                    var tPoscode    = aHD.raItems[0].FTPosCode //รหัสเครื่องจุดขาย
                    var tRefExt     = (aHD.raItems[0].FTXshRefExt == null ) ? '-' : aHD.raItems[0].FTXshRefExt; //อ้างอิงเอกสารภายนอก
                    var tRefExtDate = (aHD.raItems[0].FDXshRefExtDate == null ) ? '-' : aHD.raItems[0].FDXshRefExtDate; //วันที่เอกสารภายนอก
                    var tRefInt     = (aHD.raItems[0].FTXshRefInt == null ) ? '-' : aHD.raItems[0].FTXshRefInt; //เลขที่ภายใน
                    var tRefIntDate = (aHD.raItems[0].FDXshRefIntDate == null ) ? '-' : aHD.raItems[0].FDXshRefIntDate; //วันภายใน
                    var tRemark     = aHD.raItems[0].FTXshRmk //หมายเหตุ
                    var tGndText    = aHD.raItems[0].FTXshGndText //จำนวนเงินเปนตัวอักษร
                    var tDocNo      = aHD.raItems[0].FTXshDocNo //เลขที่เอกสาร
                    var tBchCode    = aHD.raItems[0].FTBchCode //รหัสสาขา
                    var tDocDate    = aHD.raItems[0].FDXshDocDate //วันที่เอกสาร
                    var tStaDoc    = aHD.raItems[0].FTXshStaDoc //สถานะเอกสาร
                    var tCstCode    = aHD.raItems[0].FTCstCode //รหัสลูกค้า
                    var tCstName    = aHD.raItems[0].FTXshCstName //ชื่อลูกค้า
                    var tBchName    = aHD.raItems[0].FTBchName //ชื่อลูกค้า              
                    
                    if(tTypeVAT == 1){ var tTypeVAT = 'รวมใน' }else{ var tTypeVAT = 'แยกนอก' }
                    $('#oetTAXTypeVat').val(tTypeVAT);
                    $('#oetTAXCountPrint').val(tPrintCount);
                    if(tTypePay == 1){ var tTypePay = 'เงินสด' }else{ var tTypePay = 'เครดิต' }
                    $('#oetTAXTypepay').val(tTypePay);
                    $('#oetTAXPos').val(tPoscode);
                    $('#oetTAXRefIntDoc').val(tRefInt);
                    $('#oetTAXRefIntDocDate').val(tRefIntDate);
                    $('#oetTAXRefExtDoc').val(tRefExt);
                    $('#oetTAXRefExtDocDate').val(tRefExtDate);
                    $('#otxDataRemark').text(tRemark);
                    $('#odvDataTextBath').text(tGndText);
                    $('#oetXthDocNo').val(tDocNo);
                    $('#oetXthDocDate').val(tDocDate);
                    $('#oetBchName').val(tBchName);
                    if(tStaDoc == 1){ var tStaDocText = 'เอกสารสมบูรณ์' }else{ var tStaDocText = '-' }
                    $('#oetStaDoc').val(tStaDocText);
                    $('#oetCstCode').val(tCstCode);
                    $('#oetCstName').val(tCstName);
                    
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }


$('#oefSaleImportBillFile').on('change',function(){
    if($(this).val()!=''){
        JCNxOpenLoading();
        JSxSaleImportUploadFile();
    }

})
</script>
