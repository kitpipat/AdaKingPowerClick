<style>
    #odvRSRowDataEndOfBill .panel-heading{
        padding-top: 10px !important;
        padding-bottom: 10px !important;
    }
    #odvRSRowDataEndOfBill .panel-body{
        padding-top: 0px !important;
        padding-bottom: 0px !important;
    }
    #odvRSRowDataEndOfBill .list-group-item {
        padding-left: 0px !important;
        padding-right: 0px !important;
        border: 0px solid #ddd;
    }
    .mark-font, .panel-default > .panel-heading.mark-font{
        color: #232C3D !important;
        font-weight: 900;
    }
</style>
<div class="row p-t-10" id="odvRSRowDataEndOfBill" >
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <div class="panel panel-default">
            <div class="panel-heading mark-font" id="odvRSDataTextBath"></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="pull-left mark-font"><?php echo language('document/returnsale/returnsale','tRSTBVatRate');?></div>
                <div class="pull-right mark-font"><?php echo language('document/returnsale/returnsale','tRSTBAmountVat');?></div>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body">
                <ul class="list-group" id="oulRSDataListVat">
                </ul>
            </div>
            <div class="panel-heading">
                <label class="pull-left mark-font"><?php echo language('document/returnsale/returnsale','tRSTBTotalValVat');?></label>
                <label class="pull-right mark-font" id="olbRSVatSum">0.00</label>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <div class="panel panel-default">
            <div class="panel-body">
                <ul class="list-group">
                    <li class="list-group-item">
                        <label class="pull-left mark-font"><?php echo language('document/returnsale/returnsale','tRSTBSumFCXtdNet');?></label>
                        <label class="pull-right mark-font" id="olbRSSumFCXtdNet">0.00</label>
                        <input type="hidden" id="olbRSSumFCXtdNetAlwDis"></label>
                        <div class="clearfix"></div>
                    </li>
                    <li class="list-group-item">
                        <label class="pull-left"><?php echo language('document/returnsale/returnsale','tRSTBDisChg');?>
                            <?php if(empty($tRSStaApv) && $tRSStaDoc != 3):?>
                                <button type="button" class="xCNBTNPrimeryDisChgPlus" onclick="JCNvRSMngDocDisChagHD(this)" style="float: right; margin-top: 3px; margin-left: 5px;">+</button>
                            <?php endif; ?>
                        </label>
                        <label class="pull-left" style="margin-left: 5px;" id="olbRSDisChgHD"></label>
                        <label class="pull-right" id="olbRSSumFCXtdAmt">0.00</label>
                        <div class="clearfix"></div>
                    </li>
                    <li class="list-group-item">
                        <label class="pull-left"><?php echo language('document/returnsale/returnsale','tRSTBSumFCXtdNetAfHD');?></label>
                        <label class="pull-right" id="olbRSSumFCXtdNetAfHD">0.00</label>
                        <div class="clearfix"></div>
                    </li>
                    <li class="list-group-item">
                        <label class="pull-left"><?php echo language('document/returnsale/returnsale','tRSTBSumFCXtdVat');?></label>
                        <label class="pull-right" id="olbRSSumFCXtdVat">0.00</label>
                        <div class="clearfix"></div>
                    </li>
                </ul>
            </div>
            <div class="panel-heading">
                <label class="pull-left mark-font"><?php echo language('document/returnsale/returnsale','tRSTBFCXphGrand');?></label>
                <label class="pull-right mark-font" id="olbRSCalFCXphGrand">0.00</label>
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
    function JSxRSSetFooterEndOfBill(poParams){
        /* ================================================= Left End Of Bill ================================================= */
            // Set Text Bath
            var tTextBath   = poParams.tTextBath;
            $('#odvRSDataTextBath').text(tTextBath);

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
            $('#oulRSDataListVat').html(tVatList);
            
            // ยอดรวมภาษีมูลค่าเพิ่ม
            var cSumVat     = poParams.aEndOfBillVat.cVatSum;
            $('#olbRSVatSum').text(cSumVat);
        /* ==================================================================================================================== */

        /* ================================================= Right End Of Bill ================================================ */
            var cCalFCXphGrand      = poParams.aEndOfBillCal.cCalFCXphGrand;
            var cSumFCXtdAmt        = poParams.aEndOfBillCal.cSumFCXtdAmt;
            var cSumFCXtdNet        = poParams.aEndOfBillCal.cSumFCXtdNet;
            var cSumFCXtdNetAfHD    = poParams.aEndOfBillCal.cSumFCXtdNetAfHD;
            var cSumFCXtdVat        = poParams.aEndOfBillCal.cSumFCXtdVat;
            var tDisChgTxt          = poParams.aEndOfBillCal.tDisChgTxt;
            
            // จำนวนเงินรวม
            $('#olbRSSumFCXtdNet').text(cSumFCXtdNet);
            // ลด/ชาร์จ
            $('#olbRSSumFCXtdAmt').text(cSumFCXtdAmt);
            // ยอดรวมหลังลด/ชาร์จ
            $('#olbRSSumFCXtdNetAfHD').text(cSumFCXtdNetAfHD);
            // ยอดรวมภาษีมูลค่าเพิ่ม
            $('#olbRSSumFCXtdVat').text(cSumFCXtdVat);
            // จำนวนเงินรวมทั้งสิ้น
            $('#olbRSCalFCXphGrand').text(cCalFCXphGrand);
            //จำนวนลด/ชาร์จ ท้ายบิล
            $('#olbRSDisChgHD').text(tDisChgTxt);
        /* ==================================================================================================================== */
    }

    /**
        * Functionality: Save Discount And Chage Footer HD (ลดท้ายบิล)
        * Parameters: Event Proporty
        * Creator: 22/05/2019 Piya  
        * Return: Open Modal Discount And Change HD
        * Return Type: View
    */
    function JCNvRSMngDocDisChagHD(event){

        //หาราคาที่อนุญาติลดเท่านั้น - วัฒน์
        $.ajax({
            type    : "POST",
            url     : "GetPriceAlwDiscount",
            data    : { 'tDocno' : $('#oetRSDocNo').val() , 'tBCHCode' : $('#oetRSFrmBchCode').val() },
            cache   : false,
            timeout : 0,
            success : function(oResult) {
                var aTotal = JSON.parse(oResult);
                cSumFCXtdNet = aTotal.nTotal;
                $('#olbRSSumFCXtdNetAlwDis').val(cSumFCXtdNet);
            }
        });

        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {
            var oRSDisChgParams = {
                DisChgType: 'disChgHD'
            };
            JSxRSOpenDisChgPanel(oRSDisChgParams);
        }else{
            JCNxShowMsgSessionExpired();
        } 
    }

    
</script>