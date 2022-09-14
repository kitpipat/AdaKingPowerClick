<?php
if ($aDataList['tCode'] == '1') {
    $nCurrentPage   = $aDataList['nCurrentPage'];
} else {
    $nCurrentPage   = '1';
}
?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="table-responsive">
            <table id="otbMCPTblDataDocHDList" class="table table-striped">
                <thead>
                    <tr class="xCNCenter">
                        <?php /*if ($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1) :*/ ?>
                            <th nowrap class="xCNTextBold" style="width:5%;"><?php echo language('document/managecoupon/managecoupon', 'tMCPTBChoose') ?></th>
                        <?php /*endif;*/ ?>
                        <th nowrap class="xCNTextBold"><?php echo language('document/managecoupon/managecoupon','tMCPTBBchCreate')?></th>
						<th nowrap class="xCNTextBold"><?php echo language('document/managecoupon/managecoupon','tMCPTBDocNo')?></th>
						<th nowrap class="xCNTextBold"><?php echo language('document/managecoupon/managecoupon','tMCPTBDocDate')?></th>
						<th nowrap class="xCNTextBold"><?php echo language('document/managecoupon/managecoupon','tMCPTBType')?></th>
                        <th nowrap class="xCNTextBold"><?php echo language('document/managecoupon/managecoupon','tMCPTBRefCode')?></th>
                        <th nowrap class="xCNTextBold"><?php echo language('document/managecoupon/managecoupon','tMCPTBStatus')?></th>
                        <th nowrap class="xCNTextBold"><?php echo language('document/managecoupon/managecoupon','tMCPTBStartDate')?></th>
                        <th nowrap class="xCNTextBold"><?php echo language('document/managecoupon/managecoupon','tMCPTBExpireDate')?></th>
                        <?php /*if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaRead'] == 1 || $aAlwEvent['tAutStaEdit'] == 1) :*/ ?>
						    <th nowrap class="xCNTextBold" style="width:5%;"><?php echo language('document/managecoupon/managecoupon','tMCPTBCheck')?></th>
						<?php /*endif;*/ ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($aDataList['tCode'] == 1) : ?>
                        <?php foreach ($aDataList['aItems'] as $nKey => $aValue) : ?>
                            <?php

                                $nExpireDate = $aExpireConfig['nValueExpire'];
                                $dStartDate  = $aValue['FDStartDate'];

                                // กำหนดเอง : 1:ชั่วโมง 2:วัน
                                if( $aExpireConfig['tAddDateType'] == '1' ){
                                    $tAddDateType = "hours";
                                    $tDateFormat  = "Y-m-d H:i:s";
                                }else{
                                    $tAddDateType = "days";
                                    $tDateFormat  = "Y-m-d";
                                    $nExpireDate  = $nExpireDate - 1;
                                }

                                $dStartDate  = date($tDateFormat,strtotime($dStartDate));
                                $dExpireDate = date($tDateFormat,strtotime($dStartDate . "+".$nExpireDate." ".$tAddDateType));
                                $dNowDate    = date($tDateFormat);

                                $nChkExpire = 2;
                                $nStaExpire = 2;
                                $nStaAlwAdj = 1;
                                $nStaUse    = $aValue['FNStaUse'];
                                // 1 จอง 2 รับบางส่วน 3 รับทั้งหมด 4 ยกเลิก
                                switch($nStaUse){
                                    case '1':
                                        $tStaClass  = "text-warning";
                                        $tStaName   = language('document/managecoupon/managecoupon','tMCPStatus1'); // จอง
                                        $nStaAlwAdj = 2;
                                        $nChkExpire = 1;
                                        break;
                                    case '2':
                                        $tStaClass  = "text-warning";
                                        $tStaName   = language('document/managecoupon/managecoupon','tMCPStatus2'); // รับบางส่วน
                                        $nChkExpire = 1;
                                        break;
                                    case '3':
                                        $tStaClass  = "text-success";
                                        $tStaName   = language('document/managecoupon/managecoupon','tMCPStatus3'); // รับทั้งหมด
                                        break;
                                    case '4':
                                        $tStaClass  = "text-danger";
                                        $tStaName   = language('document/managecoupon/managecoupon','tMCPStatus4'); // ยกเลิก
                                        if( $dNowDate <= $dExpireDate ){ // ยังไม่หมดอายุ สามารถปรับสถานะจากยกเลิก เป็นจอง ได้
                                            $nStaAlwAdj = 2;
                                        }
                                        break;
                                    default:
                                        $tStaClass  = "";
                                        $tStaName = "-";
                                        break;
                                }
                                
                                if( $nChkExpire == 1 && ($dNowDate > $dExpireDate) ){
                                    $tStaClass  = "text-danger";
                                    $tStaName   = language('document/managecoupon/managecoupon','tMCPStatusExpire'); // หมดอายุ
                                    $nStaExpire = 1;
                                }

                                switch($aValue['FNCouponType']){
                                    case "2":
                                        $tCouponName = language('document/managecoupon/managecoupon','tMCPType1');
                                        break;
                                    case "1":
                                        $tCouponName = language('document/managecoupon/managecoupon','tMCPType2');
                                        break;
                                    default:
                                        $tCouponName = "-";
                                }

                                if( ($nStaExpire == 1) || ($nStaAlwAdj == 1) ){
                                    $tCheckboxDisabled  = "disabled";
                                    $tClassDisabled     = 'xCNDocDisabled';
                                }else{
                                    $tCheckboxDisabled  = "";
                                    $tClassDisabled     = '';
                                }

                            ?>
                            <tr class="text-center xCNTextDetail2 xWMCPDocItems" id="otrMCPItemsList<?=$nKey?>" 
                                data-bchcode="<?=$aValue['FTBchCode']?>"
                                data-code="<?=$aValue['FTDocNo']?>" 
                                data-name="<?=$aValue['FTDocNo']?>" 
                                data-type="<?=$aValue['FNCouponType']?>"
                                data-status="<?=$nStaUse?>" 
                                data-expire="<?=$nStaExpire?>"
                                data-ref="<?=$aValue['FTRefCode']?>"
                            >
                                <?php /*if ($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1) :*/ ?>
                                    <td nowrap class="text-center">
                                        <label class="fancy-checkbox ">
                                            <input id="ocbListItem<?=$nKey?>" type="checkbox" class="ocbListItem" name="ocbListItem[]" <?=$tCheckboxDisabled?> >
                                            <span id="ospListItem<?=$nKey?>" class="<?=$tClassDisabled?>">&nbsp;</span>
                                        </label>
                                    </td>
                                <?php /*endif;*/ ?>
                                <td nowrap class="text-left"><?php echo (!empty($aValue['FTBchName'])) ? $aValue['FTBchName'] : '-' ?></td>
                                <td nowrap class="text-left"><?php echo (!empty($aValue['FTDocNo'])) ? $aValue['FTDocNo'] : '-' ?></td>
                                <td nowrap class="text-center"><?php echo (!empty($aValue['FDDocDate'])) ? $aValue['FDDocDate'] : '-' ?></td>
                                <td nowrap class="text-left"><?=$tCouponName?></td>
                                <td nowrap class="text-left"><?php echo (!empty($aValue['FTRefCode'])) ? $aValue['FTRefCode'] : '-' ?></td>
                                <td nowrap class="text-left"><label class="<?=$tStaClass?>"><?=$tStaName?></label></td>
                                <td nowrap class="text-center"><?=$dStartDate?></td>
                                <td nowrap class="text-center"><?=$dExpireDate?></td>
                                <?php /*if ($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaRead'] == 1) :*/ ?>
                                    <td>
                                        <img class="xCNIconTable xWMCPViewDetails" style="width: 17px;" src="<?= base_url() . '/application/modules/common/assets/images/icons/view2.png' ?>">
                                    </td>
                                <?php /*endif;*/ ?>
                            <tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td class='text-center xCNTextDetail2' colspan='100%'><?php echo language('common/main/main', 'tCMNNotFoundData') ?></td>
                            </tr>
                        <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <p><?php echo language('common/main/main', 'tResultTotalRecord') ?> <?php echo $aDataList['nAllRow'] ?> <?php echo language('common/main/main', 'tRecord') ?> <?php echo language('common/main/main', 'tCurrentPage') ?> <?php echo $aDataList['nCurrentPage'] ?> / <?php echo $aDataList['nAllPage'] ?></p>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <div class="xWMCPPageDataTable btn-toolbar pull-right">
            <?php if ($nPage == 1) {
                $tDisabledLeft = 'disabled';
            } else {
                $tDisabledLeft = '-';
            } ?>
            <button onclick="JSxMCPClickPageList('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>>
                <i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
            </button>

            <?php for ($i = max($nPage - 2, 1); $i <= max(0, min($aDataList['nAllPage'], $nPage + 2)); $i++) { ?>
                <?php
                if ($nPage == $i) {
                    $tActive = 'active';
                    $tDisPageNumber = 'disabled';
                } else {
                    $tActive = '';
                    $tDisPageNumber = '';
                }
                ?>
                <button onclick="JSxMCPClickPageList('<?php echo $i ?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i ?></button>
            <?php } ?>

            <?php if ($nPage >= $aDataList['nAllPage']) {
                $tDisabledRight = 'disabled';
            } else {
                $tDisabledRight = '-';
            } ?>
            <button onclick="JSxMCPClickPageList('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>>
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>

<!-- ===================================================== Modal View Details ===================================================== -->
<div id="odvMCPModalViewDetails" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?php echo language('document/managecoupon/managecoupon', 'tMCPDetailTitle') ?></label>
            </div>
            <div class="modal-body">
                
            </div>
            <div class="modal-footer">
                <!-- <button id="osmMCPConfirm" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button"><?php echo language('common/main/main', 'tModalConfirm') ?></button> -->
                <button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button" data-dismiss="modal"><?php echo language('common/main/main', 'tModalCancel') ?></button>
            </div>
        </div>
    </div>
</div>
<!-- ======================================================================================================================================== -->

<script type="text/javascript">
    $(document).ready(function() {
        $('.ocbListItem').unbind().click(function() {
            var nCode   = $(this).parents('.xWMCPDocItems').data('code'); // Code
            var tStatus = $(this).parents('.xWMCPDocItems').data('status'); // Status
            $(this).prop('checked', true);
            var LocalItemData = localStorage.getItem("LocalItemData");
            var obj = [];
            if (LocalItemData) {
                obj = JSON.parse(LocalItemData);
            } else {}
            var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
            if (aArrayConvert == '' || aArrayConvert == null) {
                obj.push({
                    "nCode"     : nCode,
                    "tStatus"   : tStatus
                });
                localStorage.setItem("LocalItemData", JSON.stringify(obj));
                JSxMCPTextinModal();
            } else {
                var aReturnRepeat = JStMCPFindObjectByKey(aArrayConvert[0], 'nCode', nCode);
                if (aReturnRepeat == 'None') { //ยังไม่ถูกเลือก
                    obj.push({
                        "nCode"     : nCode,
                        "tStatus"   : tStatus
                    });
                    localStorage.setItem("LocalItemData", JSON.stringify(obj));
                    JSxMCPTextinModal();
                } else if (aReturnRepeat == 'Dupilcate') { //เคยเลือกไว้แล้ว
                    localStorage.removeItem("LocalItemData");
                    $(this).prop('checked', false);
                    var nLength = aArrayConvert[0].length;
                    for ($i = 0; $i < nLength; $i++) {
                        if (aArrayConvert[0][$i].nCode == nCode) {
                            delete aArrayConvert[0][$i];
                        }
                    }
                    var aNewarraydata = [];
                    for ($i = 0; $i < nLength; $i++) {
                        if (aArrayConvert[0][$i] != undefined) {
                            aNewarraydata.push(aArrayConvert[0][$i]);
                        }
                    }
                    localStorage.setItem("LocalItemData", JSON.stringify(aNewarraydata));
                    JSxMCPTextinModal();
                }
            }
            JSxMCPShowButtonChoose();
        });
    });

    $(".xWMCPViewDetails").off('click').on('click',function(){

        JCNxOpenLoading();

        var tBchCode    = $(this).parents().parents().attr('data-bchcode');
        var tDocNo      = $(this).parents().parents().attr('data-code');
        var tType       = $(this).parents().parents().attr('data-type');

        $.ajax({
            type: "POST",
            url: "docManageCouponPageViewDetails",
            data: {
                ptBchCode   : tBchCode,
                ptDocNo     : tDocNo,
                ptType      : tType
            },
            cache: false,
            timeout: 0,
            success: function (oResult){
                var aReturnData = JSON.parse(oResult);
                if( aReturnData['nStaEvent'] == 1 ){
                    $('#odvMCPModalViewDetails .modal-body').html(aReturnData['tMCPViewDetailsList']);
                    $('#odvMCPModalViewDetails').modal('show');
                }else{
                    var tMessageError = aReturnData['tStaMessg'];
                    FSvCMNSetMsgErrorDialog(tMessageError);
                }
                JCNxCloseLoading();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    });

</script>