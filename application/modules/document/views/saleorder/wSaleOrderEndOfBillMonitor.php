<style>
  #odvSORowDataEndOfBill .panel-heading{
        padding-top: 10px !important;
        padding-bottom: 10px !important;
    }
    #odvSORowDataEndOfBill .panel-body{
        padding-top: 0px !important;
        padding-bottom: 0px !important;
    }
    #odvSORowDataEndOfBill .list-group-item {
        padding-left: 0px !important;
        padding-right: 0px !important;
        border: 0px solid #ddd;
    }
    .mark-font, .panel-default > .panel-heading.mark-font{
        color: #232C3D !important;
        font-weight: 900;
    }
</style>
<div id="odvSORowDataEndOfBill"  >
           <!-- Panel Customer Info -->
           <div class=""  style="margin:15px;position:relative;" >
                <div class="panel-collapse collapse in" role="tabpanel">
                    <div class="panel-body">

                         <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                                <div id="odvSODataTextBath"></div>
                                 <textarea class="form-control" 
                                 id="otaSOFrmInfoOthRmk"
                                 name="otaSOFrmInfoOthRmk"
                      rows="6" placeholder="หมายเหตุ"   <?php if($tSOStaApv==2 && $tSOStaDoc != 3 && $nLastSeq==1){ echo ''; }else{ echo 'disabled'; } ?> ><?php echo $tSOFrmRmk?></textarea>
                               
                         </div>
                         <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                             <ul class="list-group">
                                    <li class="list-group-item">
                                        <label class="pull-left mark-font"><?php echo language('document/saleorder/saleorder','tSOTBSumFCXtdNet');?></label>
                                        <label class="pull-right mark-font" id="olbSOSumFCXtdNet">0.00</label>
                                        <div class="clearfix"></div>
                                    </li>
                                    <li class="list-group-item">
                                        <label class="pull-left"><?php echo language('document/saleorder/saleorder','tSOTBDisChg');?>
                                            <?php if($tSOStaApv==2 && $tSOStaDoc != 3 && $nLastSeq==1):?>
                                                <button type="button" class="xCNBTNPrimeryDisChgPlus" onclick="JCNvSOMngDocDisChagHD(this)" style="float: right; margin-top: 3px; margin-left: 5px;">+</button>
                                            <?php endif; ?>
                                        </label>
                                        <label class="pull-left" style="margin-left: 5px;" id="olbSODisChgHD"></label>
                                        <label class="pull-right" id="olbSOSumFCXtdAmt">0.00</label>
                                        <div class="clearfix"></div>
                                    </li>
                                    <li class="list-group-item">
                                        <label class="pull-left"><?php echo language('document/saleorder/saleorder','tSOTBSumFCXtdNetAfHD');?></label>
                                        <label class="pull-right" id="olbSOSumFCXtdNetAfHD">0.00</label>
                                        <div class="clearfix"></div>
                                    </li>
                                    <li class="list-group-item"  style="display:none">
                                        <label class="pull-left"><?php echo language('document/saleorder/saleorder','tSOTBSumFCXtdVat');?></label>
                                        <label class="pull-right" id="olbSOSumFCXtdVat">0.00</label>
                                        <div class="clearfix"></div>
                                    </li>
                                    <li class="list-group-item"  >
                                    <label class="pull-left mark-font"><?php echo language('document/saleorder/saleorder','tSOTBFCXphGrand');?></label>
                                    <label class="pull-right mark-font" id="olbSOCalFCXphGrand">0.00</label>
                                    <div class="clearfix"></div>
                                    </li>
                                </ul>
                         </div>
                </div>
            </div>

    </div>
</div>


<script type="text/javascript">
    var tMsgVatDataNotFound = '<?php echo language('common/main/main','tCMNNotFoundData')?>';


    /**
        * Function: Set Data Value End Of Bile
        * Parameters: Document Type
        * Creator: 01/07/2019 wasin(Yoshi)
        * LastUpdate: -
        * Return: Set Value In Text From
        * ReturnType: None
    */
    function JSxSOSetFooterEndOfBill(poParams){
        /* ================================================= Left End Of Bill ================================================= */
            // Set Text Bath
            var tTextBath   = poParams.tTextBath;
            $('#odvSODataTextBath').text(tTextBath);

            // รายการ vat
            var aVatItems   = poParams.aEndOfBillVat.aItems;
            var tVatList    = "";
            if(aVatItems.length > 0){
                for(var i = 0; i < aVatItems.length; i++){
                    var tVatRate = parseFloat(aVatItems[i]['FCXtdVatRate']).toFixed(0);
                    var tSumVat = parseFloat(aVatItems[i]['FCXtdVat']).toFixed(0) == 0 ? '0.00' : parseFloat(aVatItems[i]['FCXtdVat']).toFixed(<?php echo $nOptDecimalShow?>);
                    var tSumVat = parseFloat(aVatItems[i]['FCXtdVat']).toFixed(<?php echo $nOptDecimalShow;?>) == 0 ? '0.00' : parseFloat(aVatItems[i]['FCXtdVat']).toFixed(<?php echo $nOptDecimalShow?>);
                    tVatList += '<li class="list-group-item"><label class="pull-left">'+ tVatRate + '%</label><label class="pull-right">' + tSumVat + '</label><div class="clearfix"></div></li>';

                    // var tVatRate    = parseFloat(aVatItems[i]['FCXtdVatRate']).toFixed(0);
                    // var tSumVat     = parseFloat(aVatItems[i]['FCXtdVat']).toFixed(0) == 0 ? '0.00' : parseFloat(aVatItems[i]['FCXtdVat']).toFixed(2);
                    // tVatList        += '<li class="list-group-item"><label class="pull-left">'+ tVatRate + '%</label><label class="pull-right">' + tSumVat + '</label><div class="clearfix"></div></li>';
                }
            }
            $('#oulSODataListVat').html(tVatList);
            
            // ยอดรวมภาษีมูลค่าเพิ่ม
            var cSumVat     = poParams.aEndOfBillVat.cVatSum;
            $('#olbSOVatSum').text(cSumVat);
        /* ==================================================================================================================== */

        /* ================================================= Right End Of Bill ================================================ */
            var cCalFCXphGrand      = poParams.aEndOfBillCal.cCalFCXphGrand;
            var cSumFCXtdAmt        = poParams.aEndOfBillCal.cSumFCXtdAmt;
            var cSumFCXtdNet        = poParams.aEndOfBillCal.cSumFCXtdNet;
            var cSumFCXtdNetAfHD    = poParams.aEndOfBillCal.cSumFCXtdNetAfHD;
            var cSumFCXtdVat        = poParams.aEndOfBillCal.cSumFCXtdVat;
            var tDisChgTxt          = poParams.aEndOfBillCal.tDisChgTxt;
            
            // จำนวนเงินรวม
            $('#olbSOSumFCXtdNet').text(cSumFCXtdNet);
            // ลด/ชาร์จ
            $('#olbSOSumFCXtdAmt').text(cSumFCXtdAmt);
            // ยอดรวมหลังลด/ชาร์จ
            $('#olbSOSumFCXtdNetAfHD').text(cSumFCXtdNetAfHD);
            // ยอดรวมภาษีมูลค่าเพิ่ม
            $('#olbSOSumFCXtdVat').text(cSumFCXtdVat);
            // จำนวนเงินรวมทั้งสิ้น
            $('#olbSOCalFCXphGrand').text(cCalFCXphGrand);
            //จำนวนลด/ชาร์จ ท้ายบิล
            $('#olbSODisChgHD').text(tDisChgTxt);
        /* ==================================================================================================================== */
    }

    /**
        * Functionality: Save Discount And Chage Footer HD (ลดท้ายบิล)
        * Parameters: Event Proporty
        * Creator: 22/05/2019 Piya  
        * Return: Open Modal Discount And Change HD
        * Return Type: View
    */
    function JCNvSOMngDocDisChagHD(event){
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {
            var oSODisChgParams = {
                DisChgType: 'disChgHD'
            };
            JSxSOOpenDisChgPanel(oSODisChgParams);
        }else{
            JCNxShowMsgSessionExpired();
        } 
    }

    
</script>