<?php
if ($aDataList['rtCode'] == '1') {
    $nCurrentPage = $aDataList['rnCurrentPage'];
} else {
    $nCurrentPage = '1';
}
?>
<input id="oetPTUCurrentPage" class="xCNHide" value="<?=$nCurrentPage;?>">
<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr class="xCNCenter">
                        <?php if ($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1) { ?>
                            <th nowrap class="xCNTextBold" style="width:5%;"><?= language('sale/promotiontopup/promotiontopup', 'tTBChoose') ?></th>
                        <?php } ?>
                        <th nowrap class="xCNTextBold"><?= language('sale/promotiontopup/promotiontopup', 'tTBBchCreate') ?></th>
                        <th nowrap class="xCNTextBold"><?= language('sale/promotiontopup/promotiontopup', 'tTBDocNo') ?></th>
                        <th nowrap class="xCNTextBold"><?= language('sale/promotiontopup/promotiontopup', 'tTBDocDate') ?></th>
                        <th nowrap class="xCNTextBold"><?= language('sale/promotiontopup/promotiontopup', 'tPromotionName') ?></th>
                        <th nowrap class="xCNTextBold"><?= language('sale/promotiontopup/promotiontopup', 'tTBStaDoc') ?></th>
                        <!-- <th nowrap class="xCNTextBold"><?= language('sale/promotiontopup/promotiontopup', 'tTBStaPrc') ?></th> -->
                        <!-- <th nowrap class="xCNTextBold"><?= language('sale/promotiontopup/promotiontopup', 'สถานะใช้งาน') ?></th> -->
                        <!-- <th nowrap class="xCNTextBold"><?= language('sale/promotiontopup/promotiontopup', 'สถานะหมดอายุ') ?></th> -->
                        <th nowrap class="xCNTextBold"><?= language('sale/promotiontopup/promotiontopup', 'tTBCreateBy') ?></th>
                        <th nowrap class="xCNTextBold"><?= language('sale/promotiontopup/promotiontopup', 'tTBApvBy') ?></th>
                        <?php if ($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1) { ?>
                            <th nowrap class="xCNTextBold" style="width:5%;"><?= language('common/main/main', 'tCMNActionDelete') ?></th>
                        <?php } ?>
                        <?php if ($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaRead'] == 1) { ?>
                            <th nowrap class="xCNTextBold" style="width:5%;"><?= language('common/main/main', 'tCMNActionEdit') ?></th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody id="odvRGPList">
                    <?php if ($aDataList['rtCode'] == 1) { ?>
                        <?php foreach ($aDataList['raItems'] as $key => $aValue) { ?>
                            <?php
                            $tDocNo = $aValue['FTPmhDocNo'];
                            if ($aValue['FTPmhStaApv'] == 1 || $aValue['FTPmhStaApv'] == 2 || $aValue['FTPmhStaDoc'] == 3) {
                                $CheckboxDisabled = "disabled";
                                $ClassDisabled = 'xCNDocDisabled';
                                $Title = language('document/document/document', 'tDOCMsgCanNotDel');
                                $Onclick = '';
                            } else {
                                $CheckboxDisabled = "";
                                $ClassDisabled = '';
                                $Title = '';
                                $Onclick = "onclick=JSxPTUEventDelDoc('1','" . $tDocNo . "')";
                            }

                            //FTPmhStaDoc
                            if($aValue['FTPmhStaDoc'] == 3){
                                $tClassStaDoc   = 'text-danger';
                                $tStaDoc = language('common/main/main','tStaDoc3');
                            }else if($aValue['FTPmhStaApv'] == 1){
                                $tClassStaDoc   = 'text-success';
                                $tStaDoc = language('common/main/main','tStaDoc1');   
                            }else{
                                $tClassStaDoc   = 'text-warning';
                                $tStaDoc = language('common/main/main','tStaDoc');
                            }

                            // FTPmhStaPrcDoc
                            // if ($aValue['FTPmhStaPrcDoc'] == 1) {
                            //     $tClassPrcStk = 'text-success';
                            //     $tStaPrcDoc = language('common/main/main', 'tStaPrcDoc1');
                            // } else if ($aValue['FTPmhStaPrcDoc'] == 2) {
                            //     $tClassPrcStk = 'text-warning';
                            //     $tStaPrcDoc = language('common/main/main', 'tStaPrcDoc3');
                            // } else if ($aValue['FTPmhStaPrcDoc'] == 0 || $aValue['FTPmhStaPrcDoc'] == '') {
                            //     $tClassPrcStk = 'text-warning';
                            //     $tStaPrcDoc = language('common/main/main', 'tStaPrcDoc3');
                            // }


                            // // FTPmhStaApv
                            // if ($aValue['FTPmhStaApv'] == 1) {
                            //     $tClassPrcStk = 'text-success';
                            // } else if ($aValue['FTPmhStaApv'] == 2) {
                            //     $tClassPrcStk = 'text-warning';
                            // } else if ($aValue['FTPmhStaApv'] == '') {
                            //     $tClassPrcStk = 'text-danger';
                            // }
                        
                            // FTPmhStaClosed,FNPmhStaDocAct,FTPmhStaDoc
                            if ( $aValue['FTPmhStaDoc'] == '1'){ // สมบูรณ์

                                // หาวันที่-เวลา หมดอายุ
                                $dPmhDStop = date('Y-m-d',strtotime($aValue['FDPmhDStop']));
                                $dPmhTStop = date('H:i:s',strtotime($aValue['FTPmhTStop']));
                                $dPmhExp   = date('Y-m-d H:i:s' , strtotime($dPmhDStop.' '.$dPmhTStop));

                                // หาวันที่เริ่มต้น
                                $dPmhDStart = date('Y-m-d',strtotime($aValue['FDPmhDStart']));
                                $tPmhTStart = date('H:i:s',strtotime($aValue['FTPmhTStart']));
                                $dPmhStart  = date('Y-m-d H:i:s' , strtotime($dPmhDStart.' '.$tPmhTStart));

                                // วันที่ปัจจุบัน
                                $dToday     = date('Y-m-d H:i:s');

                                if( $dToday > $dPmhExp ){ // หมดอายุ
                                    $tClassStaUse = 'text-danger';  
                                    $tPmtStaUseShow = language('sale/promotiontopup/promotiontopup', 'tPmhDateExp');
                                }else if( $dToday < $dPmhStart ){ // ยังไม่เริ่ม
                                    $tClassStaUse = 'text-warning';  
                                    $tPmtStaUseShow = language('sale/promotiontopup/promotiontopup', 'tPTUNotStart');
                                }else{
                                    if( $aValue['FTPmhStaClosed'] == '0' ) { // ใช้งาน
                                        $tClassStaUse = 'text-success';  
                                        $tPmtStaUseShow = language('sale/promotiontopup/promotiontopup', 'tActive');
                                    }else{ // หยุดการใช้งาน
                                        $tClassStaUse = 'text-danger';
                                        $tPmtStaUseShow = language('sale/promotiontopup/promotiontopup', 'tPTUStaClosed');
                                    }
                                    
                                }
                            } else { // ยกเลิก
                                $tClassStaUse = 'text-danger';
                                $tPmtStaUseShow = language('sale/promotiontopup/promotiontopup', 'tStaDoc3');
                            }

                            $bIsApproved = ($aValue['FTPmhStaApv'] == 1 || $aValue['FTPmhStaApv'] == 2 || $aValue['FTPmhStaDoc'] == 3);
                            ?>

                            <tr class="text-center xCNTextDetail2" id="otrPTUHD<?= $key ?>" data-code="<?= $aValue['FTPmhDocNo'] ?>" data-name="<?= $aValue['FTPmhDocNo'] ?>">
                                <?php if ($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1) { ?>
                                    <td nowrap class="text-center">
                                        <label class="fancy-checkbox ">
                                            <input id="ocbListItem<?= $key ?>" type="checkbox" class="ocbListItem" name="ocbListItem[]" <?= $CheckboxDisabled ?>>
                                            <span class="<?= $ClassDisabled ?>">&nbsp;</span>
                                        </label>
                                    </td>
                                <?php } ?>
                                <td nowrap class="text-left"><?= $aValue['FTBchName'] != '' ? $aValue['FTBchName'] : '-' ?></td>
                                <td nowrap class="text-left"><?= $aValue['FTPmhDocNo'] != '' ? $aValue['FTPmhDocNo'] : '-' ?></td>
                                <td nowrap class="text-center"><?= $aValue['FDPmhDocDate'] != '' ? date('d/m/Y', strtotime($aValue['FDPmhDocDate'])) : '-' ?></td>
                                <td nowrap class="text-left"><?= $aValue['FTPmhName'] != '' ? $aValue['FTPmhName'] : '-' ?></td>
                                <td nowrap class="text-left"><label class="xCNTDTextStatus <?= $tClassStaDoc ?>"><?php echo $tStaDoc; ?></label></td>
                                <!-- <td nowrap class="text-left"><label class="xCNTDTextStatus <?= $tClassPrcStk ?>"><?php echo $tStaPrcDoc ?></label></td> -->
                                <!-- <td nowrap class="text-left"><label class="xCNTDTextStatus <?= $tClassStaUse ?>"><?php echo $tPmtStaUseShow; ?></label></td> -->
                                <td nowrap class="text-left"><?= $aValue['FTCreateByName'] != '' ? $aValue['FTCreateByName'] : language('sale/promotiontopup/promotiontopup', 'tNull'); ?></td>
                                <td nowrap class="text-left"><?= $aValue['FTXthApvName'] != '' ? $aValue['FTXthApvName'] : language('sale/promotiontopup/promotiontopup', 'tNull'); ?></td>
                                <?php if ($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1) { ?>
                                    <td nowrap>
                                        <img class="xCNIconTable xCNIconDel <?= $ClassDisabled ?>" src="<?= base_url('application/modules/common/assets/images/icons/delete.png') ?>" <?= $Onclick ?> title="<?= $Title ?>">
                                    </td>
                                <?php } ?>
                                <?php if ($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaRead'] == 1) { ?>
                                    <td nowrap>
                                        <?php if($bIsApproved) { ?>
                                            <img class="xCNIconTable" style="width: 17px;" src="<?= base_url('application/modules/common/assets/images/icons/view2.png'); ?>" onClick="JSvPTUCallPageEdit('<?= $aValue['FTPmhDocNo'] ?>')">
                                        <?php }else{ ?>
                                            <img class="xCNIconTable" src="<?= base_url('application/modules/common/assets/images/icons/edit.png') ?>" onClick="JSvPTUCallPageEdit('<?= $aValue['FTPmhDocNo'] ?>')">
                                        <?php } ?>
                                    </td>
                                <?php } ?>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td nowrap class='text-center xCNTextDetail2' colspan='100%'><?= language('common/main/main', 'tCMNNotFoundData') ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php if( $aDataList['rnAllRow'] != 0 ){ ?>
<div class="row">
    <div class="col-md-6">
        <p><?= language('common/main/main', 'tResultTotalRecord') ?> <?= $aDataList['rnAllRow'] ?> <?= language('common/main/main', 'tRecord') ?> <?= language('common/main/main', 'tCurrentPage') ?> <?= $aDataList['rnCurrentPage'] ?> / <?= $aDataList['rnAllPage'] ?></p>
    </div>
    <div class="col-md-6">
        <div class="xWPage btn-toolbar pull-right">
            <?php if ($nPage == 1) {
                $tDisabledLeft = 'disabled';
            } else {
                $tDisabledLeft = '-';
            } ?>
            <button onclick="JSvPTUDataTableClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>>
                <i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
            </button>
            <?php for ($i = max($nPage - 2, 1); $i <= max(0, min($aDataList['rnAllPage'], $nPage + 2)); $i++) { ?>
                <?php
                if ($nPage == $i) {
                    $tActive = 'active';
                    $tDisPageNumber = 'disabled';
                } else {
                    $tActive = '';
                    $tDisPageNumber = '';
                }
                ?>
                <button onclick="JSvPTUDataTableClickPage('<?php echo $i ?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i ?></button>
            <?php } ?>
            <?php if ($nPage >= $aDataList['rnAllPage']) {
                $tDisabledRight = 'disabled';
            } else {
                $tDisabledRight = '-';
            } ?>
            <button onclick="JSvPTUDataTableClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>>
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>
<?php } ?>

<div class="modal fade" id="odvModalDel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?= language('common/main/main', 'tModalDelete') ?></label>
            </div>
            <div class="modal-body">
                <span id="ospConfirmDelete"> - </span>
                <input type='hidden' id="ohdConfirmIDDelete">
            </div>
            <div class="modal-footer">
                <button id="osmConfirm" onClick="JSxPTUEventDelDoc('2','')" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button">
                    <?= language('common/main/main', 'tModalConfirm') ?>
                </button>
                <button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button" data-dismiss="modal">
                    <?= language('common/main/main', 'tModalCancel') ?>
                </button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('.ocbListItem').click(function() {
        var nCode = $(this).parent().parent().parent().data('code'); // code
        var tName = $(this).parent().parent().parent().data('name'); // code
        $(this).prop('checked', true);
        var LocalItemData = localStorage.getItem("LocalItemData");
        var obj = [];
        if (LocalItemData) {
            obj = JSON.parse(LocalItemData);
        } else {}
        var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
        if (aArrayConvert == '' || aArrayConvert == null) {
            obj.push({
                "nCode": nCode,
                "tName": tName
            });
            localStorage.setItem("LocalItemData", JSON.stringify(obj));
            JSxTextinModal();
        } else {
            var aReturnRepeat = findObjectByKey(aArrayConvert[0], 'nCode', nCode);
            if (aReturnRepeat == 'None') { // ยังไม่ถูกเลือก
                obj.push({
                    "nCode": nCode,
                    "tName": tName
                });
                localStorage.setItem("LocalItemData", JSON.stringify(obj));
                JSxTextinModal();
            } else if (aReturnRepeat == 'Dupilcate') { // เคยเลือกไว้แล้ว
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
                JSxTextinModal();
            }
        }
        JSxShowButtonChoose();
    })
</script>