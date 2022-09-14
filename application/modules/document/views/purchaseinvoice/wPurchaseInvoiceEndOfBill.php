<style>
    #odvPIRowDataEndOfBill .panel-heading{
        padding-top: 10px !important;
        padding-bottom: 10px !important;
    }
    #odvPIRowDataEndOfBill .panel-body{
        padding-top: 0px !important;
        padding-bottom: 0px !important;
    }
    #odvPIRowDataEndOfBill .list-group-item {
        padding-left: 0px !important;
        padding-right: 0px !important;
        border: 0px solid #ddd;
    }
    .mark-font, .panel-default > .panel-heading.mark-font{
        color: #232C3D !important;
        font-weight: 900;
    }
</style>
<div class="row p-t-10" id="odvPIRowDataEndOfBill" >
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <div class="panel panel-default">
            <div class="panel-heading mark-font" id="odvPIDataTextBath"></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="pull-left mark-font"><?php echo language('document/purchaseinvoice/purchaseinvoice','tPITBVatRate');?></div>
                <div class="pull-right mark-font"><?php echo language('document/purchaseinvoice/purchaseinvoice','tPITBAmountVat');?></div>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body">
                <ul class="list-group" id="oulPIDataListVat">
                </ul>
            </div>
            <div class="panel-heading">
                <label class="pull-left mark-font"><?php echo language('document/purchaseinvoice/purchaseinvoice','tPITBTotalValVat');?></label>
                <label class="pull-right mark-font" id="olbPIVatSum">0.00</label>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <div class="panel panel-default">
            <div class="panel-body">
                <ul class="list-group">
                    <li class="list-group-item">
                        <label class="pull-left mark-font"><?php echo language('document/purchaseinvoice/purchaseinvoice','tPITBSumFCXtdNet');?></label>
                        <label class="pull-right mark-font" id="olbPISumFCXtdNet">0.00</label>
                        <input type="hidden" id="olbPISumFCXtdNetAlwDis"></label>
                        <div class="clearfix"></div>
                    </li>
                    <li class="list-group-item">
                        <label class="pull-left"><?php echo language('document/purchaseinvoice/purchaseinvoice','tPITBDisChg');?>
                            <?php if(empty($tPIStaApv) && $tPIStaDoc != 3):?>
                                <button type="button" class="xCNBTNPrimeryDisChgPlus" onclick="JCNvPIMngDocDisChagHD(this)" style="float: right; margin-top: 3px; margin-left: 5px;">+</button>
                            <?php endif; ?>
                        </label>
                        <label class="pull-left" style="margin-left: 5px;" id="olbPIDisChgHD"></label>
                        <input type="hidden" id="ohdPIHiddenDisChgHD" />
                        <label class="pull-right" id="olbPISumFCXtdAmt">0.00</label>
                        <div class="clearfix"></div>
                    </li>
                    <li class="list-group-item">
                        <label class="pull-left"><?php echo language('document/purchaseinvoice/purchaseinvoice','tPITBSumFCXtdNetAfHD');?></label>
                        <label class="pull-right" id="olbPISumFCXtdNetAfHD">0.00</label>
                        <div class="clearfix"></div>
                    </li>
                    <li class="list-group-item">
                        <label class="pull-left"><?php echo language('document/purchaseinvoice/purchaseinvoice','tPITBSumFCXtdVat');?></label>
                        <label class="pull-right" id="olbPISumFCXtdVat">0.00</label>
                        <input type="hidden" name="ohdSumFCXtdVat" id="ohdSumFCXtdVat" value="0.00">
                        <div class="clearfix"></div>
                    </li>
                </ul>
            </div>
            <div class="panel-heading">
                <label class="pull-left mark-font"><?php echo language('document/purchaseinvoice/purchaseinvoice','tPITBFCXphGrand');?></label>
                <label class="pull-right mark-font" id="olbPICalFCXphGrand">0.00</label>
                <div class="clearfix"></div>
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
    function JSxPISetFooterEndOfBill(poParams){
        /* ================================================= Left End Of Bill ================================================= */
            // Set Text Bath
            var tTextBath   = poParams.tTextBath;
            $('#odvPIDataTextBath').text(tTextBath);

            // รายการ vat
            var aVatItems   = poParams.aEndOfBillVat.aItems;
            var tVatList    = "";
            if(aVatItems.length > 0){
                for(var i = 0; i < aVatItems.length; i++){
                    var tVatRate = parseFloat(aVatItems[i]['FCXtdVatRate']).toFixed(0);
                    var tSumVat = parseFloat(aVatItems[i]['FCXtdVat']).toFixed(0) == 0 ? '0.00' : parseFloat(aVatItems[i]['FCXtdVat']).toFixed(<?php echo $nOptDecimalShow?>);
                    var tSumVat = parseFloat(aVatItems[i]['FCXtdVat']).toFixed(<?php echo $nOptDecimalShow;?>) == 0 ? '0.00' : parseFloat(aVatItems[i]['FCXtdVat']).toFixed(<?php echo $nOptDecimalShow?>);
                    tVatList += '<li class="list-group-item"><label class="pull-left">'+ tVatRate + '%</label><label class="pull-right">' +  numberWithCommas(parseFloat(tSumVat).toFixed(<?php echo $nOptDecimalShow?>))  + '</label><div class="clearfix"></div></li>';
                }
            }
            $('#oulPIDataListVat').html(tVatList);
            
            // ยอดรวมภาษีมูลค่าเพิ่ม
            var cSumVat     = poParams.aEndOfBillVat.cVatSum;
            $('#olbPIVatSum').text(cSumVat);
        /* ==================================================================================================================== */

        /* ================================================= Right End Of Bill ================================================ */
            var cCalFCXphGrand      = poParams.aEndOfBillCal.cCalFCXphGrand;
            var cSumFCXtdAmt        = poParams.aEndOfBillCal.cSumFCXtdAmt;
            var cSumFCXtdNet        = poParams.aEndOfBillCal.cSumFCXtdNet;
            var cSumFCXtdNetAfHD    = poParams.aEndOfBillCal.cSumFCXtdNetAfHD;
            var cSumFCXtdVat        = poParams.aEndOfBillCal.cSumFCXtdVat;
            var tDisChgTxt          = poParams.aEndOfBillCal.tDisChgTxt;

            // จำนวนเงินรวม
            $('#olbPISumFCXtdNet').text(cSumFCXtdNet);
            // ลด/ชาร์จ
            $('#olbPISumFCXtdAmt').text(cSumFCXtdAmt);
            // ยอดรวมหลังลด/ชาร์จ
            $('#olbPISumFCXtdNetAfHD').text(cSumFCXtdNetAfHD);
            // ยอดรวมภาษีมูลค่าเพิ่ม
            $('#olbPISumFCXtdVat').text(cSumFCXtdVat);
            // จำนวนเงินรวมทั้งสิ้น
            $('#olbPICalFCXphGrand').text(cCalFCXphGrand);
            //จำนวนลด/ชาร์จ ท้ายบิล
            $('#olbPIDisChgHD').text(tDisChgTxt);
            $('#ohdPIHiddenDisChgHD').val(tDisChgTxt);
        /* ==================================================================================================================== */
    }

    /**
        * Functionality: Save Discount And Chage Footer HD (ลดท้ายบิล)
        * Parameters: Event Proporty
        * Creator: 22/05/2019 Piya  
        * Return: Open Modal Discount And Change HD
        * Return Type: View
    */
    function JCNvPIMngDocDisChagHD(event){

        $.ajax({
            type    : "POST",
            url     : "GetPriceAlwDiscount",
            data    : { 'tDocno' : $('#oetPIDocNo').val() , 'tBCHCode' : $('#oetPIFrmBchCode').val() },
            cache   : false,
            timeout : 0,
            success : function(oResult) {
                var aTotal = JSON.parse(oResult);
                cSumFCXtdNet = aTotal.nTotal;
                $('#olbPISumFCXtdNetAlwDis').val(cSumFCXtdNet);
            }
        });

        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {
            var oPIDisChgParams = {
                DisChgType: 'disChgHD'
            };
            JSxPIOpenDisChgPanel(oPIDisChgParams);
        }else{
            JCNxShowMsgSessionExpired();
        } 
    }
  
</script>