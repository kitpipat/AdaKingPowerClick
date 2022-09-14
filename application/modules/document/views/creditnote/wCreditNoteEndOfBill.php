<style>
    #odvCreditNoteEndOfBill .panel-heading{
            padding-top: 10px !important;
            padding-bottom: 10px !important;
    }
    #odvCreditNoteEndOfBill .panel-body{
        padding-top: 0px !important;
        padding-bottom: 0px !important;
    }
    #odvCreditNoteEndOfBill .list-group-item {
        padding-left: 0px !important;
        padding-right: 0px !important;
        border: 0px solid #ddd;
    }
    .mark-font, .panel-default > .panel-heading.mark-font{
        color: #232C3D !important;
        font-weight: 900;
    }
</style>

<div class="row" id="odvCreditNoteEndOfBill">

    <div class="col-lg-6">
        <span class="xCNHide" id="ospCreditNoteCalEndOfBillNonePdt"></span>
        <div class="panel panel-default">
            <div class="panel-heading mark-font" id="odvCreditNoteTextBath"></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="pull-left mark-font"><?php echo language('document/document/document', 'tDocVat') ?></div>
                <div class="pull-right mark-font"><?php echo language('document/document/document', 'tDocTaxAmount') ?></div>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body">
                <ul class="list-group" id="oulCreditNoteListVat"></ul>
                <ul id="oulCreditNoteListVatNonePdt">
                    <li><label class="pull-left" id="olbCreditNoteVatrate"></label><label class="pull-right" id="oblCreditNoteSumVat"></label><div class="clearfix"></div></li>
                </ul>
            </div>
            <div class="panel-heading">
                <label class="pull-left mark-font"><?php echo language('document/document/document', 'tDocTotalVat') ?></label>
                <label class="pull-right mark-font" id="olbCrdditNoteVatSum">0.00</label>
                <input type="hidden" id="olbCrdSumFCXtdNetAlwDis"></label>

                <div class="clearfix"></div>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="panel panel-default">
            <div class="panel-body">
                <ul class="list-group">
                    <li class="list-group-item">
                        <label class="pull-left mark-font"><?php echo language('document/document/document', 'tDocTotalCash') ?></label>
                        <label class="pull-right mark-font" id="olbCrdditNoteSumFCXtdNet">0.00</label>
                        <div class="clearfix"></div>
                    </li>
                    <?php if($bIsDocTypeHavePdt) { ?>
                        <li class="list-group-item">
                            <label class="pull-left"><?php echo language('document/document/document', 'tDocDisChg') ?>
                                <?php if(empty($tStaApv) && $tStaDoc != 3) { ?>
                                <button 
                                    class="xCNBTNPrimeryDisChgPlus" 
                                    onclick="JCNvCreditNoteDisChagHD(this)" 
                                    type="button" 
                                    style="float: right; margin-top: 3px; margin-left: 5px;">+</button>
                                <?php } ?>
                            </label>
                            <input type="hidden" id="ohdCrdditNoteHiddenDisChgHD" />
                            <label class="pull-left" style="margin-left: 5px;" id="olbCreditNoteDisChgHD"></label>
                            <label class="pull-right" id="olbCrdditNoteSumFCXtdAmt">0.00</label>
                            <div class="clearfix"></div>
                        </li>
                        <li class="list-group-item">
                            <label class="pull-left"><?php echo language('document/document/document', 'tDocTotalDisChg') ?></label>
                            <label class="pull-right" id="olbCrdditNoteSumFCXtdNetAfHD">0.00</label>
                            <div class="clearfix"></div>
                        </li>
                    <?php } ?>
                    <li class="list-group-item">
                        <label class="pull-left"><?php echo language('document/document/document', 'tDocTotalVat') ?></label>
                        <label class="pull-right" id="olbCrdditNoteSumFCXtdVat">0.00</label>
                        <div class="clearfix"></div>
                    </li>
                </ul>
            </div>
            <div class="panel-heading">
                <label class="pull-left mark-font"><?php echo language('document/document/document', 'tDocTotalAmount') ?></label>
                <label class="pull-right mark-font" id="olbCrdditNoteCalFCXphGrand">0.00</label>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>

</div>

<script>
    $(document).ready(function(){
        
    });

    //พวกตัวเลขใส่ comma ให้มัน
    function numberWithCommas(x) {
        return x.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ",");
    }


    /**
     * Functionality : Display End Of Bill Calc
     * Parameters : poParams
     * Creator : 26/06/2019 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxCrdditNoteSetEndOfBill(poParams) {
        // console.log('JSxCrdditNoteSetEndOfBill');
        
        /*================ Left End Of Bill ========================*/
        // Text
        var tTextBath = poParams.tTextBath;
        $('#odvCreditNoteTextBath').text(tTextBath);
        
        // รายการ vat
        var aVatItems = poParams.aEndOfBillVat.aItems;
        // console.log('aVatItems: ', aVatItems);
        var tVatList = "";
        for(var i=0; i<aVatItems.length; i++){
            var tVatRate    = parseFloat(aVatItems[i]['FCXtdVatRate']).toFixed(0);
            var tSumVat     = parseFloat(aVatItems[i]['FCXtdVat']).toFixed(<?=$nOptDecimalShow?>) == 0 ? '0.00' : parseFloat(aVatItems[i]['FCXtdVat']).toFixed(<?=$nOptDecimalShow?>);
            tVatList += '<li class="list-group-item"><label class="pull-left">'+ tVatRate + '%</label><label class="pull-right">' + numberWithCommas(parseFloat(tSumVat).toFixed(<?=$nOptDecimalShow?>)) + '</label><div class="clearfix"></div></li>';
        }
        $('#oulCreditNoteListVat').html(tVatList);
        
        // ยอดรวมภาษีมูลค่าเพิ่ม
        var cSumVat = poParams.aEndOfBillVat.cVatSum;
        $('#olbCrdditNoteVatSum').text(cSumVat);
        
        /*================ Right End Of Bill ========================*/
        var cCalFCXphGrand = poParams.aEndOfBillCal.cCalFCXphGrand;
        var cSumFCXtdAmt = poParams.aEndOfBillCal.cSumFCXtdAmt;
        var cSumFCXtdNet = poParams.aEndOfBillCal.cSumFCXtdNet;
        var cSumFCXtdNetAfHD = poParams.aEndOfBillCal.cSumFCXtdNetAfHD;
        var cSumFCXtdVat = poParams.aEndOfBillCal.cSumFCXtdVat;
        var tDisChgTxt = poParams.aEndOfBillCal.tDisChgTxt;

        if(tDisChgTxt == '' || tDisChgTxt == null){
            //console.log('NULL');
        }else{
            var tTextDisChg    = '';
            var aExplode       = tDisChgTxt.split(",");
            for(var i=0; i<aExplode.length; i++){
                if(aExplode[i].indexOf("%") != '-1'){
                    tTextDisChg += aExplode[i] + ',';
                }else{
                    tTextDisChg += accounting.formatNumber(aExplode[i], 2, ',') + ',';
                }

                //ถ้าเป็นตัวท้ายให้ลบ comma ออก
                if(i == aExplode.length - 1 ){
                    tTextDisChg = tTextDisChg.substring(tTextDisChg.length-1,-1);
                }
            }
        }


        // จำนวนเงินรวม
        $('#olbCrdditNoteSumFCXtdNet').text(cSumFCXtdNet);
        // ลด/ชาร์จ
        $('#olbCrdditNoteSumFCXtdAmt').text(cSumFCXtdAmt);
        // ยอดรวมหลังลด/ชาร์จ
        $('#olbCrdditNoteSumFCXtdNetAfHD').text(cSumFCXtdNetAfHD);
        // ยอดรวมภาษีมูลค่าเพิ่ม
        $('#olbCrdditNoteSumFCXtdVat').text(cSumFCXtdVat);
        // จำนวนเงินรวมทั้งสิ้น
        $('#olbCrdditNoteCalFCXphGrand').text(cCalFCXphGrand);
        // Text
        $('#olbCreditNoteDisChgHD').text(tTextDisChg);
        $('#ohdCrdditNoteHiddenDisChgHD').val(tDisChgTxt);
    }
    
    /**
     * Functionality: Save Pdt And Calculate Field
     * Parameters: Event Proporty
     * Creator: 22/05/2019 Piya  
     * Return:  Cpntroll input And Call Function Edit
     * Return Type: number
     */
    function JCNvCreditNoteDisChagHD(event) {

        //หาราคาที่อนุญาติลดเท่านั้น - วัฒน์
        $.ajax({
            type    : "POST",
            url     : "GetPriceAlwDiscount",
            data    : { 'tDocno' : $('#oetCreditNoteDocNo').val() , 'tBCHCode' : $('#ohdCreditNoteBchCode').val() },
            cache   : false,
            timeout : 0,
            success : function(oResult) {
                var aTotal = JSON.parse(oResult);
                cSumFCXtdNet = aTotal.nTotal;
                $('#olbCrdSumFCXtdNetAlwDis').val(cSumFCXtdNet);
            }
        });

        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {
            var oDisChgParams = {
                DisChgType: 'disChgHD'
            };
            JSxCreditNoteOpenDisChgPanel(oDisChgParams);
        } else {
            JCNxShowMsgSessionExpired();
        }
    }
</script>
