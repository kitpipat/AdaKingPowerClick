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
<!-- <div class="row p-t-10" id="odvSORowDataEndOfBill" >
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <div class="panel panel-default">
            <div class="panel-heading mark-font" id="odvSODataTextBath"></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="pull-left mark-font"><?=language('document/document/document','tDocVat');?></div>
                <div class="pull-right mark-font"><?=language('document/document/document','tDocTaxAmount');?></div>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body">
                <ul class="list-group" id="oulSODataListVat">
                </ul>
            </div>
            <div class="panel-heading">
                <label class="pull-left mark-font"><?=language('document/document/document','tDocTotalVat');?></label>
                <label class="pull-right mark-font" id="olbSOVatSum">0.00</label>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <div class="panel panel-default">
            <div class="panel-body">
                <ul class="list-group">
                    <li class="list-group-item">
                        <label class="pull-left mark-font"><?=language('document/document/document','tDocTotalCash');?></label>
                        <label class="pull-right mark-font" id="olbSOSumFCXtdNet">0.00</label>
                        <div class="clearfix"></div>
                    </li>
                    <li class="list-group-item">
                        <label class="pull-left"><?=language('document/document/document','tDocVat');?></label>
                        <label class="pull-right" id="olbSOSumFCXtdVat">0.00</label>
                        <input type="text" class="form-control xCNHide" id="oetTBFCXthVat" name="oetTBFCXthVat" value="0.00">
                        <div class="clearfix"></div>
                    </li>
                    <li class="list-group-item">
                        <label class="pull-left"><?=language('document/document/document','tDocVattable');?></label>
                        <label class="pull-right" id="olbSOSumFCXtdVattable">0.00</label>
                        <input type="text" class="form-control xCNHide" id="oetTBFCXthVattable" name="oetTBFCXthVattable" value="0.00">
                        <div class="clearfix"></div>
                    </li>
                </ul>
            </div>
            <div class="panel-heading">
                <label class="pull-left mark-font"><?=language('document/document/document','tDocTotalAmount');?></label>
                <label class="pull-right mark-font" id="olbSOCalFCXphGrand">0.00</label>
                <input type="text" class="form-control xCNHide" id="oetTBFCXthTotal" name="oetTBFCXthTotal" value="0.00">
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div> -->
<script type="text/javascript">
    var tMsgVatDataNotFound = '<?=language('common/main/main','tCMNNotFoundData')?>';


    //Set Data Value End Of Bile
    function JSxTBSetFooterEndOfBill(poParams){
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
                }
            }
            $('#oulSODataListVat').html(tVatList);
            
            // ยอดรวมภาษีมูลค่าเพิ่ม
            var cSumVat     = poParams.aEndOfBillVat.cVatSum;
            $('#olbSOVatSum').text(cSumVat);

            /* ================================================= Right End Of Bill ================================================ */
            var cCalFCXphGrand      = poParams.aEndOfBillCal.cCalFCXphGrand;
            var cSumFCXtdAmt        = poParams.aEndOfBillCal.cSumFCXtdAmt;
            var cSumFCXtdNet        = poParams.aEndOfBillCal.cSumFCXtdNet;
            var cSumFCXtdNetAfHD    = poParams.aEndOfBillCal.cSumFCXtdNetAfHD;
            var cSumFCXtdVat        = poParams.aEndOfBillCal.cSumFCXtdVat;
            var tDisChgTxt          = poParams.aEndOfBillCal.tDisChgTxt;

            var cSumVattable        = cCalFCXphGrand - cSumFCXtdVat;
            
            // จำนวนเงินรวม
            $('#olbSOSumFCXtdNet').text(cSumFCXtdNet);

            // ลด/ชาร์จ
            // $('#olbSOSumFCXtdAmt').text(cSumFCXtdAmt);
            // ยอดรวมหลังลด/ชาร์จ
            // $('#olbSOSumFCXtdNetAfHD').text(cSumFCXtdNetAfHD);

            // ยอดรวมภาษีมูลค่าเพิ่ม
            $('#olbSOSumFCXtdVat').text(cSumFCXtdVat);
            // จำนวนเงินรวมทั้งสิ้น
            $('#olbSOCalFCXphGrand').text(cCalFCXphGrand);
            // มูลค่าแยกภาษี
            $('#olbSOSumFCXtdVattable').text(cSumVattable);

            //จำนวนลด/ชาร์จ ท้ายบิล
            // $('#olbSODisChgHD').text(tDisChgTxt);

            // เก็บข้อมูลคำนวณท้ายบิลไปใส่ใน HD
            $('#oetTBFCXthTotal').val(cCalFCXphGrand);
            $('#oetTBFCXthVat').val(cSumFCXtdVat);
            $('#oetTBFCXthVattable').val(cSumVattable);
    }

 
</script>