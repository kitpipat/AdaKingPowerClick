<div class="table-responsive">
    <table class="table table-hover">
        <thead>
            <tr>
                <th nowrap class="text-center" id="othCheckboxHide" width="3%">
                    <label class="fancy-checkbox">
                        <input id="ocbCheckAll" type="checkbox" class="ocmCENCheckDeleteAll" name="ocbCheckAll" style="margin-right: 0px !important">
                        <span class=""></span>
                    </label>
                </th>
                <th nowrap class="text-center" width="5%"><?= language('monitor/monitor/monitor','tSDTSeq')?></th>
                <th nowrap class="text-center" width="16%"><?= language('monitor/monitor/monitor','tSDaDocNo')?></th>
                <th nowrap class="text-center"><?= language('monitor/monitor/monitor','tSDTDocDate')?></th>
                <th nowrap class="text-center"><?= language('monitor/monitor/monitor','tDOBchFrm')?></th>
                <th nowrap class="text-center"><?= language('monitor/monitor/monitor','tDOBchTo')?></th>
                <th nowrap class="text-center"><?= language('monitor/monitor/monitor','tSDTCreateBy')?></th>
                <th nowrap class="text-center"><?= language('monitor/monitor/monitor','tSDTStaDoc')?></th>
                <th nowrap class="text-center"><?= language('monitor/deliveryorder/deliveryorder','tDODateSent')?></th> <!-- วันที่รับ/ส่งของ -->
                <th nowrap class="text-center" width="5%"><?= language('monitor/monitor/monitor','tSDTInspect')?></th>
            </tr>
        </thead>
        <tbody>
            <?php if (isset($aDODataList['aItems'])) {
                $nSeq = 1; 
                foreach ($aDODataList['aItems'] as $nKey => $aValue) { ?>
                <tr class="xWPdtItem" data-docno="<?=$aValue['FTXshDocNo'];?>" data-bchcode="<?=$aValue['FTBchCode'];?>" data-seq="<?=$nSeq?>">
                    <td class="text-center otdListItem">
                        <label class="fancy-checkbox ">
                            <?php  
                                if( $aValue['FTXshStaDoc'] == '3' || ($aValue['FTXshStaDoc'] == '1' && $aValue['FTXshStaApv'] == '1')  ){
                                    $tCheckboxDisabled = "disabled";
                                    $tClassDisabled = 'xCNDocDisabled';
                                }else{
                                    $tCheckboxDisabled = "";
                                    $tClassDisabled = '';
                                }
                            ?>
                            <input id="ocbListItem<?=$nSeq?>" type="checkbox" class="ocbListItem" name="ocbListItem[]" onclick="FSxDOSelectApvMulti(this)" <?php echo $tCheckboxDisabled;?>>
                            <span class="<?=$tClassDisabled?>">&nbsp;</span>
                        </label>
                    </td>
                    <td class="text-center"><?=$aValue['FNRowID']?></td>
                    <td class="text-left"><?=$aValue['FTXshDocNo']?></td>
                    <td class="text-center"><?=date_format(new DateTime($aValue['FDXshDocDate']),"d/m/Y")?></td>
                    <td class="text-left"><?=($aValue['FTXshBchFrmName'] == '' ? '-' : $aValue['FTXshBchFrmName'])?></td>
                    <td class="text-left"><?=($aValue['FTXshBchToName'] == '' ? '-' : $aValue['FTXshBchToName'])?></td>
                    <td class="text-left"><?=$aValue['FTUsrName']?></td>
                    <td class="text-left">
                        <?php 
                            if ($aValue['FTXshStaDoc'] == 3) {
                                $tClassStaDoc = 'xCNRedColor';
                                $tStaDoc = language('document/document/document', 'tDocStaProDoc3');
                            }else{
                                if ($aValue['FTXshStaDoc'] == 1 && $aValue['FTXshStaApv'] == '') {
                                    $tClassStaDoc = 'xCNYellowColor';
                                    $tStaDoc = language('document/document/document', 'tDocStaProApv');
                                }elseif ($aValue['FTXshStaDoc'] == 1 && $aValue['FTXshStaApv'] == '1') {
                                    $tClassStaDoc = 'xCNGreenColor';
                                    $tStaDoc = language('document/document/document', 'tDocStaProApv1');
                                }else{
                                    $tClassStaDoc = 'xCNYellowColor';
                                    $tStaDoc = language('document/document/document', 'tDocStaProApv2');
                                }
                            }
                        ?>    
                        <label class="xCNTDTextStatus <?php echo $tClassStaDoc;?>">
                            <?php echo $tStaDoc;?>
                        </label>    
                    </td>
                    <td class="text-center">
                        <label class="xCNTDTextStatus xCNGreenColor">
                            <?php
                                if( $aValue['FDXshTnfDate'] != "" ){
                                    echo date_format(new DateTime($aValue['FDXshTnfDate']),"d/m/Y");
                                }else{
                                    echo "-";
                                }
                            ?>
                        </label>
                    </td>
                    <td class="text-center">
                        <img
                            class="xCNIconTable"
                            style="width: 17px;"
                            src="<?=base_url('application/modules/common/assets/images/icons/view2.png')?>"
                            onClick="JSvDOCallPageEdit('<?= $aValue['FTXshDocNo'] ?>')">
                    </td>
                </tr>
                
            <?php $nSeq++; }

                } else { ?>
                    <tr>
                        <td colspan="15" class="text-center"><?php echo language('bank/bank/bank','tBnkNoData'); ?></td>
                    </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<div class="row">
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <p><?php echo language('common/main/main','tResultTotalRecord')?> <?php echo $aDODataList['nAllRow']?> <?php echo language('common/main/main','tRecord')?> <?php echo language('common/main/main','tCurrentPage')?> <?php echo $aDODataList['nCurrentPage']?> / <?php echo $aDODataList['nAllPage']?></p>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <div class="xWDOPageDataTable btn-toolbar pull-right">
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSvDOClickPageList('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>>
                <i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
            </button>

            <?php for($i=max($nPage-2, 1); $i<=max(0, min($aDODataList['nAllPage'],$nPage+2)); $i++){?>
                <?php 
                    if($nPage == $i){ 
                        $tActive = 'active'; 
                        $tDisPageNumber = 'disabled';
                    }else{ 
                        $tActive = '';
                        $tDisPageNumber = '';
                    }
                ?>
                <button onclick="JSvDOClickPageList('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
            <?php } ?>

            <?php if($nPage >= $aDODataList['nAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvDOClickPageList('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>>
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>

<!-- ============================================================== View Modal Approve Multiple Document  ============================================================ -->
<div id="odvDOModalApvDocMultiple" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?php echo language('document/document/document', 'tDocApproveTheDocument') ?></label>
            </div>
            <div class="modal-body">
                <!-- ระบุวันที่ส่ง -->
                <input type="hidden" id="ohdConfirmDODocNoApv" name="ohdConfirmDODocNoApv">
                <input type="hidden" id="ohdConfirmDOBchCodeApv" name="ohdConfirmDOBchCodeApv">
                <label class="xCNLabelFrm"><?php echo language('monitor/deliveryorder/deliveryorder', 'tDOModalApproveRole'); ?></label>
                <div class="input-group">
                    <input
                        class="form-control xCNDatePicker"
                        type="text"
                        id="oetDODateTranfer"
                        name="oetDODateTranfer"
                        placeholder="<?php echo language('monitor/monitor/monitor', 'tDOModalApproveRole'); ?>"
                        value="<?=date('Y-m-d')?>"
                    >
                    <span class="input-group-btn" >
                        <button id="obtDODateTranfer" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                    </span>
                </div>
                <hr>
                <!-- คำเตือนการอนุมัติ -->
                <!-- <span id="ospTextConfirmApvMultiple" class="xCNTextModal" style="display: inline-block; word-break:break-all"></span> -->
                <p><?php echo language('common/main/main', 'tMainApproveStatus'); ?></p>
                <ul>
                    <li><?php echo language('common/main/main', 'tMainApproveStatus1'); ?></li>
                    <li><?php echo language('common/main/main', 'tMainApproveStatus2'); ?></li>
                    <li><?php echo language('common/main/main', 'tMainApproveStatus3'); ?></li>
                    <li><?php echo language('common/main/main', 'tMainApproveStatus4'); ?></li>
                </ul>
                <p><?php echo language('common/main/main', 'tMainApproveStatus5'); ?></p>
                <p><strong><?php echo language('common/main/main', 'tMainApproveStatus6'); ?></strong></p>
            </div>
            <div class="modal-footer">
                <button id="obtConfirmApvDocMultiple" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button"><?php echo language('common/main/main', 'tModalConfirm') ?></button>
                <button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button" data-dismiss="modal"><?php echo language('common/main/main', 'tModalCancel') ?></button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('document').ready(function(){
        $("#obtDOMultiApproveDoc").attr("disabled", true);
    });

    $('#oetDODateTranfer').datepicker({
        format: "yyyy-mm-dd",
        todayHighlight: true,
        enableOnReadonly: false,
        disableTouchKeyboard : true,
        autoclose: true
    });

    $('#obtDODateTranfer').unbind().click(function(){
        $('#oetDODateTranfer').datepicker('show');
    });

    function FSxDOSelectApvMulti(ptElm){

        let tDODocNo        = $(ptElm).parents('.xWPdtItem').data('docno');
        let tDOBchCode      = $(ptElm).parents('.xWPdtItem').data('bchcode');
        var nDOODecimalShow = $('#ohdDOODecimalShow').val();

        $(ptElm).prop('checked', true); 

        let oLocalItemDTTemp    = localStorage.getItem("DO_LocalItemDataApv");
        let oDataObj            = [];
        if(oLocalItemDTTemp){
            oDataObj    = JSON.parse(oLocalItemDTTemp);
        }
        let aArrayConvert   = [JSON.parse(localStorage.getItem("DO_LocalItemDataApv"))];
        if(aArrayConvert == '' || aArrayConvert == null){
            oDataObj.push({
                'aDocNo'    : tDODocNo,
                'aBchCode'  : tDOBchCode
            });
            localStorage.setItem("DO_LocalItemDataApv",JSON.stringify(oDataObj));
            JSxDOTextInModalDelPdtDtTemp();
        }else{
            var aReturnRepeat   = JStDOFindObjectByKey(aArrayConvert[0],'aDocNo',tDODocNo);
            if(aReturnRepeat == 'None' ){
                //ยังไม่ถูกเลือก
                oDataObj.push({
                    'aDocNo'    : tDODocNo,
                    'aBchCode'  : tDOBchCode
                });

                localStorage.setItem("DO_LocalItemDataApv",JSON.stringify(oDataObj));
                JSxDOTextInModalDelPdtDtTemp();
            }else if(aReturnRepeat == 'Dupilcate'){
                localStorage.removeItem("DO_LocalItemDataApv");
                $(ptElm).prop('checked', false);
                var nLength = aArrayConvert[0].length;
                for($i=0; $i<nLength; $i++){
                    if(aArrayConvert[0][$i].aDocNo == tDODocNo){
                        delete aArrayConvert[0][$i];
                    }
                }
                var aNewarraydata   = [];
                for($i=0; $i<nLength; $i++){
                    if(aArrayConvert[0][$i] != undefined){
                        aNewarraydata.push(aArrayConvert[0][$i]);
                    }
                }
                localStorage.setItem("DO_LocalItemDataApv",JSON.stringify(aNewarraydata));
                JSxDOTextInModalDelPdtDtTemp();
            }
        }
        JSxDOShowButtonDelMutiDtTemp();
    }

    // Function: Function Chack Value LocalStorage
    function JStDOFindObjectByKey(array, key, value) {
        for (var i = 0; i < array.length; i++) {
            if (array[i][key] === value) {
                return "Dupilcate";
            }
        }
        return "None";
    }

    // ความคุมปุ่มตัวเลือก -> ลบทั้งหมด
    function JSxDOShowButtonDelMutiDtTemp(){
        var aArrayConvert = [JSON.parse(localStorage.getItem("DO_LocalItemDataApv"))];
        if (aArrayConvert[0] == null || aArrayConvert[0] == ""){
            $("#obtDOMultiApproveDoc").attr("disabled");
        }else{
            var nNumOfArr   = aArrayConvert[0].length;
            if(nNumOfArr > 1) {
                $("#obtDOMultiApproveDoc").removeAttr("disabled");
            }else{
                $("#obtDOMultiApproveDoc").attr("disabled", true);
            }
        }
    }

    $('#odvDOModalApvDocMultiple #obtConfirmApvDocMultiple').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof nStaSession !== "undefined" && nStaSession == 1){
            //JCNxOpenLoading();
            JSnDOApvDocMultiple();
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Function: Fucntion Call Delete Multiple Doc DT Temp
    function JSnDOApvDocMultiple(){
        // var nStaSession = JCNxFuncChkSessionExpired();
        // if(typeof nStaSession !== "undefined" && nStaSession == 1){
            JCNxOpenLoading();
            var tDODocNo        = $("#odvDOModalApvDocMultiple #ohdConfirmDODocNoApv").val();
            var tDOBchCode      = $("#odvDOModalApvDocMultiple #ohdConfirmDOBchCodeApv").val();
            var dDateTranfer    = $('#oetDODateTranfer').val();
            $.ajax({
                type: "POST",
                url: "monDOApvDocMulti",
                data: {
                    'tDocNoMulti'   : tDODocNo,
                    'tBchCodeMulti' : tDOBchCode,
                    'dDateTranfer'  : dDateTranfer
                },
                cache: false,
                timeout: 0,
                success: function (oResult) {
                    $('#odvDOModalApvDocMultiple').modal('hide');

                    var aResult     = JSON.parse(oResult);
                    var nStaEvent   = aResult['nStaEvent'];
                    var tStaMessg   = aResult['tStaMessg'];
                    if( nStaEvent == '1' ){
                        JSvDOCallPageDataTable();
                    }else{
                        FSvCMNSetMsgErrorDialog(tStaMessg);
                        JCNxCloseLoading();
                    }
                },  
                error: function (jqXHR, textStatus, errorThrown) {
                    JCNxResDOnseError(jqXHR, textStatus, errorThrown);
                }
            });
        // }else{
        //     JCNxShowMsgSessionExpired();
        // }
    }

    //Functionality: Remove Comma
    function JSoDORemoveCommaData(paData){
        var aTexts              = paData.substring(0, paData.length - 2);
        var aDataSplit          = aTexts.split(" , ");
        var aDataSplitlength    = aDataSplit.length;
        var aNewDataDeleteComma = [];

        for ($i = 0; $i < aDataSplitlength; $i++) {
            aNewDataDeleteComma.push(aDataSplit[$i]);
        }
        return aNewDataDeleteComma;
    }

    // Function: Pase Text Product Item In Modal Delete
    function JSxDOTextInModalDelPdtDtTemp(){
        var aArrayConvert   = [JSON.parse(localStorage.getItem("DO_LocalItemDataApv"))];
        if (aArrayConvert[0] == null || aArrayConvert[0] == ""){
        }else{
            var tDOTexaDocNo    = "";
            var tDOTexaBchCode  = "";
            $.each(aArrayConvert[0],function(nKey,aValue){
                // console.log(nKey,aValue);
                if( nKey != 0 ){
                    tDOTexaDocNo += ",";
                    tDOTexaBchCode  += ",";
                }
                tDOTexaDocNo    += aValue.aDocNo;
                tDOTexaBchCode  += aValue.aBchCode;
            });
            // console.log(tDOTexaDocNo);
            // console.log(tDOTexaBchCode);

            $('#odvDOModalApvDocMultiple #ohdConfirmDODocNoApv').val(tDOTexaDocNo);
            $('#odvDOModalApvDocMultiple #ohdConfirmDOBchCodeApv').val(tDOTexaBchCode);
        }
    }

    // Function : Function Check Data Search And Add In Tabel DT Temp
    function JSvDOClickPageList(ptPage){
        var nPageCurrent = '';
        switch (ptPage) {
            case 'next': //กดปุ่ม Next
                $('.xWBtnNext').addClass('disabled');
                nPageOld    = $('.xWDOPageDataTable .active').text(); // Get เลขก่อนหน้า
                nPageNew    = parseInt(nPageOld, 10) + 1; // +1 จำนวน
                nPageCurrent = nPageNew
                break;
            case 'previous': //กดปุ่ม Previous
                nPageOld    = $('.xWDOPageDataTable .active').text(); // Get เลขก่อนหน้า
                nPageNew    = parseInt(nPageOld, 10) - 1; // -1 จำนวน
                nPageCurrent = nPageNew
                break;
            default:
                nPageCurrent = ptPage
        }
        JCNxOpenLoading();
        $('#ohdDOPageCurrent').val(nPageCurrent);
        JSvDOCallPageDataTable();
    }
</script>